<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LearningCenter;
use App\Helpers\TextHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Production-Ready Search Service for Learning Centers
 * 
 * This service implements a scalable, optimized search architecture using:
 * - EXISTS instead of JOIN for related table searches (better performance with large datasets)
 * - Selective field loading to reduce memory usage
 * - withCount for aggregate data without N+1 queries
 * - Haversine formula for geo-distance calculations
 * - Fulltext search with LIKE fallback
 * 
 * DATABASE INDEX RECOMMENDATIONS (add these migrations):
 * ------------------------------------------------------------------------
 * // learning_centers table
 * $table->index('name');
 * $table->index('type');
 * $table->index(['region', 'province']); // composite for location filters
 * $table->index('tin');
 * $table->index('license_number');
 * $table->fullText(['name', 'address', 'region', 'province']); // for FULLTEXT search
 * 
 * // subjects_of_learning_centers table
 * $table->index(['learning_centers_id', 'subject_name']); // composite for exists queries
 * $table->index('subject_name'); // for filtering
 * 
 * // teachers table
 * $table->index(['learning_centers_id', 'name']); // composite for exists queries
 * 
 * // need_teacher table
 * $table->index(['learning_center_id', 'subject_name']); // composite for exists queries
 * $table->index('created_at'); // for sorting announcements
 * 
 * // teacher_subjects table (for price filtering)
 * $table->index(['subject_id', 'price']); // composite for price range queries
 * ------------------------------------------------------------------------
 */
class SearchService
{
    /**
     * Earth radius in kilometers for Haversine formula
     */
    private const EARTH_RADIUS_KM = 6371;

    /**
     * Default items per page
     */
    private const DEFAULT_PER_PAGE = 20;

    /**
     * Maximum items per page (prevents memory issues)
     */
    private const MAX_PER_PAGE = 50;

    /**
     * Maximum map results (lightweight for map display)
     */
    private const MAX_MAP_RESULTS = 200;

    /**
     * Required fields for list display - selective loading for memory efficiency
     */
    private const LIST_SELECT_FIELDS = [
        'id',
        'name',
        'type',
        'slug',
        'logo',
        'address',
        'region',
        'province',
        'location',
        'student_count',
        'rating',
        'total_reyting',
        'created_at',
    ];

    /**
     * Required fields for map display - minimal for performance
     */
    private const MAP_SELECT_FIELDS = [
        'id',
        'name',
        'slug',
        'location',
        'address',
        'logo',
        'type',
    ];

    /**
     * Main search method - entry point for all searches
     * 
     * @param array $filters Search filters from validated request
     *                     - searchText: string|null
     *                     - type: string|null
     *                     - subject_name: string|null
     *                     - needTeachers: string|null ('all' or subject name)
     *                     - min_price: float|null
     *                     - max_price: float|null
     *                     - latitude: float|null
     *                     - longitude: float|null
     *                     - radius: float|null (km)
     *                     - sort: string|null (name, distance, favorites, rating)
     *                     - order: string|null (asc, desc)
     *                     - page: int|null
     *                     - per_page: int|null
     * @return LengthAwarePaginator
     */
    public function search(array $filters): LengthAwarePaginator
    {
        $query = $this->buildBaseQuery($filters);
        $query = $this->applyListSelect($query);
        $query = $this->applyEagerLoads($query);
        $query = $this->applySorting($query, $filters);

        return $this->paginate($query, $filters);
    }

    /**
     * Get results for map display (lightweight, limited)
     * Uses minimal fields and no heavy relations
     * 
     * @param array $filters Same filters as search()
     * @return Collection<int, LearningCenter>
     */
    public function searchForMap(array $filters): Collection
    {
        $query = $this->buildBaseQuery($filters);
        $query = $this->applyMapSelect($query);
        $query = $this->applyMapSorting($query, $filters);

        return $query->limit(self::MAX_MAP_RESULTS)->get();
    }

