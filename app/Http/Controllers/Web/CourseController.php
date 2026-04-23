<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\LearningCenter;
use App\Models\LearningCentersCalendar;
use App\Models\LearningCentersConnect;
use App\Models\LearningCentersImage;
use App\Models\SubjectsOfLearningCenter;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        $centers = LearningCenter::with([
            'user',
            'images',
            'subjects',
            'teachers'
        ])->latest()->paginate(6);
        return view('pages.centers', compact('centers'));
    }

    public function create()
    {
        // Get types from LearningCenter database and group them
        $types = LearningCenter::pluck('type')->filter()->unique()->sort()->values();

        return view('user.center-create')
            ->with('types', $types);
    }

    public function store(Request $request)
    {
        // Combine latitude and longitude into location string
        $location = $request->latitude . ',' . $request->longitude;
        $request->merge(['location' => $location]);

        // Handle type validation - either from select or custom input
        $type = $request->type;
        if ($type === 'custom') {
            $validated = $request->validate([
                'logo' => 'required|image|max:1024',
                'name' => 'required|string|max:255',
                'custom_type' => 'required|string|max:255',
                'about' => 'required|string',
                'country' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'student_count' => 'integer',
                'tin' => 'nullable|string|max:20',
                'legal_address' => 'nullable|string',
                'territory' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'license_registration_date' => 'nullable|date',
                'license_validity_period' => 'nullable|date',
                'manager_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'ifut_code' => 'nullable|string|max:255',
            ]);
            $validated['type'] = $validated['custom_type'];
            unset($validated['custom_type']);
        } else {
            $validated = $request->validate([
                'logo' => 'required|image|max:1024',
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'about' => 'required|string',
                'country' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'student_count' => 'integer',
                'tin' => 'nullable|string|max:20',
                'legal_address' => 'nullable|string',
                'territory' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'license_registration_date' => 'nullable|date',
                'license_validity_period' => 'nullable|date',
                'manager_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'ifut_code' => 'nullable|string|max:255',
            ]);
        }

        // Handle country validation - either from select or custom input
        $country = $request->country;
        if ($country === 'custom') {
            $validated['country'] = $request->validate([
                'custom_country' => 'required|string|max:255',
            ])['custom_country'];
        } else {
            $validated['country'] = $country;
        }

        // Handle province validation - either from select or custom input
        $province = $request->province;
        if ($province === 'custom') {
            $validated['province'] = $request->validate([
                'custom_province' => 'required|string|max:255',
            ])['custom_province'];
        } else {
            $validated['province'] = $province;
        }

        // Handle district validation - either from select or custom input
        $region = $request->region;
        if ($region === 'custom') {
            $validated['region'] = $request->validate([
                'custom_district' => 'required|string|max:255',
            ])['custom_district'];
        } else {
            $validated['region'] = $region;
        }

        $validated4 = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:1024',
        ]);

        $validated['users_id'] = Auth::id();

        if ($request->hasFile('logo')) {
            $path = $this->imageService->optimizeImage($request->file('logo'), 'uploads/2');
            $validated['logo'] = $path;
        }

        $center = LearningCenter::create($validated);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $this->imageService->optimizeImage($image, 'uploads/centers');
                LearningCentersImage::create([
                    'learning_centers_id' => $center->id,
                    'image' => $path,
                ]);
            }
        }

        // Clear relevant caches
        Cache::forget('popular_courses');
        Cache::forget('course_types');

        return redirect()->route('user.center.manage', $center->slug)
            ->with('success', "O'quv markaz muvaffaqiyatli qo'shildi.");
    }

    public function show(LearningCenter $course)
    {
        $LearningCenter = $course->load([
            'user',
            'images',
            'subjects',
            'teachers',
            'comments.user',
            'favorites.user'
        ]);

        return view('pages.center', compact('LearningCenter'));
    }


    public function edit(LearningCenter $course)
    {
        $course->load([
            'images',
            'subjects',
            'teachers',
            'user'
        ]);
        Gate::authorize('isOun', $course);

        // Get types from LearningCenter database
        $types = LearningCenter::pluck('type')->filter()->unique()->sort()->values();

        return view('user.center-edit', compact('course', 'types'));
    }


    public function update(Request $request, LearningCenter $course)
    {
        $course->load('user');
        Gate::authorize('isOun', $course);

        // Handle type validation - either from select or custom input
        $type = $request->type;
        if ($type === 'custom') {
            $validated = $request->validate([
                'logo' => 'nullable|image|max:1024',
                'name' => 'required|string|max:255',
                'custom_type' => 'required|string|max:255',
                'about' => 'nullable|string',
                'country' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'studentCount' => 'nullable|integer',
                'images' => 'nullable|array|max:10',
                'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
                'tin' => 'nullable|string|max:20',
                'legal_address' => 'nullable|string',
                'territory' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'license_registration_date' => 'nullable|date',
                'license_validity_period' => 'nullable|date',
                'manager_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'ifut_code' => 'nullable|string|max:255',
            ]);
            $validated['type'] = $validated['custom_type'];
            unset($validated['custom_type']);
        } else {
            $validated = $request->validate([
                'logo' => 'nullable|image|max:1024',
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'about' => 'nullable|string',
                'country' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'studentCount' => 'nullable|integer',
                'images' => 'nullable|array|max:10',
                'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
                'tin' => 'nullable|string|max:20',
                'legal_address' => 'nullable|string',
                'territory' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'license_registration_date' => 'nullable|date',
                'license_validity_period' => 'nullable|date',
                'manager_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'ifut_code' => 'nullable|string|max:255',
            ]);
        }

        // Handle country validation - either from select or custom input
        $country = $request->country;
        if ($country === 'custom') {
            $validated['country'] = $request->validate([
                'custom_country' => 'required|string|max:255',
            ])['custom_country'];
        } else {
            $validated['country'] = $country;
        }

        // Handle province validation - either from select or custom input
        $province = $request->province;
        if ($province === 'custom') {
            $validated['province'] = $request->validate([
                'custom_province' => 'required|string|max:255',
            ])['custom_province'];
        } else {
            $validated['province'] = $province;
        }

        // Handle district validation - either from select or custom input
        $region = $request->region;
        if ($region === 'custom') {
            $validated['region'] = $request->validate([
                'custom_district' => 'required|string|max:255',
            ])['custom_district'];
        } else {
            $validated['region'] = $region;
        }

        // Handle logo update
        if ($request->hasFile('logo')) {
            $path = $this->imageService->optimizeImage($request->file('logo'), 'uploads/logos');
            $validated['logo'] = $path;
            // Delete old logo
            if ($course->logo && Storage::disk('public')->exists($course->logo)) {
                Storage::disk('public')->delete($course->logo);
            }
        }

        // Handle images update - delete old images if new ones are uploaded
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($course->images as $oldImage) {
                if ($oldImage->image && Storage::disk('public')->exists($oldImage->image)) {
                    Storage::disk('public')->delete($oldImage->image);
                }
                $oldImage->delete();
            }

            // Upload new images
            foreach ($request->file('images') as $image) {
                $path = $this->imageService->optimizeImage($image, 'uploads/centers');
                $course->images()->create([
                    'image' => $path,
                    'learning_centers_id' => $course->id
                ]);
            }
        }

        // Remove images from validated data to avoid database issues
        unset($validated['images']);

        $course->update($validated);

        return redirect()->route('user.center.manage', $course->slug)
            ->with('success', "O'quv markaz muvaffaqiyatli yangilandi.");
    }


    public function destroy(LearningCenter $course)
    {
        Gate::authorize('isOun', $course);

        // Markaz logosi
        if ($course->logo && Storage::disk('public')->exists($course->logo)) {
            Storage::disk('public')->delete($course->logo);
        }

        // Markaz rasmlari
        foreach ($course->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            // DB dan ham o‘chirish
            $image->delete();
        }

        // O‘qituvchilar rasmlari
        foreach ($course->teachers as $teacher) {
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            // DB dan ham o‘chirish
            $teacher->delete();
        }

        // Markazni o‘chirish
        $course->delete();

        return redirect()->route('index')
            ->with('success', 'O‘quv markaz o‘chirildi.');
    }
}
