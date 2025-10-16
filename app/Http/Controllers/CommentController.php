<?php

namespace App\Http\Controllers;

use App\Models\LearningCentersComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->merge(['users_id' => Auth::user()->id]);
        $validate = $request->validate([
            'users_id' => 'required|exists:users,id',
            'learning_centers_id' => 'required|exists:learning_centers,id',
            'comment' => 'required|string'
        ]);
        LearningCentersComment::create($validate);
        return redirect()->route('blog-single', $validate['learning_centers_id'].'#comment')
            ->with('success', 'Izohingiz muvaffaqiyatli qo‘shildi.');
    }
}
