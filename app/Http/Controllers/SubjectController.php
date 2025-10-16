<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use App\Models\Subject;
use App\Models\SubjectsOfLearningCenter;
use Illuminate\Http\Request;

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
        $subjects = Subject::all();
        return view('subject.create', compact('LearningCenter'))->with('subjects', $subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['learning_centers_id' => $request->route('id')]);
        $validate = $request->validate([
            'learning_centers_id' => 'required|exists:learning_centers,id',
            'subject_id' => 'required|exists:subjects,id',
            'price' => 'nullable|string|max:255',
        ]);

        SubjectsOfLearningCenter::create($validate);

        return redirect()->route('blog-single', $request->route('id'))->with('success', 'Subject added successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = SubjectsOfLearningCenter::findOrFail($id);
        $subject->delete();
        return redirect()->back()->with('success', "Fan muoffaqiyatli o'chirildi");
    }
}
