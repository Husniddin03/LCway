<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\LearningCenter;

/**
 * Markaziy Osiyo ta'lim muassasalarini JSON dan o'qib DB ga saqlovchi seeder.
 *
 * Foydalanish:
 *   php artisan db:seed --class=CentralAsiaSeeder
 *
 * Faqat bitta davlat:
 *   php artisan db:seed --class=CentralAsiaSeeder --country=uzbekistan
 */
class CentralAsiaSeeder extends Seeder
{
    // ── Sozlamalar ────────────────────────────────────────────────

    /** JSON fayllar joylashgan papka */
    protected string $dataDir;

    /** Rasmlarni yuklab olib storage ga saqlasinmi? */
    protected bool $downloadImages = false;   // true = yuklaydi (sekin), false = URL saqlaydi

    /** Mavjud yozuvni yangilashmi? */
    protected bool $updateExisting = true;

    /** Sharhlar uchun default user_id */
    protected int $defaultUserId = 1;

    /** Har bir davlat JSON fayllari */
    protected array $countryFiles = [
        'uzbekistan'   => 'uzbekistan.json',
    ];

    public function __construct()
    {
        $this->dataDir = database_path('data');
    }

    // ─────────────────────────────────────────────────────────────
    public function run(): void
    // ─────────────────────────────────────────────────────────────
    {
        // --country=uzbekistan argumentini ushlash (agar mavjud bo'lsa)
        $onlyCountry = null;
        if (method_exists($this->command, 'option')) {
            try {
                $onlyCountry = $this->command->option('country') ?? null;
            } catch (\Exception $e) {
                // Option mavjud emas, barcha davlatlarni ishlatamiz
            }
        }

        $this->command->info('✅ Calendar days ready');
        $this->command->newLine();

        if ($this->downloadImages) {
            Storage::disk('public')->makeDirectory('learning_centers');
        }

        $grandStats = ['new' => 0, 'updated' => 0, 'skipped' => 0,
                       'images' => 0, 'hours' => 0, 'conns' => 0, 'comments' => 0, 'errors' => 0];

        foreach ($this->countryFiles as $countryKey => $fileName) {

            if ($onlyCountry && $onlyCountry !== $countryKey) {
                continue;
            }

            $filePath = $this->dataDir . DIRECTORY_SEPARATOR . $fileName;

            if (!File::exists($filePath)) {
                $this->command->warn("⏭  Fayl topilmadi: {$filePath}");
                continue;
            }

            $payload  = json_decode(File::get($filePath), true);
            $centers  = $payload['centers']  ?? [];
            $country  = $payload['country_name'] ?? $countryKey;
            $total    = count($centers);

            $this->command->info("═══════════════════════════════════════════════════");
            $this->command->info("  🌍 {$country}  ({$total} ta muassasa)  [{$fileName}]");
            $this->command->info("═══════════════════════════════════════════════════");

            $stats = ['new' => 0, 'updated' => 0, 'skipped' => 0,
                      'images' => 0, 'hours' => 0, 'conns' => 0, 'comments' => 0, 'errors' => 0];

            foreach ($centers as $i => $center) {
                $num  = $i + 1;
                $name = $center['name'] ?? 'Noma\'lum';

                try {
                    DB::beginTransaction();

                    [$centerId, $isNew] = $this->upsertCenter($center);

                    if ($centerId === null) {
                        $stats['skipped']++;
                        DB::rollBack();
                        continue;
                    }

                    $isNew ? $stats['new']++ : $stats['updated']++;

                    // Logo ni learning_centers.logo ga saqlash (upsertda qilinadi)
                    // Rasmlarni learning_centers_images ga saqlash
                    $imgCount  = $this->seedImages($centerId, $center['images'] ?? []);
                    $stats['images'] += $imgCount;

                    // Ish vaqtlari
                    $hrCount   = $this->seedWorkingHours($centerId, $center['working_hours'] ?? []);
                    $stats['hours'] += $hrCount;

                    // Kontaktlar
                    $connCount = $this->seedConnections($centerId, $center['connections'] ?? []);
                    $stats['conns'] += $connCount;

                    // Sharhlar
                    $revCount  = $this->seedReviews($centerId, $center['reviews'] ?? []);
                    $stats['comments'] += $revCount;

                    DB::commit();

                    $label = $isNew ? '✅' : '🔄';
                    $logo  = $center['logo'] ? '🖼' : ' ';
                    $this->command->line(
                        sprintf("  [%4d/%d] %s%s %s | 📷%d ⏰%d 🔗%d 💬%d",
                            $num, $total, $label, $logo, $name, $imgCount, $hrCount, $connCount, $revCount)
                    );

                } catch (\Throwable $e) {
                    DB::rollBack();
                    $stats['errors']++;
                    $this->command->error("  [{$num}/{$total}] ❌ {$name}: {$e->getMessage()}");
                }
            }

            // Davlat statistikasi
            $this->printStats($stats, $country);

            foreach ($stats as $k => $v) {
                $grandStats[$k] += $v;
            }

            $this->command->newLine();
        }

        // Umumiy hisobot
        $this->command->info('╔══════════════════════════════════╗');
        $this->command->info('║   UMUMIY YAKUNIY HISOBOT         ║');
        $this->command->info('╚══════════════════════════════════╝');
        $this->printStats($grandStats, 'JAMI');
    }

