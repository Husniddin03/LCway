<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

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
    public function edit(LearningCenter $center)
    {
        $center->load('user');
        Gate::authorize('isOun', $center);
        $LearningCenter = $center;
        return view('center.edit-image', compact('LearningCenter'));
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

    public function store(Request $request, LearningCenter $center) {
        $center->load('user');
        Gate::authorize('isOun', $center);

        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Use the optimization service to convert to WebP and resize
                $path = $this->imageService->optimizeImage($image, 'uploads/centers');
                LearningCentersImage::create([
                    'learning_centers_id' =>  $center->id,
                    'image' => $path,
                ]);
            }
        }

        return back()->with('success', 'Muoffaqoyatli yuklandi');
    }
}
