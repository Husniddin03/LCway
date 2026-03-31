<?php

namespace App\Services\Bot;

use App\Models\LearningCenter;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotSearchService
{
    public static function searchCenters(int $chatId, string $query): void
    {
        try {
            // Sodda qidiruv
            $centers = LearningCenter::where('name', 'like', "%{$query}%")
                ->take(10)
                ->get(['id', 'name']);

            \Log::info('Search results for "' . $query . '": ' . $centers->count() . ' centers found');

            if ($centers->isEmpty()) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "❌ *\"{$query}\" boʻyicha markazlar topilmadi.*\n\n💡 *Tavsiya:* Boshqa kalit soʻzlar bilan urinib koʻring.",
                    'parse_mode' => 'Markdown'
                ]);
                return;
            }

            // Raqamlangan ro'yxat shaklida ko'rsatish
            $keyboard = Keyboard::make()->inline();
            
            foreach ($centers as $index => $center) {
                $number = $index + 1;
                $keyboard->row([
                    Keyboard::inlineButton([
                        'text' => "{$number}. {$center->name}",
                        'callback_data' => 'search_center_' . $center->id
                    ])
                ]);
            }

            // Veb-sayt tugmasi
            $appUrl = env('APP_URL', 'https://your-domain.com');
            $keyboard->row([
                Keyboard::inlineButton([
                    'text' => '🌐 Barchasi veb-saytda',
                    'url' => "{$appUrl}/search?q=" . urlencode($query)
                ])
            ]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "🔍 *Qidiruv natijalari (\"{$query}\") - {$centers->count()} ta:*\n\n📋 *Natijalar roʻyxati:*",
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        } catch (\Exception $e) {
            \Log::error('Bot searchCenters error: ' . $e->getMessage(), [
                'query' => $query,
                'trace' => $e->getTraceAsString()
            ]);
            
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Xatolik yuz berdi. Iltimos, keyinroq urinib koʻring.'
            ]);
        }
    }

    public static function findNearestCenters(int $chatId, int $userId, float $latitude, float $longitude, int $page = 1): void
    {
        // Get all centers with location data
        $centers = LearningCenter::whereNotNull('location')
            ->get()
            ->map(function ($center) use ($latitude, $longitude) {
                [$centerLat, $centerLon] = explode(',', trim($center->location));
                $distance = self::calculateDistance($latitude, $longitude, (float)$centerLat, (float)$centerLon);
                $center->distance = $distance;
                return $center;
            })
            ->sortBy('distance')
            ->values();

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ *Joylashuv maʼlumotlari boʻyicha markazlar topilmadi.*',
                'parse_mode' => 'Markdown'
            ]);
            return;
        }

        // Cache centers for pagination
        Cache::put("nearest_centers_{$userId}", $centers, now()->addHour());

        // Pagination
        $perPage = 10; // 10 tadan ko'rsatamiz
        $totalPages = ceil($centers->count() / $perPage);
        $paginatedCenters = $centers->slice(($page - 1) * $perPage, $perPage);

        $messageText = "📍 *Eng yaqin markazlar ({$page}/{$totalPages}):*\n\n";

        foreach ($paginatedCenters as $index => $center) {
            $distanceKm = round($center->distance, 2);
            $number = ($page - 1) * $perPage + $index + 1;
            $messageText .= "{$number}. *{$center->name}* - {$distanceKm} km\n";
        }

        $keyboard = Keyboard::make()->inline();

        // Pagination buttons
        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => 'nearest_page_' . ($page - 1)
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$totalPages}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $totalPages) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => 'nearest_page_' . ($page + 1)
            ]);
        }

        if (!empty($paginationRow)) {
            $keyboard->row($paginationRow);
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $messageText,
            'parse_mode' => 'Markdown',
            'reply_markup' => $keyboard
        ]);
    }

    public static function displayNearestPage(int $chatId, $centers, int $page, bool $isEdit = false, $messageId = null): void
    {
        $perPage = 10; // 10 tadan ko'rsatamiz
        $totalPages = ceil($centers->count() / $perPage);
        $paginatedCenters = $centers->slice(($page - 1) * $perPage, $perPage);

        $messageText = "📍 *Eng yaqin markazlar ({$page}/{$totalPages}):*\n\n";

        foreach ($paginatedCenters as $index => $center) {
            $distanceKm = round($center->distance, 2);
            $number = ($page - 1) * $perPage + $index + 1;
            $messageText .= "{$number}. *{$center->name}* - {$distanceKm} km\n";
        }

        $keyboard = Keyboard::make()->inline();

        // Pagination buttons
        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => 'nearest_page_' . ($page - 1)
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$totalPages}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $totalPages) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => 'nearest_page_' . ($page + 1)
            ]);
        }

        if (!empty($paginationRow)) {
            $keyboard->row($paginationRow);
        }

        if ($isEdit && $messageId) {
            Telegram::editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $messageText,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $messageText,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
    }

    protected static function transliterate(string $text): string
    {
        $cyrillic = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'қ', 'ғ', 'ҳ', 'Қ', 'Ғ', 'Ҳ'
        ];
        
        $latin = [
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'x', 'ts', 'ch', 'sh', 'sh', 'ʼ', 'i', 'ʼ', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'X', 'Ts', 'Ch', 'Sh', 'Sh', 'ʼ', 'I', 'ʼ', 'E', 'Yu', 'Ya',
            'q', 'gʻ', 'h', 'Q', 'Gʻ', 'H'
        ];
        
        return str_replace($cyrillic, $latin, $text);
    }

    public static function sendSearchCenterDetails(int $chatId, int $centerId): void
    {
        try {
            $center = LearningCenter::with(['subjects.subject', 'user'])->find($centerId);

            if (!$center) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => '❌ Markaz topilmadi.'
                ]);
                return;
            }

            $subjects = $center->subjects
                ->map(function ($item) {
                    $price = $item->price ? number_format($item->price, 0, ',', ' ') . ' soʻm' : 'Narxi belgilanmagan';
                    return "• {$item->subject->name} - {$price}";
                })
                ->take(3) // Faqat 3 ta fanni ko'rsatamiz
                ->implode("\n") ?: "Fanlar mavjud emas";

            $appUrl = env('APP_URL', 'https://your-domain.com');
            $centerUrl = "{$appUrl}/blog-single/{$center->id}";
            
            $messageText = "🏫 *{$center->name}*