    // ─────────────────────────────────────────────────────────────
    // YORDAMCHI METODLAR
    // ─────────────────────────────────────────────────────────────


    /**
     * learning_centers jadvaliga qo'shadi yoki yangilaydi.
     * Logo → learning_centers.logo ustuniga saqlanadi.
     *
     * @return array{int|null, bool}  [$id, $isNew]
     */
    private function upsertCenter(array $c): array
    {
        $name    = $c['name']    ?? 'Noma\'lum';
        $address = $c['address'] ?? '';

        // Logo URL ni optionnal yuklash
        $logoPath = $this->resolveLogoPath($c['logo'] ?? null, $name);

        $data = [
            'logo'       => $logoPath,
            'slug'       => LearningCenter::generateUniqueSlug($name),
            'type'       => $c['type']     ?? "O'quv markaz",
            'about'      => $c['about']    ?? null,
            'province'   => $c['province'] ?? '',
            'region'     => $c['region']   ?? '',
            'address'    => $address,
            'location'   => $c['location'] ?? null,
            'rating'     => (float) ($c['rating'] ?? 0),
            'total_reyting' => (float) ($c['rating'] ?? 0), // Initial total_reyting equals rating
            'ratings_total' => (int) ($c['ratings_total'] ?? 0),
            'status'     => $c['status'] ?? 'active',
            'updated_at' => now(),
        ];

        $existing = DB::table('learning_centers')
            ->where('name', $name)
            ->where('address', $address)
            ->first();

        if ($existing) {
            if (!$this->updateExisting) return [null, false];
            DB::table('learning_centers')->where('id', $existing->id)->update($data);
            return [$existing->id, false];
        }

        $id = DB::table('learning_centers')->insertGetId(array_merge($data, [
            'name'          => $name,
            'users_id'      => $this->defaultUserId,
            'student_count' => 0,
            'created_at'    => now(),
        ]));
        return [$id, true];
    }


    /**
     * Logo URL ni hal qiladi:
     *  - downloadImages = true  → yuklab saqlaydi, yo'lni qaytaradi
     *  - downloadImages = false → URL ni qaytaradi
     */
    private function resolveLogoPath(?string $url, string $name): ?string
    {
        if (!$url) return null;

        // Skip Google Maps images
        if (str_starts_with($url, 'https://maps.')) {
            return null;
        }

        if (!$this->downloadImages) return $url;

        $slug     = preg_replace('/[^a-z0-9]/i', '_', mb_strtolower($name));
        $filename = "learning_centers/logo_{$slug}.jpg";

        try {
            $resp = Http::timeout(20)->get($url);
            if ($resp->successful()) {
                Storage::disk('public')->put($filename, $resp->body());
                return $filename;
            }
        } catch (\Throwable) {}

        return $url; // yuklanmasa URL ni qaytaradi
    }