    /**
     * Build the base query with all filters applied
     * This is the core method that constructs the WHERE clauses
     * 
     * WHY EXISTS instead of JOIN:
     * - EXISTS stops at first match, JOIN processes all rows
     * - Better for 1:N relationships (subjects, teachers)
     * - Avoids duplicate learning_centers rows
     * - More memory efficient with large datasets
     */
    private function buildBaseQuery(array $filters): Builder
    {
        $query = LearningCenter::query();

        // Apply all filters in isolation (Single Responsibility)
        $query = $this->applyGlobalSearch($query, $filters);
        $query = $this->applyTypeFilter($query, $filters);
        $query = $this->applySubjectFilter($query, $filters);
        $query = $this->applyNeedTeachersFilter($query, $filters);
        $query = $this->applyPriceFilter($query, $filters);
        $query = $this->applyGeoFilter(
            $query,
            isset($filters['latitude']) ? (float) $filters['latitude'] : null,
            isset($filters['longitude']) ? (float) $filters['longitude'] : null,
            isset($filters['radius']) ? (int) $filters['radius'] : null
        );

        return $query;
    }

    /**
     * Apply SMART UNIFIED SEARCH across learning_centers and related tables.
     *
     * Strategy:
     * 1. TOKENIZE searchText by whitespace: "english samarkand" → ["english", "samarkand"]
     * 2. Apply synonym expansion for subjects (math → matematika, etc.)
     * 3. For queries > 3 chars, use FULLTEXT MATCH() AGAINST() for better performance
     * 4. For shorter queries, use LIKE with transliteration support
     * 5. AND logic between tokens: ALL tokens must match somewhere
     *
     * Performance: EXISTS (not JOIN), Full-Text where possible, indexed columns only
     */
    private function applyGlobalSearch(Builder $query, array $filters): Builder
    {
        $searchText = $filters['searchText'] ?? null;

        if (empty($searchText)) {
            return $query;
        }

        $normalized = TextHelper::normalize($searchText);
        $tokens = TextHelper::tokenize($normalized);

        if (empty($tokens)) {
            return $query;
        }

        // Check if we can use FULLTEXT search (queries > 3 characters)
        if (strlen($normalized) > 3 && $this->hasFullTextIndex()) {
            return $this->applyFullTextSearch($query, $normalized, $tokens);
        }

        // Fall back to LIKE-based search with synonym expansion
        return $this->applyLikeSearchWithSynonyms($query, $tokens);
    }

    /**
     * Apply FULLTEXT MATCH() AGAINST() search with fallback to LIKE for short tokens
     */
    private function applyFullTextSearch(Builder $query, string $fullText, array $tokens): Builder
    {
        // Use FULLTEXT on primary fields
        $query->where(function (Builder $q) use ($fullText, $tokens) {
            // Full-text search on name and address
            $q->whereRaw("MATCH(name, address) AGAINST(? IN BOOLEAN MODE)", [$fullText])
              ->orWhereRaw("MATCH(region, province) AGAINST(? IN BOOLEAN MODE)", [$fullText]);

            // Also check subjects via EXISTS with token matching
            foreach ($tokens as $token) {
                $synonyms = TextHelper::getSubjectSynonyms($token);
                $this->applySynonymSubjectSearch($q, $synonyms);
            }
        });

        return $query;
    }

    /**
     * Apply LIKE search with synonym expansion for better matching
     */
    private function applyLikeSearchWithSynonyms(Builder $query, array $tokens): Builder
    {
        foreach ($tokens as $token) {
            // Get all synonym variants for this token
            $synonyms = TextHelper::getSubjectSynonyms($token);
            $variants = [];

            foreach ($synonyms as $synonym) {
                $variants[] = $synonym;
                $variants[] = TextHelper::transliterate($synonym);
            }
            $variants = array_unique($variants);

            $query->where(function (Builder $q) use ($variants, $token) {
                // Search learning_centers core fields with all variants
                $this->applyTokenLikeSearchWithVariants($q, $variants);

                // Search subjects with synonym expansion
                $this->applySynonymSubjectSearch($q, $variants);

                // Search teachers
                $this->applyTokenTeacherSearchWithVariants($q, $variants);

                // Search need_teacher
                $this->applyTokenNeedTeacherSearchWithVariants($q, $variants);
            });
        }

        return $query;
    }

