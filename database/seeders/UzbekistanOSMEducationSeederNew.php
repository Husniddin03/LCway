<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningCenter;
use App\Models\LearningCenterImage;
use App\Models\LearningCenterWorkingHour;
use App\Models\LearningCenterConnection;
use App\Models\LearningCenterReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UzbekistanOSMEducationSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Ozbekiston ta\'lim muassasalarini yig\'ish boshlandi...');
        
        $jsonFile = database_path('data/uzbekistan_major_cities_osm.json');
        
        if (!file_exists($jsonFile)) {
            $this->command->error('❌ JSON fayl topilmadi: ' . $jsonFile);
            return;
        }
        
        $this->command->info('📄 JSON fayl oqilmoqda...');
        
        $jsonData = json_decode(file_get_contents($jsonFile), true);
        
        if (!$jsonData || !isset($jsonData['centers'])) {
            $this->command->error('❌ JSON fayl formati notogri');
            return;
        }
        
        $centers = $jsonData['centers'];
        $total = count($centers);
        
        $this->command->info("📊 Jami {$total} ta ta'lim muassasi topildi");
        $this->command->info('💾 Ma\'lumotlar saqlanmoqda...');
        
        DB::beginTransaction();
        
        try {
            $savedCount = 0;
            $progressBar = $this->command->getOutput()->createProgressBar($total);
            $progressBar->start();
            
            foreach ($centers as $index => $centerData) {
                $savedCenter = $this->saveLearningCenter($centerData);
                
                if ($savedCenter) {
                    $this->saveRelatedData($savedCenter, $centerData);
                    $savedCount++;
                }
                
                // Progress update
                if ($index % 50 === 0) {
                    $progress = round(($index / $total) * 100, 1);
                    $this->command->line("  📊 Progress: {$progress}% ({$index}/{$total}) | ✅ Saqlandi: {$savedCount}");
                }
                
                $progressBar->advance();
            }
            
            $progressBar->finish();
            $this->command->newLine();
            
            DB::commit();
            
            $this->command->info("✅ {$savedCount} ta ta\'lim muassasi muvaffaqiyatli saqlandi!");
            
            // Statistika
            $this->showStatistics();
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Xatolik yuz berdi: ' . $e->getMessage());
            Log::error('UzbekistanOSMEducationSeeder error: ' . $e->getMessage());
        }
    }
    
    /**
     * LearningCenter saqlash
     */
    private function saveLearningCenter(array $data): ?LearningCenter
    {
        // Nomlari bo'sh yoki "Noma'lum" bo'lganlarini otkazib yuborish
        if (empty($data['name']) || $data['name'] === 'Noma\'lum') {
            return null;
        }
        
        // Dublikatlarni tekshirish
        $existing = LearningCenter::where('name', $data['name'])
            ->where('location', $data['location'])
            ->first();
            
        if ($existing) {
            return null;
        }
        
        return LearningCenter::create([
            'name' => $data['name'],
            'type' => $data['type'] ?? 'Boshqa ta\'lim muassasasi',
            'about' => $data['about'] ?? null,
            'country' => $data['country'] ?? 'uzbekistan',
            'province' => $data['province'] ?? '',
            'region' => $data['region'] ?? '',
            'address' => $data['address'] ?? '',
            'location' => $data['location'] ?? null,
            'logo' => substr($data['logo'] ?? '', 0, 65535) ?: null, // Keep text logic if needed, but safe
            'rating' => $data['rating'] ?? null,
            'total_reyting' => (float) ($data['rating'] ?? 0), // Initial total_reyting equals Google rating
            'ratings_total' => $data['ratings_total'] ?? 0,
            'status' => $data['status'] ?? 'active',
        ]);
    }
    
    /**
     * Bog'liq ma'lumotlarni saqlash
     */
    private function saveRelatedData(LearningCenter $center, array $data): void
    {
        // Rasmlar
        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $image) {
                DB::table('learning_centers_images')->insert([
                    'learning_centers_id' => $center->id,
                    'image_path' => mb_substr($image['image_path'] ?? '', 0, 255),
                    'image_url' => mb_substr($image['image_url'] ?? '', 0, 255),
                    'photo_reference' => $image['photo_reference'] ?? '',
                    'width' => (int) ($image['width'] ?? 0),
                    'height' => (int) ($image['height'] ?? 0),
                    'is_primary' => (bool) ($image['is_primary'] ?? false),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Ish vaqtlari
        if (!empty($data['working_hours']) && is_array($data['working_hours'])) {
            foreach ($data['working_hours'] as $hour) {
                $weekday = $hour['weekday'] ?? '';
                
                if ($weekday) {
                    DB::table('learning_centers_calendar')->insert([
                        'learning_centers_id' => $center->id,
                        'weekdays' => $weekday,
                        'open_time' => $hour['open_time'] ?? '',
                        'close_time' => $hour['close_time'] ?? '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Kontaktlar
        if (!empty($data['connections']) && is_array($data['connections'])) {
            foreach ($data['connections'] as $connection) {
                $type = $connection['type'] ?? '';
                $url = $connection['url'] ?? '';
                
                if ($type && $url) {
                    DB::table('learning_centers_connect')->insert([
                        'learning_centers_id' => $center->id,
                        'connection_name' => $type,
                        'connection_icon' => $type,
                        'url' => mb_substr($url, 0, 255),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Sharhlar
        if (!empty($data['reviews']) && is_array($data['reviews'])) {
            foreach ($data['reviews'] as $review) {
                DB::table('learning_centers_comments')->insert([
                    'learning_centers_id' => $center->id,
                    'users_id' => 1, // Default user
                    'comment' => $review['text'] ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    
    /**
     * Statistikani ko\'rsatish
     */
    private function showStatistics(): void
    {
        $this->command->newLine();
        $this->command->info('📊 STATISTIKA:');
        
        $total = LearningCenter::count();
        $byType = LearningCenter::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get();
        
        foreach ($byType as $type) {
            $percentage = round(($type->count / $total) * 100, 1);
            $this->command->line("   📚 " . str_pad($type->type, 25) . ": " . str_pad($type->count, 4, " ", STR_PAD_LEFT) . " ta ({$percentage}%)");
        }
        
        $byProvince = LearningCenter::selectRaw('province, COUNT(*) as count')
            ->whereNotNull('province')
            ->where('province', '!=', '')
            ->groupBy('province')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        $this->command->newLine();
        $this->command->info('🏙️ Viloyatlar bo\'yicha (Top 5):');
        
        foreach ($byProvince as $province) {
            $this->command->line("   📍 " . str_pad($province->province, 15) . ": " . str_pad($province->count, 3, " ", STR_PAD_LEFT) . " ta");
        }
        
        $this->command->newLine();
        $this->command->info("🎉 Jami {$total} ta ta\'lim muassasi muvaffaqiyatli saqlandi!");
        $this->command->info('📄 Ma\'lumot manbai: OpenStreetMap (OSM) - API kalitsiz');
    }
}
