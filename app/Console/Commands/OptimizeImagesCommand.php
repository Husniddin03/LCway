<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize {--force : Force re-optimization of all images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize all existing images in storage by converting to WebP and resizing';

    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        parent::__construct();
        $this->imageService = $imageService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image optimization...');
        $force = $this->option('force');

        // Get all image files from public storage
        $directories = [
            'uploads/logos',
            'uploads/centers',
            'uploads/learning-centers',
        ];

        $totalOptimized = 0;
        $totalSkipped = 0;

        foreach ($directories as $directory) {
            $this->info("Processing directory: {$directory}");
            
            if (!Storage::disk('public')->exists($directory)) {
                $this->warn("Directory {$directory} does not exist, skipping...");
                continue;
            }

            $files = Storage::disk('public')->allFiles($directory);
            $imageFiles = array_filter($files, function($file) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            });

            $progressBar = $this->output->createProgressBar(count($imageFiles));
            $progressBar->start();

            foreach ($imageFiles as $file) {
                // Skip if already WebP and not forcing
                if (!$force && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'webp') {
                    $totalSkipped++;
                    $progressBar->advance();
                    continue;
                }

                try {
                    $this->imageService->optimizeExistingImage($file);
                    $totalOptimized++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("Failed to optimize {$file}: " . $e->getMessage());
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine();
        }

        $this->newLine();
        $this->info("Optimization complete!");
        $this->info("Total optimized: {$totalOptimized}");
        $this->info("Total skipped: {$totalSkipped}");

        return 0;
    }
}
