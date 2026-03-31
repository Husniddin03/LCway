<?php

namespace App\Http\Controllers;

use App\Models\LearningCenter;
use App\Models\LearningCentersImage;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function edit(string $id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        return view('course.editImage', compact('LearningCenter'));
    }

    public function delete(string $id)
    {
        $image = LearningCentersImage::find($id);
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();
        return back()->with('success', 'muoffaqiyatli o\'chirildi');
    }

    public function store(Request $request, string $centerId) {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Use the optimization service to convert to WebP and resize
                $path = $this->imageService->optimizeImage($image, 'uploads/centers');
                LearningCentersImage::create([
                    'learning_centers_id' =>  $centerId,
                    'image' => $path,
                ]);
            }
        }

        return back()->with('success', 'Muoffaqoyatli yuklandi');
    }
}
