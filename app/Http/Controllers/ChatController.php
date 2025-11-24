<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use App\Models\Subject;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat() {
        $LearningCenter = LearningCenter::find(1);
        $subjects = Subject::all();
        return view('chat.chat', compact('LearningCenter', 'subjects'));
    }

    public function quiz() {
        return view('chat.quiz');
    }

    public function think(Request $request) {
        return redirect()->route('chat.answer');
    }

    public function answer() {
        return view('chat.answer');
    }

    public function riasec() {
        return view('chat.riasec');
    }
}
