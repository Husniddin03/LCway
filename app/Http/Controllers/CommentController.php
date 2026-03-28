<?php

namespace App\Http\Controllers;

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
        $comment->load('user'); // User ma'lumotlarini yuklab olamiz
        
        // Agar Ajax so'rovi bo'lsa JSON qaytaramiz
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Izoh muvaffaqiyatli qo\'shildi',
                'comment' => $comment
            ]);
        }
        
        // Oddiy so'rov uchun redirect qilamiz
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
            // Agar mavjud bo'lmasa yangi yozuv qo'shamiz
            $favorite = Favorite::create($validated);
            $message = 'Reyting saqlandi.';
        }

        // Calculate new total_reyting for the learning center
        $this->updateTotalReyting($validated['learning_centers_id']);

        // Get updated learning center data
        $learningCenter = LearningCenter::find($validated['learning_centers_id']);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $favorite,
            'total_reyting' => $learningCenter->total_reyting,
            'ratings_total' => $learningCenter->ratings_total
        ]);
    }

    /**
     * Update total_reyting for a learning center based on all user ratings
     */
    private function updateTotalReyting($learningCenterId)
    {
        $learningCenter = LearningCenter::find($learningCenterId);
        
        if (!$learningCenter) {
            return;
        }

        // Get all user ratings for this learning center
        $ratings = Favorite::where('learning_centers_id', $learningCenterId)->get();
        
        if ($ratings->isEmpty()) {
            // If no ratings, use the original Google rating
            $learningCenter->update([
                'total_reyting' => $learningCenter->rating,
                'ratings_total' => 0
            ]);
            return;
        }

        // Calculate average of all user ratings
        $userAverage = $ratings->avg('rating');
        $userCount = $ratings->count();

        // Calculate weighted average: 50% Google rating, 50% user ratings
        // If no Google rating, use 100% user ratings
        if ($learningCenter->rating > 0) {
            $totalReyting = ($learningCenter->rating + $userAverage) / 2;
        } else {
            $totalReyting = $userAverage;
        }

        $learningCenter->update([
            'total_reyting' => round($totalReyting, 2),
            'ratings_total' => $userCount
        ]);
    }
}
