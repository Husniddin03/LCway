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
}
