<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\SearchService;
use App\Services\AiSearchService;
use App\Models\Favorite;
use App\Models\LearningCenter;
use App\Models\LearningCentersCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

use function PHPUnit\Framework\isNull;

class PageController extends Controller
{
    /**
     * Transliterate between Latin and Cyrillic Uzbek scripts
     */
    private function transliterate($text)
    {
        $latinToCyrillic = [
            'a' => 'а',
            'b' => 'б',
            'd' => 'д',
            'e' => 'е',
            'f' => 'ф',
            'g' => 'г',
            'h' => 'ҳ',
            'i' => 'и',
            'j' => 'ж',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'q' => 'қ',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'v' => 'в',
            'x' => 'х',
            'y' => 'й',
            'z' => 'з',
            'o\'' => 'ў',
            'g\'' => 'ғ',
            'sh' => 'ш',
            'ch' => 'ч',
            'ng' => 'нг'
        ];

        $cyrillicToLatin = [
            'а' => 'a',
            'б' => 'b',
            'д' => 'd',
            'е' => 'e',
            'ф' => 'f',
            'г' => 'g',
            'ҳ' => 'h',
            'и' => 'i',
            'ж' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'қ' => 'q',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'в' => 'v',
            'х' => 'x',
            'й' => 'y',
            'з' => 'z',
            'ў' => 'o\'',
            'ғ' => 'g\'',
            'ш' => 'sh',
            'ч' => 'ch',
            'нг' => 'ng'
        ];

        // Check if text contains Latin characters
        if (preg_match('/[a-zA-Z]/', $text)) {
            // Transliterate to Cyrillic
            $result = $text;
            foreach ($latinToCyrillic as $latin => $cyrillic) {
                $result = str_replace($latin, $cyrillic, $result);
            }
            return $result;
        } else {
            // Transliterate to Latin
            $result = $text;
            foreach ($cyrillicToLatin as $cyrillic => $latin) {
                $result = str_replace($cyrillic, $latin, $result);
            }
            return $result;
        }
    }
    public function index()
    {
        // Cache popular courses and categories for 60 minutes
        $centers = Cache::remember('popular_courses', 60, function () {
            return LearningCenter::with(['user', 'images'])
                ->where('status', 'active')
                ->orderBy('rating', 'desc')
                ->limit(8)
                ->get();
        });

        $types = Cache::remember('course_types', 60, function () {
            return LearningCenter::distinct()
                ->pluck('type')
                ->filter()
                ->sort()
                ->values();
        });

        return view('pages.index', compact('centers', 'types'));
    }
    /**
     * Main search/grid view - refactored to use SearchService
     * All heavy logic moved to SearchService for clean architecture
     */
    public function centers(Request $request, SearchService $searchService)
    {
        $validated = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric',
            'searchText' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'name' => 'nullable|in:asc,desc',
            'distance' => 'nullable|in:asc,desc',
            'favorites' => 'nullable|in:asc,desc',
            'sort' => 'nullable|in:name,distance,favorites,rating,created',
            'order' => 'nullable|in:asc,desc',
            'checked' => 'nullable|in:0,1',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'dayMode' => 'nullable|in:true',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        // -------------------------------------------------------
        // OPTIONAL AI ENHANCEMENT (never breaks search if AI fails)
        // -------------------------------------------------------
        $aiFilters = [];
        try {
            if (!empty($validated['searchText'])) {
                /** @var AiSearchService $aiService */
                $aiService = app(AiSearchService::class);
                $aiFilters = $aiService->parse($validated['searchText']);
            }
        } catch (\Throwable $e) {
            // AI failed silently — proceed with normal database search
            $aiFilters = [];
        }

        // -------------------------------------------------------
        // Delegate all search logic to SearchService (clean controller)
        // AI filters are merged but user-submitted values always win.
        // -------------------------------------------------------
        $filters = array_merge(
            $aiFilters,     // AI suggestions (lowest priority)
            $validated,     // Explicit user filters (always override AI)
            [
                'order' => $validated['order'] ?? (
                    !empty($validated['name']) ? $validated['name'] :
                    (!empty($validated['distance']) ? $validated['distance'] :
                        (!empty($validated['favorites']) ? $validated['favorites'] : 'asc'))
                ),
            ]
        );

        // Get paginated results
        try {
            $paginator = $searchService->search($filters);
            $LearningCenters = collect($paginator->items());
        } catch (\Exception $e) {
            \Log::error('Search error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            // Return JSON error for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'trace' => app()->environment('local') ? $e->getTraceAsString() : null,
                ], 500);
            }

