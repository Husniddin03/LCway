<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\LearningCenter;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }
    public function blogGrid()
    {
        $LearningCenters = LearningCenter::all();

        $subjects = Subject::all();

        return view('pages.blog-grid')->with('LearningCenters', $LearningCenters)->with('subjects', $subjects);
    }
    public function blogSingle($id)
    {
        $LearningCenter = LearningCenter::find($id);
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

    public function search(Request $request)
    {
        $validated = $request->validate([
            'searchText' => 'required|string|max:255',
        ]);
        $searchText = $request->input('searchText');
        $LearningCenters = $this->searchResult($searchText);

        $subjects = Subject::all();
        return view('pages.blog-grid')
        ->with('LearningCenters', $LearningCenters)
        ->with('searchText', $searchText)
        ->with('subjects', $subjects);
    }

    public function searchResult($searchText)
    {
        $LearningCenters = LearningCenter::where('name', 'LIKE', "%{$searchText}%")
            ->orWhere('province', 'LIKE', "%{$searchText}%")
            ->orWhere('region', 'LIKE', "%{$searchText}%")
            ->orWhere('address', 'LIKE', "%{$searchText}%")
            ->orWhere('type', 'LIKE', "%{$searchText}%")
            ->get();

        return $LearningCenters;
    }

    public function searchMap(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric', // km
            'subject_id' => 'nullable|exists:subjects,id',
            'maxPrice' => 'nullable|numeric',
            'searchText' => 'nullable|string|max:255'
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        $subject_id = $request->input('subject_id');
        $maxPrice = $request->input('maxPrice');
        $searchText = $request->input('searchText');

        if (isset($validated['searchText'])) {
            $LearningCentersLocation = $this->searchResult($searchText);
        } else {
            $LearningCentersLocation = LearningCenter::all();
        }
        $filteredCenters = collect();

        foreach ($LearningCentersLocation as $LearningCenter) {
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

            // Filter conditions
            $passRadiusFilter = $radius === null || $distance <= $radius;

            // Check if subject exists in this learning center
            $passSubjectFilter = $subject_id === null ||
                $LearningCenter->subjects->contains('subject_id', $subject_id);

            // Check if price is within max price for that subject
            $passPriceFilter = $maxPrice === null ||
                $LearningCenter->subjects->where('subject_id', $subject_id)->first()?->price <= $maxPrice;

            if ($passRadiusFilter && $passSubjectFilter && $passPriceFilter) {
                $filteredCenters->push($LearningCenter);
            }
        }

        $LearningCenters = $filteredCenters->sortBy('distance')->values();
        $subjects = Subject::all();

        return view('pages.blog-grid', compact('LearningCenters', 'subjects', 'searchText'));
    }
}
