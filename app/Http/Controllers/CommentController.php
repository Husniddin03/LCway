<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\LearningCentersComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        return redirect()->route('blog-single', $validate['learning_centers_id'] . '#comment')
            ->with('success', 'Izohingiz muvaffaqiyatli qo‘shildi.');
    }

    public function delete(string $id) {
        $comment = LearningCentersComment::find($id);
        Gate::authorize('myComment', $comment);
        $comment->delete();
        return back()->with('')
            ->with('success', 'Izohingiz muvaffaqiyatli o\'chirdingiz.');
    }

    public function favoriteStore(Request $request)
    {
        $request->merge(['users_id' => Auth::id()]);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'learning_centers_id' => 'required|exists:learning_centers,id',
            'users_id' => 'required|exists:users,id',
        ]);

        // Avval mavjud reytingni tekshiramiz
        $existing = Favorite::where('users_id', $validated['users_id'])
            ->where('learning_centers_id', $validated['learning_centers_id'])
            ->first();

        if ($existing) {
            // Agar mavjud bo‘lsa yangilaymiz
            $existing->update(['rating' => $validated['rating']]);
            $favorite = $existing;
            $message = 'Reyting yangilandi.';
        } else {
            // Agar mavjud bo‘lmasa yangi yozuv qo‘shamiz
            $favorite = Favorite::create($validated);
            $message = 'Reyting saqlandi.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $favorite
        ]);
    }
}
