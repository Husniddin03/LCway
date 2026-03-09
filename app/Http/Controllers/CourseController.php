<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use App\Models\Calendar;
use App\Models\Connection;
use App\Models\LearningCentersCalendar;
use App\Models\LearningCentersConnect;
use App\Models\LearningCentersImage;
use App\Models\Subject;
use App\Models\SubjectsOfLearningCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $centers = LearningCenter::with(['user'])->latest()->paginate(6);
        return view('pages.blog-grid', compact('centers'));
    }

    public function create()
    {
        $days = Calendar::pluck('weekdays')->toArray();
        $subjects = Subject::pluck('name', 'id')->toArray();
        $connections = Connection::pluck('name', 'id')->toArray();
        return view('course.create')->with('days', $days)->with('subjects', $subjects)->with('connections', $connections);
    }

    public function store(Request $request)
    {
        // Combine latitude and longitude into location string
        $location = $request->latitude . ',' . $request->longitude;
        $request->merge(['location' => $location]);
        $validated = $request->validate([
            'logo'         => 'required|image|max:1024',
            'name'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'about'        => 'required|string',
            'province'     => 'required|string|max:255',
            'region'       => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'student_count' => 'integer',
        ]);



        $validated4 = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:1024',
        ]);

        $validated['users_id'] = Auth::id();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $validated['logo'] = $path;
        }

        $center = LearningCenter::create($validated);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/centers', 'public');
                LearningCentersImage::create([
                    'learning_centers_id' =>  $center->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('blog-single', $center->id)
            ->with('success', 'O‘quv markaz muvaffaqiyatli qo‘shildi.');
    }

    public function show($id)
    {
        $LearningCenter = LearningCenter::findOrFail($id);

        return view('pages.blog-single', compact('LearningCenter'));
    }


    public function edit($id)
    {
        $center = LearningCenter::findOrFail($id);
        Gate::authorize('isOun', $center);
        return view('course.edit', compact('center'));
    }


    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'logo'         => 'nullable|image|max:1024',
            'name'         => 'required|string|max:255',
            'type'         => 'nullable|string|max:255',
            'about'        => 'nullable|string',
            'province'     => 'nullable|string|max:255',
            'region'       => 'nullable|string|max:255',
            'address'      => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'studentCount' => 'nullable|integer',
        ]);

        $center = LearningCenter::findOrFail($id);

        Gate::authorize('isOun', $center);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $validated['logo'] = $path;
            if ($center->logo && Storage::disk('public')->exists($center->logo)) {
                Storage::disk('public')->delete($center->logo);
            }
        }

        $center->update($validated);

        return redirect()->route('blog-single', $center->id)
            ->with('success', 'O‘quv markaz muvaffaqiyatli yangilandi.');
    }


    public function destroy($id)
    {
        $center = LearningCenter::findOrFail($id);
        Gate::authorize('isOun', $center);

        // Markaz logosi
        if ($center->logo && Storage::disk('public')->exists($center->logo)) {
            Storage::disk('public')->delete($center->logo);
        }

        // Markaz rasmlari
        foreach ($center->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            // DB dan ham o‘chirish
            $image->delete();
        }

        // O‘qituvchilar rasmlari
        foreach ($center->teachers as $teacher) {
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            // DB dan ham o‘chirish
            $teacher->delete();
        }

        // Markazni o‘chirish
        $center->delete();

        return redirect()->route('index')
            ->with('success', 'O‘quv markaz o‘chirildi.');
    }
}
