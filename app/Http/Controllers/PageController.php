<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\LearningCenter;
use App\Models\Subject;
use App\Models\LearningCentersCalendar;
use App\Models\NeedTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'a' => 'а', 'b' => 'б', 'd' => 'д', 'e' => 'е', 'f' => 'ф',
            'g' => 'г', 'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к',
            'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п',
            'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
            'v' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
            'o\'' => 'ў', 'g\'' => 'ғ', 'sh' => 'ш', 'ch' => 'ч', 'ng' => 'нг'
        ];
        
        $cyrillicToLatin = [
            'а' => 'a', 'б' => 'b', 'д' => 'd', 'е' => 'e', 'ф' => 'f',
            'г' => 'g', 'ҳ' => 'h', 'и' => 'i', 'ж' => 'j', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p',
            'қ' => 'q', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'в' => 'v', 'х' => 'x', 'й' => 'y', 'з' => 'z',
            'ў' => 'o\'', 'ғ' => 'g\'', 'ш' => 'sh', 'ч' => 'ch', 'нг' => 'ng'
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
        $centers = LearningCenter::all();
        return view('pages.index', compact('centers'));
    }
    public function blogGrid(Request $request)
    {
        $validated = $request->validate([
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'radius'       => 'nullable|numeric',
            'searchText'   => 'nullable|string|max:255',
            'subject_id'   => 'nullable|exists:subjects,id',
            'type'         => 'nullable|string|max:255',
            'name'         => 'nullable|in:asc,desc',
            'distance'     => 'nullable|in:asc,desc',
            'favorites'    => 'nullable|in:asc,desc',
            'sort'         => 'nullable|in:name,distance,favorites',
            'needTeachers' => 'nullable|exists:subjects,id',
            'dayMode'      => 'nullable|in:true',
            'page'         => 'nullable|integer|min:1',
            'per_page'     => 'nullable|integer|min:1|max:50',
        ]);

        $page    = $validated['page']     ?? 1;
        $perPage = $validated['per_page'] ?? 12;

        // User location — only when explicitly provided
        $userLocation = null;
        if (!empty($validated['latitude']) && !empty($validated['longitude'])) {
            $userLocation = [
                'latitude'  => (float) $validated['latitude'],
                'longitude' => (float) $validated['longitude'],
            ];
        }

        // -------------------------------------------------------
        // Build base query
        // -------------------------------------------------------
        $baseQuery = LearningCenter::query();

        // Search filter
        if (!empty($validated['searchText'])) {
            $searchText        = $validated['searchText'];
            $transliteratedText = $this->transliterate($searchText);
            $words             = explode(' ', $searchText);
            $transliteratedWords = explode(' ', $transliteratedText);

            $baseQuery->selectRaw("
                    (CASE
                        WHEN name LIKE ? THEN 100
                        WHEN name LIKE ? THEN 95
                        WHEN name LIKE ? THEN 90
                        WHEN name LIKE ? THEN 70
                        ELSE 0
                    END) as relevance
                ", ["%{$searchText}%", "%{$transliteratedText}%", "%{$words[0]}%", "%{$transliteratedWords[0]}%"])
                ->where(function ($q) use ($searchText, $transliteratedText, $words, $transliteratedWords) {
                    $q->where('name', 'LIKE', "%{$searchText}%")
                      ->orWhere('name', 'LIKE', "%{$transliteratedText}%");
                    foreach (array_merge($words, $transliteratedWords) as $word) {
                        $q->orWhere(function ($qq) use ($word) {
                            $qq->where('name',     'LIKE', "%{$word}%")
                               ->orWhere('province', 'LIKE', "%{$word}%")
                               ->orWhere('region',   'LIKE', "%{$word}%")
                               ->orWhere('address',  'LIKE', "%{$word}%")
                               ->orWhere('type',     'LIKE', "%{$word}%");
                        });
                    }
                });
        }

        if (!empty($validated['subject_id'])) {
            $baseQuery->whereHas('subjects', fn($q) => $q->where('subject_id', $validated['subject_id']));
        }
        if (!empty($validated['type'])) {
            $baseQuery->where('type', $validated['type']);
        }
        if (!empty($validated['needTeachers'])) {
            if ($validated['needTeachers'] === 'all') {
                $baseQuery->has('needTeachers');
            } else {
                $baseQuery->whereHas('needTeachers', fn($q) => $q->where('subject_id', $validated['needTeachers']));
            }
        }

        // Location filtering in SQL
        if ($userLocation) {
            $lat = $userLocation['latitude'];
            $lng = $userLocation['longitude'];
            
            // Haversine formula directly in SQL
            $haversine = "(
                (CASE WHEN location LIKE '%,%' THEN
                    6371 * acos(
                        cos(radians(?))
                        * cos(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
                        * cos(radians(CAST(SUBSTRING_INDEX(location, ',', -1) AS DECIMAL(10,6))) - radians(?))
                        + sin(radians(?))
                        * sin(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
                    )
                ELSE NULL END)
            )";
            
            $baseQuery->selectRaw("{$haversine} AS distance", [$lat, $lng, $lat]);

            if (!empty($validated['radius'])) {
                $baseQuery->whereRaw("{$haversine} <= ?", [$lat, $lng, $lat, $validated['radius']]);
            }
        }

        // -------------------------------------------------------
        // Map Query: Lightweight, limited to 200 centers
        // -------------------------------------------------------
        $mapQuery = clone $baseQuery;
        
        $mapQuery->addSelect(['id', 'name', 'location', 'address']);
        
        // Sorting for Map
        if (!empty($validated['sort'])) {
            $dir = $validated[$validated['sort']] ?? 'asc';
            if ($validated['sort'] === 'distance' && $userLocation) {
                $mapQuery->orderBy('distance', $dir);
            }
        } elseif ($userLocation) {
            $mapQuery->orderBy('distance', 'asc');
        } elseif (!empty($validated['searchText'])) {
            $mapQuery->orderByDesc('relevance');
        } else {
            $mapQuery->latest('id');
        }

        $allCentersForMap = $mapQuery->limit(200)->get()->toArray();

        // -------------------------------------------------------
        // List Query: Paginated, with Eager Loaded Relations
        // -------------------------------------------------------
        $listQuery = clone $baseQuery;
        $listQuery->addSelect('learning_centers.*'); // Ensure all main table columns exist
        $listQuery->withAvg('favorites', 'rating')
                  ->with('needTeachers.subject');

        // Sorting for List
        if (!empty($validated['sort'])) {
            $dir = $validated[$validated['sort']] ?? 'asc';
            if ($validated['sort'] === 'name') {
                $listQuery->orderBy('name', $dir);
            } elseif ($validated['sort'] === 'distance' && $userLocation) {
                $listQuery->orderBy('distance', $dir);
            } elseif ($validated['sort'] === 'favorites') {
                $listQuery->orderBy('favorites_avg_rating', $dir);
            }
        } else {
            if ($userLocation) {
                $listQuery->orderBy('distance', 'asc');
            } elseif (!empty($validated['searchText'])) {
                $listQuery->orderByDesc('relevance');
            } else {
                $listQuery->latest('id');
            }
        }

        // DB level Pagination
        $paginator = $listQuery->paginate($perPage, ['*'], 'page', $page);
        $LearningCentersArray = $paginator->items();
        
        $pagination = [
            'current_page'   => $paginator->currentPage(),
            'per_page'       => $paginator->perPage(),
            'total'          => $paginator->total(),
            'last_page'      => $paginator->lastPage(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];

        // Computed values needed for template
        foreach ($LearningCentersArray as $center) {
            $center->favorite = round($center->favorites_avg_rating ?? 0, 1);
            $center->date     = $center->created_at->diffForHumans();
            if (isset($center->distance)) {
                $center->distance = round((float)$center->distance, 2);
            }
        }
        
        $LearningCenters = collect($LearningCentersArray);

        // -------------------------------------------------------
        // AJAX response
        // -------------------------------------------------------
        if ($request->ajax() || $request->wantsJson()) {
            $html = '';
            foreach ($LearningCenters as $lc) {
                // Use already-loaded aggregate — no extra query
                $average = $lc->favorite;

                $html .= '<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">';

                if ($lc->logo) {
                    $logoUrl = (str_starts_with($lc->logo, 'http://') || str_starts_with($lc->logo, 'https://'))
                        ? $lc->logo
                        : asset('storage/' . $lc->logo);
                    $html .= '<img src="' . $logoUrl . '" alt="' . e($lc->name) . '" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">';
                } else {
                    $html .= '<div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 dark:from-indigo-600 dark:to-purple-800 flex items-center justify-center">
                        <div class="text-white text-center px-4">
                            <div class="text-xl font-bold mb-1">' . e($lc->type) . '</div>
                            <div class="text-sm opacity-90">' . e($lc->name) . '</div>
                        </div></div>';
                }

                $html .= '<div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <a href="' . route('blog-single', $lc->id) . '" class="absolute bottom-4 right-4 bg-white text-primary-900 px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 font-bold text-sm opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-2 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 hover:bg-primary-50">
                            <span class="font-bold">' . __('blog-grid.centers_grid.read_more') . '</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>' . e($lc->region) . ', ' . e($lc->province) . '</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>' . $lc->created_at->diffForHumans() . '</span>
                            </div>';
                if (isset($lc->distance)) {
                    $html .= '<div class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg><span>' . $lc->distance . ' km</span></div>';
                }
                $html .= '</div>
                        <div class="flex items-center gap-3 mb-4"><div class="flex items-center">';
                for ($i = 1; $i <= 5; $i++) {
                    $html .= '<span class="text-lg ' . ($average >= $i ? 'text-yellow-400' : (($average - $i > -1 && $average - $i < 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600')) . '">★</span>';
                }
                $html .= '</div><span class="text-lg font-semibold text-primary-600 dark:text-primary-400">' . $average . '</span></div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <a href="' . route('blog-single', $lc->id) . '" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">' . e($lc->name) . '</a>
                        </h3>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">' . __('blog-grid.centers_grid.announcement') . '</h4>
                            </div>';
                if ($lc->needTeachers->count() > 0) {
                    $first = $lc->needTeachers->last();
                    $html .= '<div class="space-y-2"><p class="text-sm font-medium text-success-600 dark:text-success-400">' . __('blog-grid.centers_grid.teacher_needed') . '</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 dark:text-gray-300">🟢 ' . e($first->subject->name) . '</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">' . $first->created_at->diffForHumans() . '</span>
                        </div>';
                    if ($lc->needTeachers->count() > 1) {
                        $html .= '<div><a href="' . route('blog-single', $lc->id) . '" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">' . __('blog-grid.centers_grid.more_announcements', ['count' => $lc->needTeachers->count() - 1]) . '</a></div>';
                    }
                    $html .= '</div>';
                } else {
                    $html .= '<p class="text-sm text-gray-500 dark:text-gray-400">' . __('blog-grid.centers_grid.no_announcements') . '</p>';
                }
                $html .= '</div></div></div>';
            }

            if ($LearningCenters->isEmpty()) {
                $html = '<div class="col-span-full text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">' . __('blog-grid.centers_grid.no_centers_found') . '</p>
                    <button onclick="clearAllFilters()" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">' . __('blog-grid.centers_grid.clear_filters') . '</button>
                </div>';
            }

            return response()->json([
                'success'    => true,
                'html'       => $html,
                'count'      => $LearningCenters->count(),
                'centers'    => $allCentersForMap,
                'pagination' => $pagination,
            ]);
        }

        $subjects = Subject::all();
        $types    = LearningCenter::distinct()->pluck('type')->filter()->sort()->values();

        return view('pages.blog-grid', compact(
            'LearningCenters', 'subjects', 'validated', 'pagination',
            'types', 'userLocation', 'allCentersForMap'
        ));
    }



    /**
     * Check if any filters are active
     */
    private function hasActiveFilters($validated)
    {
        $filterFields = ['searchText', 'subject_id', 'type', 'needTeachers', 'dayMode'];
        
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
    public function blogSingle($id)
    {
        $LearningCenter = LearningCenter::with(['needTeachers.subject', 'needTeachers.learningCenter', 'comments.user', 'favorites'])
            ->withCount('comments')
            ->find($id);
        return view('pages.blog-single')->with('LearningCenter', $LearningCenter);
    }
    public function signin()
    {
        return view('pages.signin');
    }
    public function signup()
    {
        return view('pages.signup');
    }
    public function notFound()
    {
        return view('pages.404');
    }
}
