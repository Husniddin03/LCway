<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubjectsOfLearningCenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Get all subjects with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $query = SubjectsOfLearningCenter::query();

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%$search%");
        }

        // Filter by learning center
        if ($request->has('center_id')) {
            $query->where('learning_center_id', $request->get('center_id'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 20);
        $subjects = $query->with(['learningCenter:id,name'])->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $subjects
        ]);
    }

    /**
     * Get single subject with relations
     */
    public function show(int $id): JsonResponse
    {
        $subject = SubjectsOfLearningCenter::with([
            'learningCenter:id,name,address',
            'teachers:id,name'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $subject
        ]);
    }

    /**
     * Create new subject
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'learning_center_id' => 'required|integer|exists:learning_centers,id',
        ]);

        $subject = SubjectsOfLearningCenter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subject created successfully',
            'data' => $subject
        ], 201);
    }

    /**
     * Update subject
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $subject = SubjectsOfLearningCenter::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'learning_center_id' => 'sometimes|integer|exists:learning_centers,id',
        ]);

        $subject->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully',
            'data' => $subject
        ]);
    }

    /**
     * Delete subject
     */
    public function destroy(int $id): JsonResponse
    {
        $subject = SubjectsOfLearningCenter::findOrFail($id);
        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subject deleted successfully'
        ]);
    }

    /**
     * Bulk delete subjects
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:subjects_of_learning_centers,id',
        ]);

        SubjectsOfLearningCenter::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subjects deleted successfully'
        ]);
    }

    /**
     * Get subject statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => SubjectsOfLearningCenter::count(),
            'by_center' => SubjectsOfLearningCenter::selectRaw('learning_center_id, COUNT(*) as count')
                ->groupBy('learning_center_id')
                ->with('learningCenter:id,name')
                ->get(),
            'most_popular' => SubjectsOfLearningCenter::withCount('teachers')
                ->orderBy('teachers_count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
