<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LearningCenterSeeder extends Seeder
{
    /**
     * JSON fayl yo'li (database/data/samarkand_centers.json)
     */
    protected string $jsonPath;

    /**
     * Rasmlarni yuklab olishmi?
     * true  → storage/app/public/learning_centers/ ga saqlaydi
     * false → Google URL ni to'g'ridan-to'g'ri saqlaydi
     */
    protected bool $downloadImages = true;

    /**
     * DB dagi mavjud yozuvni yangilashmi?
     * true  → nom+manzil bo'yicha topsa UPDATE qiladi
     * false → faqat yangi qo'shadi, mavjudlarni o'tkazib yuboradi
     */
    protected bool $updateExisting = true;

    /**
     * Sharhlar uchun default user_id
     */
    protected int $defaultUserId = 1;

    public function __construct()
    {
        $this->jsonPath = database_path('samarkand_centers.json');
    }

    // ──────────────────────────────────────────────
    public function run(): void
    // ──────────────────────────────────────────────
    {
        // JSON faylni tekshirish
        if (!File::exists($this->jsonPath)) {
            $this->command->error("JSON fayl topilmadi: {$this->jsonPath}");
            $this->command->line("Avval Python scriptni ishga tushiring:");
            $this->command->line("  python3 fetch_samarkand.py");
            $this->command->line("  cp samarkand_centers.json database/data/");
            return;
        }

        $payload = json_decode(File::get($this->jsonPath), true);
        $centers = $payload['centers'] ?? [];
        $total   = count($centers);

        $this->command->info("📂 JSON fayl: {$this->jsonPath}");
        $this->command->info("📊 Jami markazlar: {$total}");
        $this->command->info("🕐 Yaratilgan: " . ($payload['generated_at'] ?? 'N/A'));
        $this->command->newLine();

        // Hafta kunlarini oldindan tayyorlab qo'yish
        $calendarIds = $this->ensureCalendar();
        $this->command->info("✅ Calendar tayyorlandi: " . implode(', ', array_keys($calendarIds)));
        $this->command->newLine();

        // Storage papkasi
        if ($this->downloadImages) {
            Storage::disk('public')->makeDirectory('learning_centers');
        }

        // Statistika
        $stats = [
            'new'         => 0,
            'updated'     => 0,
            'skipped'     => 0,
            'images'      => 0,
            'hours'       => 0,
            'connections' => 0,
            'comments'    => 0,
            'errors'      => 0,
        ];

        // ── Har bir markaz ──────────────────────────────
        foreach ($centers as $i => $center) {
            $num  = $i + 1;
            $name = $center['name'] ?? 'Noma\'lum';

            try {
                DB::beginTransaction();

                [$centerId, $isNew] = $this->upsertCenter($center);

                if ($centerId === null) {
                    $stats['skipped']++;
                    DB::rollBack();
                    $this->command->line("  [{$num}/{$total}] ⏭  O'tkazildi: {$name}");
                    continue;
                }

                $isNew ? $stats['new']++ : $stats['updated']++;

                // Rasmlar
                $imgCount = $this->seedImages($centerId, $center['photos'] ?? []);
                $stats['images'] += $imgCount;

                // Ish vaqtlari
                $hrCount = $this->seedWorkingHours($centerId, $center['working_hours'] ?? [], $calendarIds);
                $stats['hours'] += $hrCount;

                // Kontaktlar
                $connCount = $this->seedConnections($centerId, $center['connections'] ?? []);
                $stats['connections'] += $connCount;

                // Sharhlar
                $revCount = $this->seedReviews($centerId, $center['reviews'] ?? []);
                $stats['comments'] += $revCount;

                DB::commit();

                $label = $isNew ? '✅ Yangi' : '🔄 Yangilandi';
                $this->command->line(
                    "  [{$num}/{$total}] {$label} | {$name}"
                    . " | 🖼{$imgCount} ⏰{$hrCount} 🔗{$connCount} 💬{$revCount}"
                );

            } catch (\Throwable $e) {
                DB::rollBack();
                $stats['errors']++;
                $this->command->error("  [{$num}/{$total}] ❌ {$name}: {$e->getMessage()}");
            }
        }

        // ── Yakuniy hisobot ─────────────────────────────
        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('  NATIJA');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info("  ✅ Yangi qo'shildi:  {$stats['new']}");
        $this->command->info("  🔄 Yangilandi:        {$stats['updated']}");
        $this->command->info("  ⏭  O'tkazildi:       {$stats['skipped']}");
        $this->command->info("  🖼  Rasmlar:           {$stats['images']}");
        $this->command->info("  ⏰ Ish vaqtlari:      {$stats['hours']}");
        $this->command->info("  🔗 Kontaktlar:        {$stats['connections']}");
        $this->command->info("  💬 Sharhlar:          {$stats['comments']}");
        $this->command->info("  ❌ Xatolar:           {$stats['errors']}");
        $this->command->info('═══════════════════════════════════════');
    }

    // ──────────────────────────────────────────────
    // YORDAMCHI METODLAR
    // ──────────────────────────────────────────────

    /**
     * calendar jadvalida barcha hafta kunlarini ta'minlaydi.
     * @return array<string, int>  ['Dushanba' => 1, 'Seshanba' => 2, ...]
     */
    private function ensureCalendar(): array
    {
        $days = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];
        $ids  = [];

        foreach ($days as $day) {
            $row = DB::table('calendar')->where('weekdays', $day)->first();
            if ($row) {
                $ids[$day] = $row->id;
            } else {
                $ids[$day] = DB::table('calendar')->insertGetId([
                    'weekdays'   => $day,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return $ids;
    }

    /**
     * Markazni qo'shadi yoki yangilaydi.
     * @return array{int|null, bool}  [$id, $isNew]
     */
    private function upsertCenter(array $c): array
    {
        $name    = $c['name']    ?? 'Noma\'lum';
        $address = $c['address'] ?? '';

        $existing = DB::table('learning_centers')
            ->where('name', $name)
            ->where('address', $address)
            ->first();

        $data = [
            'type'     => $c['type']     ?? "O'quv markaz",
            'about'    => $c['about']    ?? null,
            'province' => $c['province'] ?? 'Samarqand viloyati',
            'region'   => $c['region']   ?? 'Samarqand shahar',
            'address'  => $address,
            'location' => $c['location'] ?? null,
            'updated_at' => now(),
        ];

        if ($existing) {
            if (!$this->updateExisting) {
                return [null, false];
            }
            DB::table('learning_centers')
                ->where('id', $existing->id)
                ->update($data);
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
     * Rasmlarni saqlaydi → learning_centers_images
     */
    private function seedImages(int $centerId, array $photos): int
    {
        $count = 0;

        foreach ($photos as $i => $photo) {
            $url = $photo['url'] ?? null;
            if (!$url) continue;

            $path = $url; // default: URL ni saqlaydi

            if ($this->downloadImages) {
                $filename = "learning_centers/lc_{$centerId}_" . ($i + 1) . ".jpg";

                // Yuklab olishga urinish
                try {
                    $response = Http::timeout(20)->get($url);
                    if ($response->successful()) {
                        Storage::disk('public')->put($filename, $response->body());
                        $path = $filename;
                    }
                } catch (\Throwable) {
                    // Yuklanmasa URL ni saqlaymiz
                    $path = $url;
                }
            }

            // Takrorlanish tekshirish
            $exists = DB::table('learning_centers_images')
                ->where('learning_centers_id', $centerId)
                ->where('image', $path)
                ->exists();

            if (!$exists) {
                DB::table('learning_centers_images')->insert([
                    'learning_centers_id' => $centerId,
                    'image'               => $path,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Ish vaqtlarini saqlaydi → learning_centers_calendar
     */
    private function seedWorkingHours(int $centerId, array $hours, array $calendarIds): int
    {
        $count = 0;

        foreach ($hours as $hour) {
            $weekday = $hour['weekday'] ?? null;
            if (!$weekday || !isset($calendarIds[$weekday])) continue;

            $calId     = $calendarIds[$weekday];
            $openTime  = $hour['open_time']  ?? '09:00:00';
            $closeTime = $hour['close_time'] ?? '18:00:00';

            $exists = DB::table('learning_centers_calendar')
                ->where('learning_centers_id', $centerId)
                ->where('calendar_id', $calId)
                ->exists();

            if ($exists) {
                DB::table('learning_centers_calendar')
                    ->where('learning_centers_id', $centerId)
                    ->where('calendar_id', $calId)
                    ->update([
                        'open_time'  => $openTime,
                        'close_time' => $closeTime,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('learning_centers_calendar')->insert([
                    'learning_centers_id' => $centerId,
                    'calendar_id'         => $calId,
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

    /**
     * Kontaktlarni saqlaydi → connection + learning_centers_connect
     */
    private function seedConnections(int $centerId, array $connections): int
    {
        $count = 0;

        foreach ($connections as $conn) {
            $type = $conn['type'] ?? null;
            $url  = $conn['url']  ?? null;
            if (!$type || !$url) continue;

            // connection jadvalidagi tur
            $connRow = DB::table('connection')->where('name', $type)->first();
            if ($connRow) {
                $connId = $connRow->id;
            } else {
                $connId = DB::table('connection')->insertGetId([
                    'name'       => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Takrorlanish
            $exists = DB::table('learning_centers_connect')
                ->where('learning_centers_id', $centerId)
                ->where('connection_id', $connId)
                ->exists();

            if (!$exists) {
                DB::table('learning_centers_connect')->insert([
                    'learning_centers_id' => $centerId,
                    'connection_id'       => $connId,
                    'url'                 => $url,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Google sharhlarini saqlaydi → learning_centers_comments
     */
    private function seedReviews(int $centerId, array $reviews): int
    {
        $count = 0;

        foreach ($reviews as $text) {
            if (empty(trim($text))) continue;

            $exists = DB::table('learning_centers_comments')
                ->where('learning_centers_id', $centerId)
                ->where('comment', $text)
                ->exists();

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
}