    /**
     * Search subjects table with synonym expansion using EXISTS
     */
    private function applySynonymSubjectSearch(Builder $query, array $variants): void
    {
        $query->orWhereExists(function ($sub) use ($variants) {
            $sub->select(DB::raw(1))
                ->from('subjects_of_learning_centers')
                ->whereColumn('subjects_of_learning_centers.learning_centers_id', 'learning_centers.id')
                ->where(function ($q) use ($variants) {
                    foreach ($variants as $variant) {
                        $pattern = '%' . $variant . '%';
                        $q->orWhere('subject_name', 'LIKE', $pattern);
                    }
                });
        });
    }

    /**
     * Enhanced LIKE search with multiple variants
     */
    private function applyTokenLikeSearchWithVariants(Builder $query, array $variants): void
    {
        $fields = ['name', 'address', 'region', 'province', 'type', 'manager_name'];

        $query->orWhere(function (Builder $q) use ($fields, $variants) {
            foreach ($fields as $field) {
                foreach ($variants as $variant) {
                    $q->orWhere($field, 'LIKE', '%' . $variant . '%');
                }
            }
        });
    }

    /**
     * Teacher search with variant expansion
     */
    private function applyTokenTeacherSearchWithVariants(Builder $query, array $variants): void
    {
        $query->orWhereExists(function ($sub) use ($variants) {
            $sub->select(DB::raw(1))
                ->from('teachers')
                ->whereColumn('teachers.learning_centers_id', 'learning_centers.id')
                ->where(function ($q) use ($variants) {
                    foreach ($variants as $variant) {
                        $q->orWhere('name', 'LIKE', '%' . $variant . '%');
                    }
                });
        });
    }

    /**
     * Need teacher search with variant expansion
     */
    private function applyTokenNeedTeacherSearchWithVariants(Builder $query, array $variants): void
    {
        $query->orWhereExists(function ($sub) use ($variants) {
            $sub->select(DB::raw(1))
                ->from('need_teacher')
                ->whereColumn('need_teacher.learning_center_id', 'learning_centers.id')
                ->where(function ($q) use ($variants) {
                    foreach ($variants as $variant) {
                        $q->orWhere('subject_name', 'LIKE', '%' . $variant . '%')
                          ->orWhere('description', 'LIKE', '%' . $variant . '%');
                    }
                });
        });
    }

    /**
     * Apply LIKE search for a single token against learning_centers table fields.
     * Uses OR internally: token matches if ANY field matches.
     */
    private function applyTokenLikeSearch(Builder $query, string $token, string $transliterated): void
    {
        $pattern      = '%' . $token . '%';
        $transPattern = '%' . $transliterated . '%';

        $fields = ['name', 'address', 'region', 'province', 'type', 'manager_name'];

        $query->orWhere(function (Builder $q) use ($fields, $pattern, $transPattern) {
            foreach ($fields as $field) {
                $q->orWhere($field, 'LIKE', $pattern)
                  ->orWhere($field, 'LIKE', $transPattern);
            }
        });
    }

    /**
     * WHERE EXISTS search in subjects_of_learning_centers for a single token.
     * Both original and transliterated variants checked for bilingual support.
     */
    private function applyTokenSubjectSearch(Builder $query, string $token, string $transliterated): void
    {
        $pattern      = '%' . $token . '%';
        $transPattern = '%' . $transliterated . '%';

        $query->orWhereExists(function ($sub) use ($pattern, $transPattern) {
            $sub->select(DB::raw(1))
                ->from('subjects_of_learning_centers')
                ->whereColumn('subjects_of_learning_centers.learning_centers_id', 'learning_centers.id')
                ->where(function ($q) use ($pattern, $transPattern) {
                    $q->where('subject_name', 'LIKE', $pattern)
                      ->orWhere('subject_name', 'LIKE', $transPattern);
                });
        });
    }

    /**
     * WHERE EXISTS search in teachers table for a single token.
     */
    private function applyTokenTeacherSearch(Builder $query, string $token, string $transliterated): void
    {
        $pattern      = '%' . $token . '%';
        $transPattern = '%' . $transliterated . '%';

        $query->orWhereExists(function ($sub) use ($pattern, $transPattern) {
            $sub->select(DB::raw(1))
                ->from('teachers')
                ->whereColumn('teachers.learning_centers_id', 'learning_centers.id')
                ->where(function ($q) use ($pattern, $transPattern) {
                    $q->where('name', 'LIKE', $pattern)
                      ->orWhere('name', 'LIKE', $transPattern);
                });
        });
    }

