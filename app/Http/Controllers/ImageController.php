<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    public function edit(string $id) {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        return view('course.editImage', compact('LearningCenter'));
    }
}
