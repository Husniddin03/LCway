<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\LearningCenter;
use App\Models\NeedTeacher;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function create()
    {
        $LearningCenter = LearningCenter::find(request()->query('id'));
        Gate::authorize('isOun', $LearningCenter);
        
        // Get subjects for this learning center
        $subjects = SubjectsOfLearningCenter::where('learning_centers_id', $LearningCenter->id)
            ->orderBy('subject_name')
            ->get();
        
        return view('teacher.create', compact('LearningCenter', 'subjects'));
    }

    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $LearningCenter = LearningCenter::find($teacher->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);
        
        // Get subjects for this learning center
        $subjects = SubjectsOfLearningCenter::where('learning_centers_id', $LearningCenter->id)
            ->orderBy('subject_name')
            ->get();
        
        // Get current teacher_subject relation
        $teacherSubject = $teacher->teacherSubjects()->first();
        
        return view('teacher.edit', compact('teacher', 'LearningCenter', 'subjects', 'teacherSubject'));
    }

    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $LearningCenter = LearningCenter::find($teacher->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);

        $validate = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'subject_id' => 'nullable|exists:subjects_of_learning_centers,id',
            'subject_type' => 'nullable|string|max:255',
            'subject_icon' => 'nullable|string|max:255',
            'price' => 'nullable|integer',
            'currency' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $path = $request->file('photo')->store('uploads/teachers', 'public');
            $validate['photo'] = $path;
        }

        $teacher->update([
            'name' => $validate['name'],
            'phone' => $validate['phone'] ?? null,
            'about' => $validate['about'] ?? null,
            'photo' => $validate['photo'] ?? $teacher->photo,
        ]);

        // Update or create teacher_subject relation
        if (!empty($validate['subject_id'])) {
            TeacherSubject::updateOrCreate(
                ['teacher_id' => $teacher->id],
                [
                    'subject_id' => $validate['subject_id'],
                    'subject_type' => $validate['subject_type'] ?? null,
                    'subject_icon' => $validate['subject_icon'] ?? null,
                    'price' => $validate['price'] ?? null,
                    'currency' => $validate['currency'] ?? null,
                    'period' => $validate['period'] ?? null,
                    'description' => $validate['description'] ?? null,
                ]
            );
        } else {
            // Remove existing relation if no subject selected
            $teacher->teacherSubjects()->delete();
        }

        return redirect()->route('blog-single', $teacher->learning_centers_id)
            ->with('success', 'Ustoz muvaffaqiyatli yangilandi');
    }


    public function store(Request $request)
    {
        $LearningCenter = LearningCenter::find($request->route('id'));
        Gate::authorize('isOun', $LearningCenter);

        $request->merge([
            'learning_centers_id' => $request->route('id')
        ]);

        $validate = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'learning_centers_id' => 'required|exists:learning_centers,id',
            'subject_id' => 'nullable|exists:subjects_of_learning_centers,id',
            'subject_type' => 'nullable|string|max:255',
            'subject_icon' => 'nullable|string|max:255',
            'price' => 'nullable|integer',
            'currency' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads/teachers', 'public');
            $validate['photo'] = $path;
        }
        
        $teacher = Teacher::create([
            'name' => $validate['name'],
            'phone' => $validate['phone'] ?? null,
            'about' => $validate['about'] ?? null,
            'photo' => $validate['photo'] ?? null,
            'learning_centers_id' => $validate['learning_centers_id'],
        ]);

        // Attach subject if selected
        if (!empty($validate['subject_id'])) {
            TeacherSubject::create([
                'teacher_id' => $teacher->id,
                'subject_id' => $validate['subject_id'],
                'subject_type' => $validate['subject_type'] ?? null,
                'subject_icon' => $validate['subject_icon'] ?? null,
                'price' => $validate['price'] ?? null,
                'currency' => $validate['currency'] ?? null,
                'period' => $validate['period'] ?? null,
                'description' => $validate['description'] ?? null,
            ]);
        }

        return redirect()->route('blog-single', $request->route('id'))->with('success', 'Ustoz muvaffaqiyatli qo\'shildi');
    }


    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $LearningCenter = LearningCenter::find($teacher->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);
        
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();
        return redirect()->back()->with('success', "O'qituvchi muoffaqiyatli o'chirildi");
    }

    public function announcement($id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        return view('teacher.announcement', compact('LearningCenter'));
    }

    public function add_announcement(Request $request, $id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        
        $request->merge(['learning_center_id' => $id]);

        $validate = $request->validate([
            'learning_center_id' => 'required|exists:learning_centers,id',
            'subject_name' => 'required|string|max:255',
            'subject_type' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        NeedTeacher::create($validate);
    
        return redirect()->route('blog-single', $id)->with('success', 'E\'lon muvaffaqiyatli qo;shildi');
    }

    public function delete_announcement(string $id) {
        $announcement = NeedTeacher::find($id);
        $LearningCenter = LearningCenter::find($announcement->learning_center_id);
        Gate::authorize('isOun', $LearningCenter);
        $announcement->delete();
        return back()->with('success', 'E\'lon muvaffaqiyatli o\'chirilidi');
    }

    
}
