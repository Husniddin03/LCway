<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningCenter;
use App\Models\LearningCentersImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SamarkandCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing Samarkand data
        DB::table('learning_centers_images')->where('learning_centers_id', '>', 0)->delete();
        LearningCenter::where('province', 'Samarqand viloyati')->delete();
        
        // Read JSON data
        $jsonPath = database_path('data/samarkand_centers.json');
        
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
        
        $this->command->info("📚 Samarkand centers ma'lumotlari yuklanmoqda...");
        $this->command->info("📊 Jami {$total} ta markaz topildi");
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($centers as $index => $centerData) {
            try {
                // Create learning center
                $center = LearningCenter::create([
                    'name' => $centerData['name'] ?? 'Noma\'lum markaz',
                    'about' => $centerData['about'] ?? '',
                    'province' => $centerData['province'] ?? 'Samarqand viloyati',
                    'region' => $centerData['region'] ?? '',
                    'address' => $centerData['address'] ?? '',
                    'location' => $centerData['location'] ?? '0,0',
                    'rating' => (float) ($centerData['rating'] ?? 0),
                    'total_reyting' => (float) ($centerData['rating'] ?? 0), // Initial total_reyting equals Google rating
                    'ratings_total' => (int) ($centerData['ratings_total'] ?? 0),
                    'type' => $centerData['type'] ?? 'O\'quv markaz',
                    'status' => 'active',
                ]);
                
                // Handle photos if they exist
                if (!empty($centerData['photos']) && is_array($centerData['photos'])) {
                    foreach ($centerData['photos'] as $photoIndex => $photoData) {
                        $imageUrl = $photoData['image_url'] ?? '';

                        // Skip Google Maps images
                        if (str_starts_with($imageUrl, 'https://maps.')) {
                            continue;
                        }

                        DB::table('learning_centers_images')->insert([
                            'learning_centers_id' => $center->id,
                            'image_path' => $photoData['image_path'] ?? '',
                            'image_url' => $photoData['image_url'] ?? '',
                            'photo_reference' => $photoData['photo_reference'] ?? '',
                            'width' => (int) ($photoData['width'] ?? 0),
                            'height' => (int) ($photoData['height'] ?? 0),
                            'is_primary' => $photoIndex === 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                
                $successCount++;
                
                // Show progress
                if (($index + 1) % 20 === 0 || $index === $total - 1) {
                    $progress = round((($index + 1) / $total) * 100, 1);
                    $this->command->line("   📈 Progress: {$progress}% (" . ($index + 1) . "/{$total})");
                }
                
            } catch (\Exception $e) {
                $errorCount++;
                $this->command->error("❌ Xatolik (" . ($centerData['name'] ?? 'Unknown') . "): " . $e->getMessage());
            }
        }
        
        // Show statistics
        $this->command->newLine();
        $this->command->info("✅ Muvaffaqiyatli saqlandi: {$successCount} ta");
        if ($errorCount > 0) {
            $this->command->error("❌ Xatoliklar: {$errorCount} ta");
        }
        
        // Show statistics by region
        $byRegion = LearningCenter::where('province', 'Samarqand viloyati')
            ->select('region', DB::raw('count(*) as count'))
            ->where('region', '!=', '')
            ->groupBy('region')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        $this->command->newLine();
        $this->command->info('🏙️ Tumanlar bo\'yicha (Top 5):');
        
        foreach ($byRegion as $region) {
            $this->command->line("   📍 " . str_pad($region->region, 20) . ": " . str_pad($region->count, 3, " ", STR_PAD_LEFT) . " ta");
        }
        
        $this->command->newLine();
        $this->command->info("🎉 Samarkand uchun jami {$successCount} ta ta'lim markazi muvaffaqiyatli saqlandi!");
        $this->command->info('📄 Ma\'lumot manbai: Google Places API - Samarkand centers');
    }
}