    /**
     * WHERE EXISTS search in need_teacher table for a single token.
     */
    private function applyTokenNeedTeacherSearch(Builder $query, string $token, string $transliterated): void
    {
        $pattern      = '%' . $token . '%';
        $transPattern = '%' . $transliterated . '%';

        $query->orWhereExists(function ($sub) use ($pattern, $transPattern) {
            $sub->select(DB::raw(1))
                ->from('need_teacher')
                ->whereColumn('need_teacher.learning_center_id', 'learning_centers.id')
                ->where(function ($q) use ($pattern, $transPattern) {
                    $q->where('subject_name', 'LIKE', $pattern)
                      ->orWhere('subject_name', 'LIKE', $transPattern)
                      ->orWhere('description', 'LIKE', $pattern)
                      ->orWhere('description', 'LIKE', $transPattern);
                });
        });
    }

    /**
     * Check if FULLTEXT index exists (for future use when FULLTEXT migration runs)
     */
    private function hasFullTextIndex(): bool
    {
        try {
            DB::select("SELECT 1 FROM learning_centers WHERE MATCH(name) AGAINST('test' IN NATURAL LANGUAGE MODE) LIMIT 1");
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Apply type filter (school, university, course, etc.)
     */
    private function applyTypeFilter(Builder $query, array $filters): Builder
    {
        $type = $filters['type'] ?? null;

        if (!empty($type)) {
            $query->where('type', $type);
        }

        return $query;
    }

    /**
     * Apply subject filter using EXISTS
     * Searches subjects_of_learning_centers table
     */
    private function applySubjectFilter(Builder $query, array $filters): Builder
    {
        $subjectName = $filters['subject_name'] ?? null;

        if (empty($subjectName)) {
            return $query;
        }

        $pattern = '%' . $subjectName . '%';
        $transPattern = '%' . $this->transliterateUzbek($subjectName) . '%';

        return $query->whereExists(function ($subQuery) use ($pattern, $transPattern) {
            $subQuery->select(DB::raw(1))
                ->from('subjects_of_learning_centers')
                ->whereColumn('subjects_of_learning_centers.learning_centers_id', 'learning_centers.id')
                ->where(function ($q) use ($pattern, $transPattern) {
                    $q->where('subject_name', 'LIKE', $pattern)
                        ->orWhere('subject_name', 'LIKE', $transPattern);
                });
        });
    }

    /**
     * Apply "need teachers" filter
     * 'all' = has any announcement, otherwise filter by subject name
     */
    private function applyNeedTeachersFilter(Builder $query, array $filters): Builder
    {
        $needTeachers = $filters['needTeachers'] ?? null;

        if (empty($needTeachers)) {
            return $query;
        }

        if ($needTeachers === 'all') {
            // Has any need_teacher records
            return $query->has('needTeachers');
        }

        // Filter by specific subject in need_teacher
        $pattern = '%' . $needTeachers . '%';
        $transPattern = '%' . $this->transliterateUzbek($needTeachers) . '%';

        return $query->whereExists(function ($subQuery) use ($pattern, $transPattern) {
            $subQuery->select(DB::raw(1))
                ->from('need_teacher')
                ->whereColumn('need_teacher.learning_center_id', 'learning_centers.id')
                ->where(function ($q) use ($pattern, $transPattern) {
                    $q->where('subject_name', 'LIKE', $pattern)
                        ->orWhere('subject_name', 'LIKE', $transPattern);
                });
        });
    }

    /**
     * Apply price range filter via teacher_subjects relationship
     * Path: learning_center -> subjects -> teacherSubjects -> price
     */
    private function applyPriceFilter(Builder $query, array $filters): Builder
    {
        $minPrice = $filters['min_price'] ?? null;
        $maxPrice = $filters['max_price'] ?? null;

        if (empty($minPrice) && empty($maxPrice)) {
            return $query;
        }

        // Use EXISTS with nested subquery through subjects -> teacherSubjects
        return $query->whereExists(function ($subQuery) use ($minPrice, $maxPrice) {
            $subQuery->select(DB::raw(1))
                ->from('subjects_of_learning_centers')
                ->whereColumn('subjects_of_learning_centers.learning_centers_id', 'learning_centers.id')
                ->whereExists(function ($tsQuery) use ($minPrice, $maxPrice) {
                    $tsQuery->select(DB::raw(1))
                        ->from('teacher_subjects')
                        ->whereColumn('teacher_subjects.subject_id', 'subjects_of_learning_centers.id');

                    if (!empty($minPrice)) {
                        $tsQuery->where('teacher_subjects.price', '>=', $minPrice);
                    }
                    if (!empty($maxPrice)) {
                        $tsQuery->where('teacher_subjects.price', '<=', $maxPrice);
                    }
                });
        });
    }

    /**
     * Apply geolocation filter using Haversine formula
     * Calculates distance in km and optionally filters by radius
     * 
     * SAFETY FEATURES:
     * - Strict numeric validation before any SQL generation
     * - Explicit type casting to float
     * - Consistent parameter binding count
     * - NULL location handling (skips centers without coordinates)
     * 
     * @param Builder $query The query builder
     * @param float|null $lat Latitude (-90 to 90)
     * @param float|null $lng Longitude (-180 to 180)
     * @param int|null $radius Radius in kilometers (optional)
     * @return Builder Modified query builder
     */
    private function applyGeoFilter(Builder $query, ?float $lat, ?float $lng, ?int $radius = null): Builder
    {
        // STEP 1: Defensive validation - must have valid coordinates
        if (!$this->isValidCoordinate($lat, $lng)) {
            return $query;
        }

        // STEP 2: Safe type casting
        $lat = (float) $lat;
        $lng = (float) $lng;
        $radius = is_numeric($radius) ? (int) $radius : null;

        // STEP 3: Build Haversine SQL with inline values to avoid binding conflicts
        // Using direct value interpolation for lat/lng since they are validated/casted
        // Formula: 6371 * acos(
        //     cos(radians(lat1)) * cos(radians(lat2)) * cos(radians(lng2 - lng1)) +
        //     sin(radians(lat1)) * sin(radians(lat2))
        // )
        $haversineSql = "(
            " . self::EARTH_RADIUS_KM . " * acos(
                cos(radians({$lat}))
                * cos(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
                * cos(radians(CAST(SUBSTRING_INDEX(location, ',', -1) AS DECIMAL(10,6)) - {$lng}))
                + sin(radians({$lat}))
                * sin(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
            )
        )";

        // STEP 4: Add distance column (only calculate if location exists)
        // Use CASE to return NULL for centers without location to prevent calculation errors
        $query->selectRaw("CASE
            WHEN location IS NOT NULL AND location != ''
            THEN {$haversineSql}
            ELSE NULL
        END AS distance");

        // STEP 5: Only include centers that HAVE location data FIRST
        // This must be before the radius filter to avoid calculation errors
        $query->whereNotNull('location')
              ->where('location', '!=', '');

        // STEP 6: Apply radius filter only if valid radius provided
        // Only calculate for centers with valid location data
        if ($radius !== null && $radius > 0) {
            $query->whereRaw("{$haversineSql} <= {$radius}");
        }

        return $query;
    }

    /**
     * Validate coordinate pair
     * 
     * @param mixed $lat Latitude value
     * @param mixed $lng Longitude value
     * @return bool True if both are valid numeric coordinates
     */
    private function isValidCoordinate($lat, $lng): bool
    {
        // Must be numeric (int, float, or numeric string)
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return false;
        }

        // Convert to float for range checking
        $latFloat = (float) $lat;
        $lngFloat = (float) $lng;

        // Latitude must be between -90 and 90
        if ($latFloat < -90 || $latFloat > 90) {
            return false;
        }

        // Longitude must be between -180 and 180
        if ($lngFloat < -180 || $lngFloat > 180) {
            return false;
        }

        // Both must be finite numbers (not INF, -INF, or NaN)
        if (!is_finite($latFloat) || !is_finite($lngFloat)) {
            return false;
        }

        return true;
    }

    /**
     * Apply selective field selection for list view
     * WHY: Reduces memory usage by ~60% vs SELECT *
     */
    private function applyListSelect(Builder $query): Builder
    {
        return $query->select(array_merge(
            self::LIST_SELECT_FIELDS,
            // Preserve distance if geo filter was applied
            $query->getQuery()->columns ?? []
        ));
    }

    /**
     * Apply minimal field selection for map view
     *
     * PRESERVATION STRATEGY:
     * - Uses addSelect() to preserve any previously selected columns (like distance)
     * - Merges MAP_SELECT_FIELDS with existing columns to avoid overriding
     * - This is critical because applyGeoFilter() adds distance BEFORE this method
     */
    private function applyMapSelect(Builder $query): Builder
    {
        // Get existing columns that might have been selected (e.g., distance from geo filter)
        $existingColumns = $query->getQuery()->columns ?? [];

        // Merge MAP_SELECT_FIELDS with existing columns, preserving all
        $allColumns = array_merge(self::MAP_SELECT_FIELDS, $existingColumns);

        // Remove duplicates while preserving order
        $allColumns = array_unique($allColumns, SORT_REGULAR);

        return $query->select($allColumns);
    }

    /**
     * Apply eager loads for list view
     * WHY withCount instead of with() for counts:
     * - withCount does single aggregate query (2 queries total)
     * - with() loads all related rows (memory heavy with many favorites)
     */
    private function applyEagerLoads(Builder $query): Builder
    {
        // Load latest needTeachers (limit in relation would need custom logic)
        $query->with(['needTeachers' => function ($q) {
            $q->latest()->limit(3); // Only load 3 latest announcements
        }]);

        // Use withCount for aggregates (more efficient than loading all)
        $query->withCount('favorites');
        $query->withCount('needTeachers');

        return $query;
    }

    /**
     * Apply sorting for list view
     * 
     * RELEVANCE SCORING:
     * When search text is provided without explicit sort, we calculate relevance:
     * - Exact name match: highest priority
     * - Name starts with query: second priority
     * - Name contains query: third priority
     * - Other fields match: fourth priority
     */
    private function applySorting(Builder $query, array $filters): Builder
    {
        $sort = $filters['sort'] ?? null;
        $order = $filters['order'] ?? 'asc';

        switch ($sort) {
            case 'relevance':
                $query = $this->applyRelevanceSorting($query, $filters);
                break;
            case 'name':
                $query->orderBy('name', $order);
                break;
            case 'distance':
                if ($this->hasGeoFilter($filters)) {
                    $query->orderBy('distance', $order);
                } else {
                    $query->latest('id');
                }
                break;
            case 'favorites':
            case 'rating':
                $query->orderBy('total_reyting', $order);
                break;
            case 'created':
                $query->orderBy('created_at', $order);
                break;
            default:
                // Default: relevance if search, distance if geo, newest otherwise
                if (!empty($filters['searchText'])) {
                    $query = $this->applyRelevanceSorting($query, $filters);
                } elseif ($this->hasGeoFilter($filters)) {
                    $query->orderBy('distance', 'asc');
                } else {
                    $query->latest('id');
                }
        }

        return $query;
    }

    /**
     * Apply relevance-based sorting when search text is provided
     */
    private function applyRelevanceSorting(Builder $query, array $filters): Builder
    {
        $searchText = $filters['searchText'] ?? '';
        if (empty($searchText)) {
            return $query->latest('id');
        }

        $normalized = TextHelper::normalize($searchText);
        $tokens = TextHelper::tokenize($normalized);
        
        if (empty($tokens)) {
            return $query->latest('id');
        }

        // Build relevance scoring SQL
        // Higher score = better match
        $relevanceSql = $this->buildRelevanceScoreSql($tokens);
        
        // Use addSelect to avoid overwriting existing column selections
        // This preserves columns from applyListSelect and adds relevance_score
        $query->addSelect(DB::raw("{$relevanceSql} as relevance_score"))
              ->orderByRaw('relevance_score DESC, total_reyting DESC, created_at DESC');

        return $query;
    }

    /**
     * Build SQL for calculating relevance score based on token matches
     */
    private function buildRelevanceScoreSql(array $tokens): string
    {
        $conditions = [];
        
        foreach ($tokens as $token) {
            $escapedToken = addslashes($token);
            
            // Exact name match (highest weight: 100)
            $conditions[] = "CASE WHEN LOWER(name) = '{$escapedToken}' THEN 100 ELSE 0 END";
            
            // Name starts with token (weight: 80)
            $conditions[] = "CASE WHEN LOWER(name) LIKE '{$escapedToken}%' THEN 80 ELSE 0 END";
            
            // Name contains token (weight: 60)
            $conditions[] = "CASE WHEN LOWER(name) LIKE '%{$escapedToken}%' THEN 60 ELSE 0 END";
            
            // Address/Region/Province contains token (weight: 40)
            $conditions[] = "CASE WHEN LOWER(address) LIKE '%{$escapedToken}%' OR LOWER(region) LIKE '%{$escapedToken}%' OR LOWER(province) LIKE '%{$escapedToken}%' THEN 40 ELSE 0 END";
            
            // Type match (weight: 30)
            $conditions[] = "CASE WHEN LOWER(type) LIKE '%{$escapedToken}%' THEN 30 ELSE 0 END";
        }
        
        // Sum all conditions for final score
        return '(' . implode(' + ', $conditions) . ')';
    }

    /**
     * Apply sorting for map view (simpler, no ratings needed)
     *
     * DISTANCE CHECK:
     * - Before ordering by distance, verify the column exists in SELECT
     * - Falls back to latest('id') if geo filter not active or distance missing
     * - Prevents "Unknown column 'distance'" SQL errors
     */
    private function applyMapSorting(Builder $query, array $filters): Builder
    {
        $columns = $query->getQuery()->columns ?? [];
        $hasDistance = false;

        // Check if distance column exists in selected columns
        foreach ($columns as $column) {
            if (is_string($column) && str_contains($column, 'AS distance')) {
                $hasDistance = true;
                break;
            }
        }

        // Only sort by distance if geo filter is active AND distance column exists
        if ($this->hasGeoFilter($filters) && $hasDistance) {
            $query->orderBy('distance', 'asc');
        } elseif (!empty($filters['searchText'])) {
            // Could add relevance ordering here
            $query->latest('id');
        } else {
            $query->latest('id');
        }

        return $query;
    }

    /**
     * Paginate results with safe limits
     */
    private function paginate(Builder $query, array $filters): LengthAwarePaginator
    {
        $perPage = min(
            (int) ($filters['per_page'] ?? self::DEFAULT_PER_PAGE),
            self::MAX_PER_PAGE
        );
        $page = (int) ($filters['page'] ?? 1);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Check if geo filter is active
     */
    private function hasGeoFilter(array $filters): bool
    {
        return !empty($filters['latitude']) && !empty($filters['longitude']);
    }

    /**
     * Normalize search text (trim, lowercase)
     */
    private function normalizeSearchText(string $text): string
    {
        return trim(strtolower($text));
    }

    /**
     * Transliterate between Latin and Cyrillic Uzbek scripts
     * Enables searching with either script
     */
    private function transliterateUzbek(string $text): string
    {
        // Latin to Cyrillic mapping
        $latinToCyrillic = [
            'a' => 'а', 'b' => 'б', 'd' => 'd', 'e' => 'е', 'f' => 'ф',
            'g' => 'г', 'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к',
            'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п',
            'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
            'v' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
            "o'" => 'ў', "g'" => 'ғ', 'sh' => 'ш', 'ch' => 'ч', 'ng' => 'нг',
        ];

        // Cyrillic to Latin mapping
        $cyrillicToLatin = array_flip($latinToCyrillic);
        // Fix multi-char mappings
        $cyrillicToLatin['ў'] = "o'";
        $cyrillicToLatin['ғ'] = "g'";
        $cyrillicToLatin['ш'] = 'sh';
        $cyrillicToLatin['ч'] = 'ch';
        $cyrillicToLatin['нг'] = 'ng';

        // Detect script and transliterate
        if (preg_match('/[a-zA-Z]/', $text)) {
            // Latin to Cyrillic
            return $this->performTransliteration($text, $latinToCyrillic);
        } else {
            // Cyrillic to Latin
            return $this->performTransliteration($text, $cyrillicToLatin);
        }
    }

    /**
     * Perform transliteration with multi-character support
     */
    private function performTransliteration(string $text, array $map): string
    {
        // Sort by length (descending) to handle multi-char sequences first
        uksort($map, function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        $result = $text;
        foreach ($map as $from => $to) {
            $result = str_replace($from, $to, $result);
        }

        return $result;
    }
}