📍 *Manzil:* {$center->province}, {$center->region}
🏘️ *To'liq manzil:* {$center->address}
👥 *O'quvchilar:* {$center->student_count} nafar
⭐ *Reyting:* {$center->rating}/5
📚 *Fanlar (3 ta):*
{$subjects}

ℹ️ *Haqida:* " . mb_substr($center->about ?? '', 0, 100) . "...

🔗 *Batafsil ma'lumot:* [Ko'rish]({$centerUrl})";

        // Joylashuvni matnga qo'shamiz
        if ($center->location) {
            [$latitude, $longitude] = explode(',', trim($center->location));
            $locationText = "\n🗺️ *Joylashuv:* {$latitude}, {$longitude}";
            $messageText .= $locationText;
        }

            if ($center->logo) {
                try {
                    $logoUrl = null;
                    
                    // 1. Agar to'g'ridan-to'g'ri URL bo'lsa
                    if (filter_var($center->logo, FILTER_VALIDATE_URL)) {
                        $logoUrl = $center->logo;
                    } 
                    // 2. Agar storage path bo'lsa
                    else {
                        $logoPath = public_path('storage/' . $center->logo);
                        if (file_exists($logoPath)) {
                            $logoUrl = \Telegram\Bot\FileUpload\InputFile::create($logoPath);
                        }
                    }
                    
                    if ($logoUrl) {
                        Telegram::sendPhoto([
                            'chat_id' => $chatId,
                            'photo' => $logoUrl,
                            'caption' => $messageText,
                            'parse_mode' => 'Markdown'
                        ]);
                    } else {
                        // Logo topilmasa, faqat matn yuboramiz
                        Telegram::sendMessage([
                            'chat_id' => $chatId,
                            'text' => $messageText,
                            'parse_mode' => 'Markdown',
                            'disable_web_page_preview' => false
                        ]);
                    }
                } catch (\Exception $logoError) {
                    // Logo yuborishda xatolik bo'lsa, faqat matn yuboramiz
                    \Log::error('Logo sending error in search: ' . $logoError->getMessage(), [
                        'center_id' => $centerId,
                        'logo_path' => $center->logo
                    ]);
                    
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => $messageText,
                        'parse_mode' => 'Markdown',
                        'disable_web_page_preview' => false
                    ]);
                }
            } else {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $messageText,
                    'parse_mode' => 'Markdown',
                    'disable_web_page_preview' => false
                ]);
            }

            // Send location if available
            if ($center->location) {
                try {
                    [$latitude, $longitude] = explode(',', trim($center->location));
                    
                    Telegram::sendLocation([
                        'chat_id' => $chatId,
                        'latitude' => trim($latitude),
                        'longitude' => trim($longitude),
                        'title' => $center->name,
                        'address' => $center->address
                    ]);
                } catch (\Exception $locationError) {
                    \Log::error('Location sending error in search: ' . $locationError->getMessage(), [
                        'center_id' => $centerId,
                        'location' => $center->location
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Bot sendSearchCenterDetails error: ' . $e->getMessage(), [
                'centerId' => $centerId,
                'trace' => $e->getTraceAsString()
            ]);
            
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Xatolik yuz berdi. Iltimos, keyinroq urinib koʻring.'
            ]);
        }
    }

    protected static function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Km

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
