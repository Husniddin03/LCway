<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use App\Models\LearningCentersImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LearningCenterController extends Controller
{
    /**
     * Get all learning centers with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $query = LearningCenter::query();

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->has('checked')) {
            $query->where('checked', $request->get('checked'));
        }

        // Filter by premium
        if ($request->has('premium')) {
            $query->where('premium', $request->get('premium'));
        }

        // Filter by region
        if ($request->has('region')) {
            $query->where('region_id', $request->get('region'));
        }

        // Filter by district
        if ($request->has('district')) {
            $query->where('district_id', $request->get('district'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 20);
        $centers = $query->with(['user:id,name,email', 'subjects:id,name'])->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $centers
        ]);
    }

    /**
     * Get single learning center with relations
     */
    public function show(int $id): JsonResponse
    {
        $center = LearningCenter::with([
            'user:id,name,email,phone',
            'subjects:id,name',
            'teachers:id,name,phone,email',
            'images:id,learning_center_id,image',
            'comments' => function ($q) {
                $q->with('user:id,name')->latest();
            },
            'connects',
            'calendars'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $center
        ]);
    }

    /**
     * Create new learning center
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'region_id' => 'required|integer',
            'district_id' => 'required|integer',
            'users_id' => 'required|integer|exists:users,id',
            'checked' => 'sometimes|boolean',
            'premium' => 'sometimes|boolean',
            'premium_until' => 'nullable|date',
        ]);

        $validated['checked'] = $request->boolean('checked', false);
        $validated['premium'] = $request->boolean('premium', false);

        $center = LearningCenter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Learning center created successfully',
            'data' => $center
        ], 201);
    }

    /**
     * Update learning center
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $center = LearningCenter::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'address' => 'sometimes|string|max:500',
            'phone' => 'sometimes|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'region_id' => 'sometimes|integer',
            'district_id' => 'sometimes|integer',
            'users_id' => 'sometimes|integer|exists:users,id',
            'checked' => 'sometimes|boolean',
            'premium' => 'sometimes|boolean',
            'premium_until' => 'nullable|date',
        ]);

        $center->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Learning center updated successfully',
            'data' => $center
        ]);
    }

    /**
     * Delete learning center
     */
    public function destroy(int $id): JsonResponse
    {
        $center = LearningCenter::findOrFail($id);
        $center->delete();

        return response()->json([
            'success' => true,
            'message' => 'Learning center deleted successfully'
        ]);
    }

    /**
     * Verify/Unverify learning center
     */
    public function toggleVerification(int $id): JsonResponse
    {
        $center = LearningCenter::findOrFail($id);

        $center->checked = !$center->checked;
        $center->save();

        return response()->json([
            'success' => true,
            'message' => $center->checked ? 'Center verified' : 'Center unverified',
            'data' => ['checked' => $center->checked]
        ]);
    }

    /**
     * Toggle premium status
     */
    public function togglePremium(int $id): JsonResponse
    {
        $center = LearningCenter::findOrFail($id);

        $center->premium = !$center->premium;
        if ($center->premium && !$center->premium_until) {
            $center->premium_until = now()->addMonth();
        }
        $center->save();

        return response()->json([
            'success' => true,
            'message' => $center->premium ? 'Premium activated' : 'Premium deactivated',
            'data' => [
                'premium' => $center->premium,
                'premium_until' => $center->premium_until
            ]
        ]);
    }

    /**
     * Bulk update learning centers
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:learning_centers,id',
            'checked' => 'sometimes|boolean',
            'premium' => 'sometimes|boolean',
        ]);

        $updateData = [];
        if (isset($validated['checked'])) {
            $updateData['checked'] = $validated['checked'];
        }
        if (isset($validated['premium'])) {
            $updateData['premium'] = $validated['premium'];
        }

        LearningCenter::whereIn('id', $validated['ids'])->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Learning centers updated successfully'
        ]);
    }

    /**
     * Bulk delete learning centers
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:learning_centers,id',
        ]);

        LearningCenter::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Learning centers deleted successfully'
        ]);
    }

    /**
     * Get pending verification centers
     */
    public function pending(): JsonResponse
    {
        $centers = LearningCenter::where('checked', false)
            ->with(['user:id,name,email'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $centers
        ]);
    }

    /**
     * Get center statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total' => LearningCenter::count(),
            'verified' => LearningCenter::where('checked', true)->count(),
            'pending' => LearningCenter::where('checked', false)->count(),
            'premium' => LearningCenter::where('premium', true)->count(),
            'by_region' => LearningCenter::selectRaw('region_id, COUNT(*) as count')
                ->groupBy('region_id')
                ->get(),
            'created_this_month' => LearningCenter::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Delete center image
     */
    public function deleteImage(int $imageId): JsonResponse
    {
        $image = LearningCentersImage::findOrFail($imageId);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
