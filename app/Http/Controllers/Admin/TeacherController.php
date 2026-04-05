<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Get all teachers with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $query = Teacher::query();

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
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
        $teachers = $query->with(['learningCenter:id,name'])->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    }

    /**
     * Get single teacher with relations
     */
    public function show(int $id): JsonResponse
    {
        $teacher = Teacher::with([
            'learningCenter:id,name,address',
            'subjects:id,name'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $teacher
        ]);
    }

    /**
     * Create new teacher
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'learning_center_id' => 'required|integer|exists:learning_centers,id',
        ]);

        $teacher = Teacher::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully',
            'data' => $teacher
        ], 201);
    }

    /**
     * Update teacher
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'learning_center_id' => 'sometimes|integer|exists:learning_centers,id',
        ]);

        $teacher->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully',
            'data' => $teacher
        ]);
    }

    /**
     * Delete teacher
     */
    public function destroy(int $id): JsonResponse
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully'
        ]);
    }

    /**
     * Bulk delete teachers
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:teachers,id',
        ]);

        Teacher::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teachers deleted successfully'
        ]);
    }

    /**
     * Get teacher statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => Teacher::count(),
            'by_center' => Teacher::selectRaw('learning_center_id, COUNT(*) as count')
                ->groupBy('learning_center_id')
                ->with('learningCenter:id,name')
                ->get(),
            'created_this_month' => Teacher::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
