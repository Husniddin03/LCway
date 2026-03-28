<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanDuplicatesSimpleSeeder extends Seeder
{
    /**
     * Run database seeds.
     */
    public function run(): void
    {
        $this->command->info('🧹 Dublikatlarni tozalash boshlandi...');
        
        try {
            // Avval barcha learning centerlarni olish
            $centers = DB::table('learning_centers')->get();
            
            $duplicates = [];
            $toDelete = [];
            
            // Dublikatlarni topish
            foreach ($centers as $center) {
                $key = $center->name . '|' . $center->province . '|' . $center->region . '|' . $center->address;
                
                if (!isset($duplicates[$key])) {
                    $duplicates[$key] = $center;
                } else {
                    // Mavjud bo'lsa, eng oxirgisini saqlab qolish
                    if ($center->created_at > $duplicates[$key]->created_at) {
                        $toDelete[] = $duplicates[$key]->id;
                        $duplicates[$key] = $center;
                    } else {
                        $toDelete[] = $center->id;
                    }
                }
            }
            
            if (empty($toDelete)) {
                $this->command->info('✅ Dublikatlar topilmadi!');
                return;
            }
            
            $this->command->info("📊 " . count($toDelete) . " ta dublikat topildi");
            
            // Bog'liq ma'lumotlarni o'chirish
            $this->cleanRelatedData($toDelete);
            
            // Dublikatlarni o'chirish - oddiy SQL
            foreach ($toDelete as $id) {
                DB::table('learning_centers')->where('id', $id)->delete();
            }
            
            $this->command->info("🗑️  " . count($toDelete) . " ta dublikat o'chirildi");
            
            // Qolganlar soni
            $remaining = DB::table('learning_centers')->count();
            $this->command->info("📋 Qolgan learning centerlar: {$remaining} ta");
            
            Log::info("CleanDuplicatesSimpleSeeder: " . count($toDelete) . " duplicates removed, {$remaining} centers remaining");
            
        } catch (\Exception $e) {
            $this->command->error("❌ Xatolik: " . $e->getMessage());
            Log::error("CleanDuplicatesSimpleSeeder error: " . $e->getMessage());
        }
    }
    
    /**
     * Bog'liq ma'lumotlarni tozalash
     */
    private function cleanRelatedData(array $centerIds): void
    {
        DB::table('learning_centers_images')
            ->whereIn('learning_centers_id', $centerIds)
            ->delete();

        DB::table('learning_center_working_hours')
            ->whereIn('learning_center_id', $centerIds)
            ->delete();

        DB::table('learning_centers_connect')
            ->whereIn('learning_centers_id', $centerIds)
            ->delete();

        DB::table('learning_centers_comments')
            ->whereIn('learning_centers_id', $centerIds)
            ->delete();

        DB::table('favorites')
            ->whereIn('learning_centers_id', $centerIds)
            ->delete();
    }
}
