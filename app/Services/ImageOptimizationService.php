<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
// use Intervention\Image\Drivers\Gd\Driver; // Uncomment if GD is available
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimizationService
{
    protected ?ImageManager $manager = null;
    protected $optimizerChain;

    public function __construct()
    {
        $this->optimizerChain = OptimizerChainFactory::create();
    }

    protected function getManager(): ImageManager
    {
        if ($this->manager === null) {
            $this->manager = new ImageManager(new Driver());
        }
        return $this->manager;
    }

    /**
     * Optimize and convert image to WebP format
     */
    public function optimizeImage(UploadedFile $file, string $directory = 'uploads'): string
    {
        // Store original file first
        $path = $file->store($directory, 'public');
        
        // Optimize the stored image using spatie optimizer
        $fullPath = Storage::disk('public')->path($path);
        if (file_exists($fullPath)) {
            $this->optimizerChain->optimize($fullPath);
        }

        // Create image instance using read (Intervention Image v3)
        $image = $this->getManager()->read($fullPath);

        // Resize if width is greater than 1200px while maintaining aspect ratio
        if ($image->width() > 1200) {
            $image = $image->scaleDown(1200, null);
        }

        // Convert to WebP format with 85% quality
        $encoded = $image->toWebp(85);

        // Generate unique filename
        $filename = uniqid() . '.webp';
        $webpPath = $directory . '/' . $filename;

        // Store optimized image
        Storage::disk('public')->put($webpPath, $encoded);

        // Optimize the stored image using spatie optimizer
        $webpFullPath = Storage::disk('public')->path($webpPath);
        if (file_exists($webpFullPath)) {
            $this->optimizerChain->optimize($webpFullPath);
        }

        return $webpPath;
    }

    /**
     * Optimize existing image file
     */
    public function optimizeExistingImage(string $filePath): void
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            return;
        }

        // Just optimize existing image
        $this->optimizerChain->optimize($fullPath);
    }

    /**
     * Get image dimensions for aspect ratio calculation
     */
    public function getImageDimensions(string $filePath): array
    {
        try {
            $fullPath = Storage::disk('public')->path($filePath);
            if (!file_exists($fullPath)) {
                return ['width' => 1200, 'height' => 800];
            }

            // Use getimagesize for basic dimensions
            $dimensions = getimagesize($fullPath);
            if ($dimensions) {
                return [
                    'width' => $dimensions[0],
                    'height' => $dimensions[1]
                ];
            }
            
            return ['width' => 1200, 'height' => 800];
        } catch (\Exception $e) {
            return ['width' => 1200, 'height' => 800];
        }
    }
}