            throw $e;
        }

        // Get lightweight map results
        $centersForMap = $searchService->searchForMap($filters)
            ->map(function ($center) {
                $coords = [];
                if (!empty($center->location) && is_string($center->location)) {
                    $coords = array_map('trim', explode(',', $center->location));
                }

                $image = null;
                if (!empty($center->logo)) {
                    $image = (str_starts_with($center->logo, 'http://') || str_starts_with($center->logo, 'https://'))
                        ? $center->logo
                        : asset('storage/' . $center->logo);
                }

                return [
                    'id' => $center->id,
                    'slug' => $center->slug,
                    'name' => $center->name,
                    'lat' => (float) ($coords[0] ?? 0),
                    'lng' => (float) ($coords[1] ?? 0),
                    'address' => $center->address ?? '',
                    'image' => $image,
                    'detail_url' => !empty($center->slug) ? route('center', $center->slug) : '#',
                ];
            })->values()->all();

        // Build pagination metadata
        $pagination = [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];

        // Enhance center data for display
        foreach ($LearningCenters as $center) {
            $center->display_rating = $center->calculated_total_reyting;
            $center->date = $center->created_at->diffForHumans();
            if (isset($center->distance)) {
                $center->distance = round((float) $center->distance, 2);
            }
        }

        $userLocation = null;
        if (!empty($validated['latitude']) && !empty($validated['longitude'])) {
            $userLocation = [
                'latitude' => (float) $validated['latitude'],
                'longitude' => (float) $validated['longitude'],
            ];
        }

        // -------------------------------------------------------
        // AJAX response with HTML rendering
        // -------------------------------------------------------
        if ($request->ajax() || $request->wantsJson()) {
            $html = $this->renderCentersHtml($LearningCenters);

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $LearningCenters->count(),
                'centers' => $centersForMap,
                'pagination' => $pagination,
            ]);
        }

        // Load filter options
        $types = LearningCenter::distinct()->pluck('type')->filter()->sort()->values();
        $subjects = collect([]);

        // Get typo suggestion if no results
        $typoSuggestion = null;
        if ($paginator->total() === 0 && !empty($validated['searchText'])) {
            $typoSuggestion = TextHelper::getTypoSuggestion($validated['searchText']);
        }

        return view('pages.centers', compact(
            'LearningCenters',
            'validated',
            'pagination',
            'types',
            'userLocation',
            'centersForMap',
            'subjects',
            'typoSuggestion'
        ));
    }

    /**
     * Render HTML for centers (extracted for AJAX response)
     */
    private function renderCentersHtml($centers): string
    {
        if ($centers->isEmpty()) {
            return '<div class="col-span-full text-center py-12">
                <div class="relative max-w-lg mx-auto">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-20 blur"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 text-center border border-gray-100 dark:border-gray-700">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">' . __('centers.centers_grid.no_centers_found') . '</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">' . __('centers.centers_grid.try_adjusting') . '</p>
                        <button onclick="clearAllFilters()" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">' . __('centers.centers_grid.clear_filters') . '</button>
                    </div>
                </div>
            </div>';
        }

        $html = '';
        foreach ($centers as $lc) {
            $average = $lc->display_rating;

            $html .= '<div class="group relative">';
            // Glow effect
            $html .= '<div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-30 blur transition duration-500"></div>';
            // Card
            $html .= '<div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden h-full border border-gray-100 dark:border-gray-700 group-hover:-translate-y-1">';
            // Image container
            $html .= '<div class="relative h-52 overflow-hidden">';

            if ($lc->logo) {
                $logoUrl = (str_starts_with($lc->logo, 'http://') || str_starts_with($lc->logo, 'https://'))
                    ? $lc->logo
                    : asset('storage/' . $lc->logo);
                $html .= '<img src="' . $logoUrl . '" alt="' . e($lc->name) . '" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">';
            } else {
                $html .= '<div class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 dark:from-indigo-600 dark:via-purple-700 dark:to-pink-800 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url(\'data:image/svg+xml,%3Csvg width=%2220%22 height=%2220%22 viewBox=%220 0 20 20%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.05%22 fill-rule=%22evenodd%22%3E%3Ccircle cx=%223%22 cy=%223%22 r=%223%22/%3E%3Ccircle cx=%2213%22 cy=%2213%22 r=%223%22/%3E%3C/g%3E%3C/svg%3E\')]"></div>
                    <div class="text-white text-center px-4 relative z-10">
                        <div class="text-2xl font-bold mb-1 drop-shadow-lg">' . e($lc->type) . '</div>
                        <div class="text-sm opacity-90">' . e($lc->name) . '</div>
                    </div>
                </div>';
            }

            // Rating badge
            $html .= '<div class="absolute top-3 right-3 bg-white dark:bg-gray-800 px-2.5 py-1 rounded-full shadow-lg border border-gray-200 dark:border-gray-600">
                <div class="flex items-center gap-1">
                    <span class="text-amber-500 text-sm">★</span>
                    <span class="text-sm font-black text-gray-900 dark:text-white">' . $average . '</span>
                </div>
            </div>';

            // Verified badge
            if ($lc->checked) {
                $html .= '<div class="absolute top-3 left-3 bg-emerald-500/95 backdrop-blur p-1.5 rounded-full shadow-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>';
            }

            // View button overlay
            $html .= '<a href="' . route('center', $lc->slug) . '" class="absolute inset-0 flex items-end justify-center p-4 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl shadow-lg hover:bg-gray-50 transition-colors flex items-center gap-2">' . __('centers.centers_grid.read_more') . '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg></span>
            </a>';
            $html .= '</div>'; // End image container

            // Content
            $html .= '<div class="p-5">';
            // Title
            $html .= '<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                <a href="' . route('center', $lc->slug) . '">' . e($lc->name) . '</a>
            </h3>';
            $html .= '<p class="text-sm text-gray-500 dark:text-gray-400 mb-3">' . e($lc->type) . '</p>';

            // Meta information
            $html .= '<div class="flex flex-wrap gap-2 mb-3 text-sm text-gray-600 dark:text-gray-400">';
            $html .= '<div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate">' . e($lc->region) . ', ' . e($lc->province) . '</span>
            </div>';
            if (isset($lc->distance)) {
                $html .= '<div class="flex items-center gap-1.5 px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-full">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">' . round($lc->distance, 1) . ' km</span>
                </div>';
            }
            $html .= '</div>'; // End meta

            $html .= '</div>'; // End content
            $html .= '</div>'; // End card
            $html .= '</div>'; // End group
        }

        return $html;
    }



    /**
     * Check if any filters are active
     */
    private function hasActiveFilters($validated)
    {
        $filterFields = ['searchText', 'type', 'checked', 'dayMode'];

        foreach ($filterFields as $field) {
            if (!empty($validated[$field])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect province from coordinates
     */
    private function detectProvinceFromCoordinates($latitude, $longitude)
    {
        $closestCenter = LearningCenter::select('province')
            ->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(substr(location, 1, instr(location, ",") - 1))) * cos(radians(substr(location, instr(location, ",") + 1)) - radians(?)) + sin(radians(?)) * sin(radians(substr(location, 1, instr(location, ",") - 1))))) as distance', [$latitude, $longitude, $latitude])
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->orderBy('distance', 'asc')
            ->first();

        return $closestCenter ? $closestCenter->province : null;
    }

    /**
     * Get default location (Tashkent center as fallback)
     */
    private function getDefaultLocation()
    {
        return [
            'latitude' => 41.2995,
            'longitude' => 69.2401
        ];
    }
    public function center(LearningCenter $center)
    {
        $LearningCenter = $center->load([
            'comments.user',
            'favorites',
            'subjects.teacherSubjects.teacher',
            'teachers.teacherSubjects.subject'
        ]);

        $LearningCenter->loadCount(['comments', 'favorites']);

        // Get user's existing rating if authenticated
        $userRating = null;
        if (Auth::check()) {
            $favorite = Favorite::where('users_id', Auth::id())
                ->where('learning_centers_id', $center->id)
                ->first();
            $userRating = $favorite ? $favorite->rating : null;
        }

        // Fetch related centers with caching (30 minutes)
        $relatedCenters = $this->getRelatedCenters($center);

        return view('pages.center', compact('LearningCenter', 'userRating', 'relatedCenters'));
    }

    /**
     * Get related centers based on type, location, and subjects
     * Cached for 30 minutes to reduce database load
     *
     * @param LearningCenter $center The current center being viewed
     * @return \Illuminate\Support\Collection<int, LearningCenter>
     */
    private function getRelatedCenters(LearningCenter $center): \Illuminate\Support\Collection
    {
        $cacheKey = "related_centers:{$center->id}:{$center->updated_at->timestamp}";

        return Cache::remember($cacheKey, 30, function () use ($center) {
            // Get current center's subject IDs for comparison
            $centerSubjectIds = $center->subjects->pluck('id')->toArray();

            $query = LearningCenter::query()
                ->where('id', '!=', $center->id) // Exclude current center
                ->where('status', 'active') // Only active centers
                ->where(function ($q) use ($center) {
                    // Same type OR same region/province
                    $q->where('type', $center->type)
                      ->orWhere('region', $center->region)
                      ->orWhere('province', $center->province);
                })
                ->with(['subjects', 'favorites']) // Eager load for subject intersection
                ->withAvg('favorites', 'rating') // For rating display
                ->withCount('favorites'); // For rating count

            $candidates = $query->limit(20)->get();

            // Calculate relevance score for each candidate
            $scored = $candidates->map(function ($candidate) use ($center, $centerSubjectIds) {
                $score = 0;

                // Same type: +30 points
                if ($candidate->type === $center->type) {
                    $score += 30;
                }

                // Same region: +20 points
                if ($candidate->region === $center->region) {
                    $score += 20;
                }

                // Same province: +15 points
                if ($candidate->province === $center->province) {
                    $score += 15;
                }

                // Overlapping subjects: +10 points per subject
                $candidateSubjectIds = $candidate->subjects->pluck('id')->toArray();
                $commonSubjects = array_intersect($centerSubjectIds, $candidateSubjectIds);
                $score += count($commonSubjects) * 10;

                // Bonus for high rating: +5 points
                if (($candidate->favorites_avg_rating ?? 0) >= 4.0) {
                    $score += 5;
                }

                return [
                    'center' => $candidate,
                    'score' => $score,
                    'common_subjects' => count($commonSubjects),
                ];
            });

            // Sort by score descending, then by rating
            $sorted = $scored->sortByDesc('score')
                            ->sortByDesc(fn($item) => $item['center']->favorites_avg_rating ?? 0);

            // Return top 8 centers
            return $sorted->take(8)->pluck('center');
        });
    }
    public function signin()
    {
        return view('auth.signin');
    }
    public function signup()
    {
        return view('auth.signup');
    }
    public function notFound()
    {
        return view('errors.404');
    }
}
