<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\LearningCenter;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('subject.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $LearningCenter = LearningCenter::find(request()->query('id'));
        Gate::authorize('isOun', $LearningCenter);

        // Get unique subject names from all learning centers for datalist
        $existingSubjects = SubjectsOfLearningCenter::select('subject_name')
            ->distinct()
            ->whereNotNull('subject_name')
            ->where('subject_name', '!=', '')
            ->orderBy('subject_name')
            ->pluck('subject_name');

        // Get teachers for this learning center
        $teachers = Teacher::where('learning_centers_id', $LearningCenter->id)
            ->orderBy('name')
            ->get();

        return view('subject.create', compact('LearningCenter', 'existingSubjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $LearningCenter = LearningCenter::find($request->route('id'));
        Gate::authorize('isOun', $LearningCenter);

        $request->merge(['learning_centers_id' => $request->route('id')]);
        $validate = $request->validate([
            'learning_centers_id' => 'required|exists:learning_centers,id',
            'subject_name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'subject_type' => 'nullable|string|max:255',
            'subject_icon' => 'nullable|string|max:255',
            'price' => 'nullable|integer',
            'currency' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        // Create subject
        $subject = SubjectsOfLearningCenter::create([
            'learning_centers_id' => $validate['learning_centers_id'],
            'subject_name' => $validate['subject_name'],
        ]);

        // Attach teacher if selected
        if (!empty($validate['teacher_id'])) {
            TeacherSubject::create([
                'teacher_id' => $validate['teacher_id'],
                'subject_id' => $subject->id,
                'subject_type' => $validate['subject_type'] ?? null,
                'subject_icon' => $validate['subject_icon'] ?? null,
                'price' => $validate['price'] ?? null,
                'currency' => $validate['currency'] ?? null,
                'period' => $validate['period'] ?? null,
                'description' => $validate['description'] ?? null,
            ]);
        }

        return redirect()->route('center', $request->route('id'))->with('success', 'Subject added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjectOfCenter = SubjectsOfLearningCenter::findOrFail($id);
        $LearningCenter = LearningCenter::find($subjectOfCenter->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);

        // Get teachers for this learning center
        $teachers = Teacher::where('learning_centers_id', $LearningCenter->id)
            ->orderBy('name')
            ->get();

        // Get current teacher_subject relation
        $teacherSubject = $subjectOfCenter->teacherSubjects()->first();

        return view('subject.edit', compact('subjectOfCenter', 'LearningCenter', 'teachers', 'teacherSubject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subjectOfCenter = SubjectsOfLearningCenter::findOrFail($id);
        $LearningCenter = LearningCenter::find($subjectOfCenter->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);

        $validate = $request->validate([
            'subject_name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'subject_type' => 'nullable|string|max:255',
            'subject_icon' => 'nullable|string|max:255',
            'price' => 'nullable|integer',
            'currency' => 'nullable|string|max:50',
            'period' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        // Update subject
        $subjectOfCenter->update([
            'subject_name' => $validate['subject_name'],
        ]);

        // Update or create teacher_subject relation
        if (!empty($validate['teacher_id'])) {
            TeacherSubject::updateOrCreate(
                ['subject_id' => $subjectOfCenter->id],
                [
                    'teacher_id' => $validate['teacher_id'],
                    'subject_type' => $validate['subject_type'] ?? null,
                    'subject_icon' => $validate['subject_icon'] ?? null,
                    'price' => $validate['price'] ?? null,
                    'currency' => $validate['currency'] ?? null,
                    'period' => $validate['period'] ?? null,
                    'description' => $validate['description'] ?? null,
                ]
            );
        } else {
            // Remove existing relation if no teacher selected
            $subjectOfCenter->teacherSubjects()->delete();
        }

        return redirect()->route('center', $subjectOfCenter->learning_centers_id)
            ->with('success', "Fan muvaffaqiyatli yangilandi");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = SubjectsOfLearningCenter::findOrFail($id);
        $LearningCenter = LearningCenter::find($subject->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);
        $subject->delete();
        return redirect()->back()->with('success', "Fan muoffaqiyatli o'chirildi");
    }
}
