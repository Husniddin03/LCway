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
    public function index()
    {
        $centers = LearningCenter::all();
        return view('pages.index', compact('centers'));
    }
    public function blogGrid(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric', // km
            'searchText' => 'nullable|string|max:255',
            'subject_id' => 'nullable|exists:subjects,id',
            'name' => 'nullable|in:asc,desc',
            'distance' => 'nullable|in:asc,desc',
            'favorites' => 'nullable|in:asc,desc',
            'sort' => 'nullable|in:name,distance,favorites',
            'needTeachers' => 'nullable|exists:subjects,id',
            'dayMode' => 'nullable|in:true',
        ]);

        // Start with all centers
        $LearningCenters = LearningCenter::with('favorites')->with('needTeachers');

        // Apply search filter
        if (!empty($validated['searchText'])) {
            $searchText = $validated['searchText'];
            $LearningCenters = $LearningCenters->where(function($query) use ($searchText) {
                $query->where('name', 'LIKE', "%{$searchText}%")
                      ->orWhere('province', 'LIKE', "%{$searchText}%")
                      ->orWhere('region', 'LIKE', "%{$searchText}%")
                      ->orWhere('address', 'LIKE', "%{$searchText}%")
                      ->orWhere('type', 'LIKE', "%{$searchText}%");
            });
        }

        // Apply subject filter
        if (!empty($validated['subject_id'])) {
            $LearningCenters = $LearningCenters->whereHas('subjects', function ($query) use ($validated) {
                $query->where('subject_id', $validated['subject_id']);
            });
        }

        // Apply need teachers filter
        if (!empty($validated['needTeachers'])) {
            $LearningCenters = $LearningCenters->whereHas('needTeachers', function ($query) use ($validated) {
                $query->where('subject_id', $validated['needTeachers']);
            });
        }

        // Get the filtered results
        $LearningCenters = $LearningCenters->get();

        // Apply location filtering if coordinates are provided
        if (!empty($validated['latitude']) && !empty($validated['longitude'])) {
            $latitude = $validated['latitude'];
            $longitude = $validated['longitude'];
            $radius = $validated['radius'] ?? null;
            
            $filteredCenters = collect();
            
            foreach ($LearningCenters as $LearningCenter) {
                $coords = explode(',', $LearningCenter->location);
                if (count($coords) < 2) {
                    $LearningCenter->distance = null;
                    continue;
                }

                $lat = (float) trim($coords[0]);
                $lng = (float) trim($coords[1]);
                $distance = 6371 * acos(
                    cos(deg2rad($latitude)) * cos(deg2rad($lat)) *
                        cos(deg2rad($lng) - deg2rad($longitude)) +
                        sin(deg2rad($latitude)) * sin(deg2rad($lat))
                );

                $LearningCenter->distance = round($distance, 2);

                // Filter by radius if provided
                if ($radius === null || $distance <= $radius) {
                    $filteredCenters->push($LearningCenter);
                }
            }
            
            $LearningCenters = $filteredCenters;
        }

        // Add computed properties to all centers
        foreach ($LearningCenters as $LearningCenter) {
            $LearningCenter->favorite = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
            $LearningCenter->date = $LearningCenter->created_at->diffForHumans();
        }

        // Apply sorting
        if (!empty($validated['sort'])) {
            $sortField = $validated['sort'];
            $sortDirection = $validated[$sortField] ?? 'asc';
            
            switch ($sortField) {
                case 'name':
                    $LearningCenters = $LearningCenters->sortBy('name', SORT_NATURAL, $sortDirection === 'desc');
                    break;
                case 'distance':
                    $LearningCenters = $LearningCenters->sortBy('distance', SORT_NUMERIC, $sortDirection === 'desc');
                    break;
                case 'favorites':
                    $LearningCenters = $LearningCenters->sortBy('favorite', SORT_NUMERIC, $sortDirection === 'desc');
                    break;
            }
        } else {
            // Default sort: if distance is available, sort by distance, otherwise by name
            $LearningCenters = $LearningCenters->sortBy(function($center) {
                return isset($center->distance) ? $center->distance : $center->name;
            });
        }

        // Convert to array after sorting
        $LearningCenters = $LearningCenters->values();

        // Handle AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            // Generate HTML for centers grid
            $html = '';
            foreach ($LearningCenters as $LearningCenter) {
                $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                
                $html .= '
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="' . asset('storage/' . $LearningCenter->logo) . '"
                            alt="' . $LearningCenter->name . '"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <a href="' . route('blog-single', $LearningCenter->id) . '"
                            class="absolute bottom-4 left-4 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            Ko\'proq o\'qish
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>' . $LearningCenter->region . ', ' . $LearningCenter->province . '</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>' . $LearningCenter->created_at->diffForHumans() . '</span>
                            </div>';
                
                if (isset($LearningCenter->distance)) {
                    $html .= '
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>' . $LearningCenter->distance . ' km</span>
                            </div>';
                }
                
                $html .= '
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center">';
                
                for ($i = 1; $i <= 5; $i++) {
                    $diff = $average - $i;
                    $html .= '<span class="text-lg ' . ($average >= $i ? 'text-yellow-400' : ($diff > -1 && $diff < 0 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600')) . '">★</span>';
                }
                
                $html .= '
                            </div>
                            <span class="text-lg font-semibold text-primary-600 dark:text-primary-400">' . $average . '</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <a href="' . route('blog-single', $LearningCenter->id) . '"
                                class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                                ' . $LearningCenter->name . '
                            </a>
                        </h3>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">E\'lon</h4>
                            </div>';
                
                if ($LearningCenter->needTeachers->count() > 0) {
                    $html .= '
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-success-600 dark:text-success-400">O\'qituvchi kerak</p>';
                    
                    // Show only the first teacher
                    $firstTeacher = $LearningCenter->needTeachers->last();
                    $html .= '
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700 dark:text-gray-300">🟢 ' . $firstTeacher->subject->name . '</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">' . $firstTeacher->created_at->diffForHumans() . '</span>
                                </div>';
                    
                    // Show count of remaining teachers if more than 1
                    if ($LearningCenter->needTeachers->count() > 1) {
                        $remainingCount = $LearningCenter->needTeachers->count() - 1;
                        $html .= '
                                <div>
                                    <a href="' . route('blog-single', $LearningCenter->id) . '"
                                        class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                        Yana ' . $remainingCount . ' ta e\'lon bor. Batafsil
                                    </a>
                                </div>';
                    }
                    
                    $html .= '
                            </div>';
                } else {
                    $html .= '
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hozicha e\'lon berilmagan!</p>';
                }
                
                $html .= '
                        </div>
                    </div>
                </div>';
            }
            
            // If no centers found, show empty state
            if ($LearningCenters->isEmpty()) {
                $html = '
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">Hech qanday o\'quv markazi topilmadi</p>
                    <button onclick="clearAllFilters()" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Filterni tozalash
                    </button>
                </div>';
            }
            
            // Prepare centers data for map
            $centersData = $LearningCenters->map(function ($center) {
                return [
                    'id' => $center->id,
                    'name' => $center->name,
                    'location' => $center->location,
                    'address' => $center->address,
                ];
            })->toArray();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $LearningCenters->count(),
                'centers' => $centersData
            ]);
        }

        $subjects = Subject::all();

        return view('pages.blog-grid', compact('LearningCenters', 'subjects', 'validated'));
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
