<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use App\Models\NeedTeacher;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function create()
    {
        $LearningCenter = LearningCenter::find(request()->query('id'));
        return view('teacher.create', compact('LearningCenter'));
    }


    public function store(Request $request)
    {

        $request->merge([
            'learning_centers_id' => $request->route('id')
        ]);

        $validate = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'about' => 'nullable|string',
            'learning_centers_id' => 'required|exists:learning_centers,id',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads/teachers', 'public');
            $validate['photo'] = $path;
        }
        Teacher::create($validate);
        return redirect()->route('blog-single', $request->route('id'))->with('success', 'Ustoz muvaffaqiyatli qo\'shildi');
    }


    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();
        return redirect()->back()->with('success', "O'qituvchi muoffaqiyatli o'chirildi");
    }

    public function announcement($id)
    {
        $subjects = Subject::all();
        $LearningCenter = LearningCenter::find($id);
        return view('teacher.announcement', compact('LearningCenter'))->with('subjects', $subjects);
    }

    public function add_announcement(Request $request, $id)
    {
        $request->merge(['learning_center_id' => $id]);

        $validate = $request->validate([
            'learning_center_id' => 'required|exists:learning_centers,id',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'nullable|string'
        ]);

        NeedTeacher::create($validate);
    
        return redirect()->route('blog-single', $id)->with('success', 'E\'lon muvaffaqiyatli qo;shildi');
    }

    public function delete_announcement(string $id) {
        $delete_announcement = NeedTeacher::find($id);
        $delete_announcement->delete();
        return back()->with('success', 'E\'lon muvaffaqiyatli o\'chirilidi');
    }

    
}
