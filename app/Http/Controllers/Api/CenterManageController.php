<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use App\Models\LearningCentersCalendar;
use App\Models\LearningCentersConnect;
use App\Models\LearningCentersImage;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CenterManageController extends Controller
{
    // ============== CONNECTIONS ==============
    
    public function storeConnection(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        $connection = LearningCentersConnect::create([
            'learning_centers_id' => $center->id,
            'connection_name' => $validated['name'],
            'url' => $validated['url'],
            'connection_icon' => $validated['icon'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $connection->id,
                'name' => $connection->connection_name,
                'url' => $connection->url,
                'icon' => $connection->connection_icon,
            ]
        ]);
    }

    public function updateConnection(Request $request, LearningCenter $center, $connectionId)
    {
        Gate::authorize('isOun', $center);
        
        $connection = LearningCentersConnect::where('learning_centers_id', $center->id)
            ->findOrFail($connectionId);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        $connection->update([
            'connection_name' => $validated['name'],
            'url' => $validated['url'],
            'connection_icon' => $validated['icon'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $connection->id,
                'name' => $connection->connection_name,
                'url' => $connection->url,
                'icon' => $connection->connection_icon,
            ]
        ]);
    }

    public function destroyConnection(LearningCenter $center, $connectionId)
    {
        Gate::authorize('isOun', $center);
        
        $connection = LearningCentersConnect::where('learning_centers_id', $center->id)
            ->findOrFail($connectionId);
        $connection->delete();

        return response()->json(['success' => true]);
    }

    // ============== TEACHERS ==============
    
    public function storeTeacher(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'about' => 'nullable|string',
            'photo' => 'nullable',
        ]);

        // Handle file upload - photo can be a file or null
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
        }

        $teacher = Teacher::create([
            'learning_centers_id' => $center->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'about' => $validated['about'] ?? null,
            'photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'phone' => $teacher->phone,
                'about' => $teacher->about,
                'photo' => $teacher->photo ? asset('storage/' . $teacher->photo) : null,
                'subjects' => [],
            ]
        ]);
    }

    public function updateTeacher(Request $request, LearningCenter $center, $teacherId)
    {
        Gate::authorize('isOun', $center);

        $teacher = Teacher::where('learning_centers_id', $center->id)
            ->findOrFail($teacherId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'about' => 'nullable|string',
            'photo' => 'nullable',
        ]);

        // Handle file upload
        $photoPath = $teacher->photo;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $photoPath = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'about' => $validated['about'] ?? null,
            'photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'phone' => $teacher->phone,
                'about' => $teacher->about,
                'photo' => $teacher->photo ? asset('storage/' . $teacher->photo) : null,
            ]
        ]);
    }

    public function destroyTeacher(LearningCenter $center, $teacherId)
    {
        Gate::authorize('isOun', $center);
        
        $teacher = Teacher::where('learning_centers_id', $center->id)
            ->findOrFail($teacherId);
        
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }
        
        $teacher->delete();

        return response()->json(['success' => true]);
    }

    public function assignTeacherSubjects(Request $request, LearningCenter $center, $teacherId)
    {
        Gate::authorize('isOun', $center);

        $teacher = Teacher::where('learning_centers_id', $center->id)
            ->findOrFail($teacherId);

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects_of_learning_centers,id',
            'subject_type' => 'nullable|string|max:50',
            'subject_icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'period' => 'nullable|string|max:50',
        ]);

        // Check if subject belongs to this center
        $subject = SubjectsOfLearningCenter::where('learning_centers_id', $center->id)
            ->findOrFail($validated['subject_id']);

        // Create or update teacher subject assignment
        $teacherSubject = TeacherSubject::updateOrCreate(
            [
                'teacher_id' => $teacher->id,
                'subject_id' => $validated['subject_id'],
            ],
            [
                'subject_type' => $validated['subject_type'] ?? null,
                'subject_icon' => $validated['subject_icon'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'] ?? null,
                'currency' => $validated['currency'] ?? 'UZS',
                'period' => $validated['period'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacherSubject->id,
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
                'subject_name' => $subject->subject_name,
            ]
        ]);
    }

    // ============== SUBJECTS ==============
    
    public function storeSubject(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = SubjectsOfLearningCenter::create([
            'learning_centers_id' => $center->id,
            'subject_name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $subject->id,
                'name' => $subject->subject_name,
            ]
        ]);
    }

    public function updateSubject(Request $request, LearningCenter $center, $subjectId)
    {
        Gate::authorize('isOun', $center);
        
        $subject = SubjectsOfLearningCenter::where('learning_centers_id', $center->id)
            ->findOrFail($subjectId);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'subject_name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $subject->id,
                'name' => $subject->subject_name,
            ]
        ]);
    }

    public function destroySubject(LearningCenter $center, $subjectId)
    {
        Gate::authorize('isOun', $center);
        
        $subject = SubjectsOfLearningCenter::where('learning_centers_id', $center->id)
            ->findOrFail($subjectId);
        $subject->delete();

        return response()->json(['success' => true]);
    }

    // ============== IMAGES ==============
    
    public function storeImage(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('uploads/learning_center_images', 'public');

        $image = LearningCentersImage::create([
            'learning_centers_id' => $center->id,
            'image' => $path,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $image->id,
                'url' => asset('storage/' . $path),
            ]
        ]);
    }

    public function destroyImage(LearningCenter $center, $imageId)
    {
        Gate::authorize('isOun', $center);
        
        $image = LearningCentersImage::where('learning_centers_id', $center->id)
            ->findOrFail($imageId);
        
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        
        $image->delete();

        return response()->json(['success' => true]);
    }

    // ============== WEEKDAYS ==============

    public function getWeekdays(LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $schedules = LearningCentersCalendar::where('learning_centers_id', $center->id)
            ->orderByRaw("FIELD(weekdays, 'Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba')")
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $schedules->map(fn($s) => [
                'id' => $s->id,
                'weekdays' => $s->weekdays,
                'open_time' => $s->open_time,
                'close_time' => $s->close_time,
            ])
        ]);
    }

    public function storeWeekday(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $validated = $request->validate([
            'weekdays' => 'required|string|max:255',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
        ]);

        $schedule = LearningCentersCalendar::create([
            'learning_centers_id' => $center->id,
            'weekdays' => $validated['weekdays'],
            'open_time' => $validated['open_time'] ?? null,
            'close_time' => $validated['close_time'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $schedule->id,
                'weekdays' => $schedule->weekdays,
                'open_time' => $schedule->open_time,
                'close_time' => $schedule->close_time,
            ]
        ]);
    }

    public function updateWeekday(Request $request, LearningCenter $center, $weekdayId)
    {
        Gate::authorize('isOun', $center);
        
        $schedule = LearningCentersCalendar::where('learning_centers_id', $center->id)
            ->findOrFail($weekdayId);
        
        $validated = $request->validate([
            'open_time' => 'nullable',
            'close_time' => 'nullable',
        ]);

        $schedule->update([
            'open_time' => $validated['open_time'] ?? null,
            'close_time' => $validated['close_time'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $schedule->id,
                'weekdays' => $schedule->weekdays,
                'open_time' => $schedule->open_time,
                'close_time' => $schedule->close_time,
            ]
        ]);
    }

    public function destroyWeekday(LearningCenter $center, $weekdayId)
    {
        Gate::authorize('isOun', $center);
        
        $schedule = LearningCentersCalendar::where('learning_centers_id', $center->id)
            ->findOrFail($weekdayId);
        
        $schedule->delete();

        return response()->json(['success' => true]);
    }

    // ============== MULTI IMAGES UPLOAD ==============

    public function storeMultipleImages(Request $request, LearningCenter $center)
    {
        Gate::authorize('isOun', $center);
        
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/learning_center_images', 'public');
                
                $newImage = LearningCentersImage::create([
                    'learning_centers_id' => $center->id,
                    'image' => $path,
                ]);
                
                $uploadedImages[] = [
                    'id' => $newImage->id,
                    'url' => asset('storage/' . $path),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $uploadedImages,
            'count' => count($uploadedImages),
        ]);
    }
}