    /**
     * Rasmlarni learning_centers_images ga saqlaydi.
     * (Logo bu yerda EMAS — u allaqachon learning_centers.logo da)
     */
    private function seedImages(int $centerId, array $images): int
    {
        $count = 0;
        foreach ($images as $i => $img) {
            $url = $img['url'] ?? null;
            if (!$url) continue;

            // Skip Google Maps images
            if (str_starts_with($url, 'https://maps.')) {
                continue;
            }

            $path = $url;
            $imagePath = $url;
            $imageUrl = $url;
            $photoReference = $img['photo_reference'] ?? null;
            $width = (int) ($img['width'] ?? 0);
            $height = (int) ($img['height'] ?? 0);
            $isPrimary = (bool) ($img['is_primary'] ?? false);

            if ($this->downloadImages) {
                $filename = "learning_centers/img_{$centerId}_{$i}.jpg";
                try {
                    $resp = Http::timeout(20)->get($url);
                    if ($resp->successful()) {
                        Storage::disk('public')->put($filename, $resp->body());
                        $path = $filename;
                        $imagePath = $filename;
                        $imageUrl = Storage::url($filename);
                    }
                } catch (\Throwable) {}
            }

            $exists = DB::table('learning_centers_images')
                ->where('learning_centers_id', $centerId)
                ->where('image', $path)
                ->exists();

            if (!$exists) {
                DB::table('learning_centers_images')->insert([
                    'learning_centers_id' => $centerId,
                    'image'               => mb_substr((string)$path, 0, 255),
                    'image_path'          => mb_substr((string)$imagePath, 0, 255),
                    'image_url'           => mb_substr((string)$imageUrl, 0, 255),
                    'photo_reference'     => $photoReference,
                    'width'               => $width,
                    'height'              => $height,
                    'is_primary'           => $isPrimary,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                $count++;
            }
        }
        return $count;
    }


    private function seedWorkingHours(int $centerId, array $hours): int
    {
        $count = 0;
        foreach ($hours as $hour) {
            $weekday = $hour['weekday'] ?? null;
            if (!$weekday) continue;

            $openTime  = $hour['open_time']  ?? '09:00:00';
            $closeTime = $hour['close_time'] ?? '18:00:00';

            $exists = DB::table('learning_centers_calendar')
                ->where('learning_centers_id', $centerId)
                ->where('weekdays', $weekday)->exists();

            if ($exists) {
                DB::table('learning_centers_calendar')
                    ->where('learning_centers_id', $centerId)
                    ->where('weekdays', $weekday)
                    ->update(['open_time' => $openTime, 'close_time' => $closeTime, 'updated_at' => now()]);
            } else {
                DB::table('learning_centers_calendar')->insert([
                    'learning_centers_id' => $centerId,
                    'weekdays'            => $weekday,
                    'open_time'           => $openTime,
                    'close_time'          => $closeTime,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                $count++;
            }
        }
        return $count;
    }


    private function seedConnections(int $centerId, array $connections): int
    {
        $count = 0;
        foreach ($connections as $conn) {
            $type = $conn['type'] ?? null;
            $url  = $conn['url']  ?? null;
            if (!$type || !$url) continue;

            $exists = DB::table('learning_centers_connect')
                ->where('learning_centers_id', $centerId)
                ->where('connection_name', $type)->exists();

            if (!$exists) {
                DB::table('learning_centers_connect')->insert([
                    'learning_centers_id' => $centerId,
                    'connection_name'   => $type,
                    'connection_icon'   => $type,
                    'url'               => mb_substr((string)$url, 0, 255),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
                $count++;
            }
        }
        return $count;
    }


    private function seedReviews(int $centerId, array $reviews): int
    {
        $count = 0;
        foreach ($reviews as $review) {
            // reviews massivi ichida string yoki array bo'lishi mumkin
            $text = is_array($review) ? ($review['text'] ?? '') : $review;
            $text = trim((string) $text);
            if (!$text) continue;

            $exists = DB::table('learning_centers_comments')
                ->where('learning_centers_id', $centerId)
                ->where('comment', $text)->exists();

            if (!$exists) {
                DB::table('learning_centers_comments')->insert([
                    'learning_centers_id' => $centerId,
                    'users_id'            => $this->defaultUserId,
                    'comment'             => $text,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                $count++;
            }
        }
        return $count;
    }


    private function printStats(array $s, string $label): void
    {
        $this->command->newLine();
        $this->command->info("  ── {$label} statistikasi ──────────────────────");
        $this->command->info("  ✅ Yangi:        {$s['new']}");
        $this->command->info("  🔄 Yangilandi:   {$s['updated']}");
        $this->command->info("  ⏭  O'tkazildi:  {$s['skipped']}");
        $this->command->info("  🖼  Rasmlar:      {$s['images']}");
        $this->command->info("  ⏰ Ish vaqti:    {$s['hours']}");
        $this->command->info("  🔗 Kontaktlar:   {$s['conns']}");
        $this->command->info("  💬 Sharhlar:     {$s['comments']}");
        $this->command->info("  ❌ Xatolar:      {$s['errors']}");
    }
}