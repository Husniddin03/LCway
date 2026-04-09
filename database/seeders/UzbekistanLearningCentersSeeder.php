<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningCenter;
use App\Models\LearningCentersImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UzbekistanLearningCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('learning_centers_images')->where('learning_centers_id', '>', 0)->delete();
        LearningCenter::whereNotNull('id')->delete();
        
        // Read JSON data
        $jsonPath = database_path('data/uzbekistan_learning_centers.json');
        
        if (!file_exists($jsonPath)) {
            $this->command->error('JSON file not found: ' . $jsonPath);
            return;
        }
        
        $jsonData = json_decode(file_get_contents($jsonPath), true);
        
        if (!isset($jsonData['centers']) || !is_array($jsonData['centers'])) {
            $this->command->error('Invalid JSON structure');
            return;
        }
        
        $centers = $jsonData['centers'];
        $total = count($centers);
        
        $this->command->info("Seeding {$total} learning centers from Uzbekistan data...");
        
        // Get default user ID (you may need to adjust this)
        $defaultUserId = DB::table('users')->value('id') ?? 1;
        
        foreach ($centers as $index => $centerData) {
            try {
                // Extract and clean data
                $learningCenter = [
                    'name' => $this->cleanString($centerData['name'] ?? ''),
                    'type' => $this->cleanString($centerData['type'] ?? 'O\'quv markazi'),
                    'about' => $this->cleanString($centerData['about'] ?? ''),
                    'country' => 'uzbekistan',
                    'province' => $this->cleanString($centerData['province'] ?? ''),
                    'region' => $this->cleanString($centerData['region'] ?? ''),
                    'address' => $this->cleanString($centerData['address'] ?? ''),
                    'location' => $centerData['location'] ?? '',
                    'rating' => (float) ($centerData['rating'] ?? 0),
                    'total_reyting' => (float) ($centerData['rating'] ?? 0), // Initial total_reyting equals rating
                    'ratings_total' => (int) ($centerData['ratings_total'] ?? 0),
                    'users_id' => $defaultUserId,
                    'student_count' => 0,
                    'status' => $centerData['status'] ?? 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Create learning center
                $center = LearningCenter::create($learningCenter);
                
                // Handle images if available
                if (isset($centerData['images']) && is_array($centerData['images'])) {
                    $this->seedImages($center->id, $centerData['images']);
                }
                
                // Progress indicator
                if (($index + 1) % 100 === 0) {
                    $this->command->info("Processed " . ($index + 1) . " / {$total} centers");
                }
                
            } catch (\Exception $e) {
                $this->command->error("Error processing center {$index}: " . $e->getMessage());
                continue;
            }
        }
        
        $this->command->info("Successfully seeded {$total} learning centers!");
    }
    
    /**
     * Seed images for a learning center
     */
    private function seedImages($centerId, array $images): void
    {
        foreach ($images as $imageData) {
            try {
                // Download and store image (optional - you can skip this for now)
                $imageUrl = $imageData['url'] ?? '';
                
                if (!empty($imageUrl)) {
                    // Skip Google Maps images
                    if (str_starts_with($imageUrl, 'https://maps.')) {
                        continue;
                    }

                    // For now, just store URL as image reference
                    DB::table('learning_centers_images')->insert([
                        'learning_centers_id' => $centerId,
                        'image' => $imageUrl,
                        'image_path' => $imageData['image_path'] ?? $imageUrl,
                        'image_url' => $imageData['image_url'] ?? $imageUrl,
                        'photo_reference' => $imageData['photo_reference'] ?? null,
                        'width' => (int) ($imageData['width'] ?? 0),
                        'height' => (int) ($imageData['height'] ?? 0),
                        'is_primary' => (bool) ($imageData['is_primary'] ?? false),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                // Skip image if there's an error
                continue;
            }
        }
    }
    
    /**
     * Clean string data
     */
    private function cleanString(string $string): string
    {
        // Remove extra whitespace and special characters
        return trim(preg_replace('/\s+/', ' ', $string));
    }
}
