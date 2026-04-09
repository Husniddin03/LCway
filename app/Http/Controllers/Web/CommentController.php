<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\Favorite;
use App\Models\LearningCenter;
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

        $comment = LearningCentersComment::create($validate);
        $comment->load('user');

        // Agar Ajax so'rovi bo'lsa JSON qaytaramiz
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Izoh muvaffaqiyatli qo\'shildi',
                'comment_id' => $comment->id,
                'user_name' => $comment->user->name,
                'user_email' => $comment->user->email,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans()
            ]);
        }

        // Oddiy so'rov uchun redirect qilamiz
        return redirect()->route('center', $validate['learning_centers_id'] . '#comment')
            ->with('success', 'Izohingiz muvaffaqiyatli qo‘shildi.');
    }

    public function delete(Request $request, string $id)
    {
        $comment = LearningCentersComment::find($id);
        Gate::authorize('myComment', $comment);
        $comment->delete();

        // Agar Ajax so'rovi bo'lsa JSON qaytaramiz
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Izoh muvaffaqiyatli o\'chirildi'
            ]);
        }

        return back()->with('success', 'Izohingiz muvaffaqiyatli o\'chirdingiz.');
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
            // Agar mavjud bo'lsa yangilaymiz
            $existing->update(['rating' => $validated['rating']]);
            $favorite = $existing;
            $message = 'Reyting yangilandi.';
        } else {
            // Agar mavjud bo'lmasa yangi yozuv qo'shamiz
            $favorite = Favorite::create($validated);
            $message = 'Reyting saqlandi.';
        }

        // Get updated learning center data with dynamic attributes
        $learningCenter = LearningCenter::find($validated['learning_centers_id']);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $favorite,
            'total_reyting' => $learningCenter->calculated_total_reyting,
            'ratings_total' => $learningCenter->user_ratings_total
        ]);
    }
}
