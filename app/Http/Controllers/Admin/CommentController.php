<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningCentersComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get all comments with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $query = LearningCentersComment::query();

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('comment', 'like', "%$search%");
        }

        // Filter by status
        if ($request->has('checked')) {
            $query->where('checked', $request->get('checked'));
        }

        // Filter by learning center
        if ($request->has('center_id')) {
            $query->where('learning_center_id', $request->get('center_id'));
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 20);
        $comments = $query->with([
            'user:id,name,email',
            'learningCenter:id,name'
        ])->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Get single comment with relations
     */
    public function show(int $id): JsonResponse
    {
        $comment = LearningCentersComment::with([
            'user:id,name,email',
            'learningCenter:id,name,address'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }

    /**
     * Update comment
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $comment = LearningCentersComment::findOrFail($id);

        $validated = $request->validate([
            'comment' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
            'checked' => 'sometimes|boolean',
        ]);

        $comment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'data' => $comment
        ]);
    }

    /**
     * Delete comment
     */
    public function destroy(int $id): JsonResponse
    {
        $comment = LearningCentersComment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * Approve/Verify comment
     */
    public function approve(int $id): JsonResponse
    {
        $comment = LearningCentersComment::findOrFail($id);

        $comment->checked = true;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment approved',
            'data' => ['checked' => true]
        ]);
    }

    /**
     * Reject/Unverify comment
     */
    public function reject(int $id): JsonResponse
    {
        $comment = LearningCentersComment::findOrFail($id);

        $comment->checked = false;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment rejected',
            'data' => ['checked' => false]
        ]);
    }

    /**
     * Bulk approve comments
     */
    public function bulkApprove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:learning_centers_comments,id',
        ]);

        LearningCentersComment::whereIn('id', $validated['ids'])->update(['checked' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Comments approved successfully'
        ]);
    }

    /**
     * Bulk delete comments
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:learning_centers_comments,id',
        ]);

        LearningCentersComment::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comments deleted successfully'
        ]);
    }

    /**
     * Get pending comments
     */
    public function pending(): JsonResponse
    {
        $comments = LearningCentersComment::where('checked', false)
            ->with([
                'user:id,name,email',
                'learningCenter:id,name'
            ])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Get comment statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => LearningCentersComment::count(),
            'approved' => LearningCentersComment::where('checked', true)->count(),
            'pending' => LearningCentersComment::where('checked', false)->count(),
            'average_rating' => LearningCentersComment::avg('rating'),
            'by_center' => LearningCentersComment::selectRaw('learning_center_id, COUNT(*) as count, AVG(rating) as avg_rating')
                ->groupBy('learning_center_id')
                ->with('learningCenter:id,name')
                ->get(),
            'this_month' => LearningCentersComment::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
