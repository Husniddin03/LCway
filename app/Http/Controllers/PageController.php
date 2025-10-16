<?php

namespace App\Http\Controllers;

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
        $LearningCenters = LearningCenter::where('name', 'LIKE', "%{$searchText}%")
            ->orWhere('province', 'LIKE', "%{$searchText}%")
            ->orWhere('region', 'LIKE', "%{$searchText}%")
            ->orWhere('address', 'LIKE', "%{$searchText}%")
            ->get();

        $subjects = Subject::all();
        return view('pages.blog-grid')->with('LearningCenters', $LearningCenters)->with('searchText', $searchText)->with('subjects', $subjects);
    }

    public function searchMap(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric', // km
            'subject_id' => 'nullable|exists:subjects,id',
            'maxPrice' => 'nullable|numeric',
        ]);

        // dd($request->all());

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius'); // km
        $subject_id = $request->input('subject_id');
        $maxPrice = $request->input('maxPrice');

        $LearningCentersLocation = LearningCenter::all();

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

            if (
                ($radius === null || $distance <= $radius) &&
                ($subject_id === null || $LearningCenter->subjects->contains('id', $subject_id)) &&
                ($maxPrice === null || $LearningCenter->subjects->some(fn($s) => $s->price <= $maxPrice))
            ) {
                $filteredCenters->push($LearningCenter);
            }
        }

        $LearningCenters = $filteredCenters->sortBy('distance')->values();

        $subjects = Subject::all();

        return view('pages.blog-grid', compact('LearningCenters', 'subjects'));
    }
}
