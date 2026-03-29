<?php

namespace App\Services\Bot;

use App\Models\LearningCenter;
use App\Models\Subject;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotMessageService
{
    public static function sendMainMenu(int $chatId): void
    {
        $mainMenu = BotConfigService::getMainMenu();
        $keyboard = [
            'keyboard' => array_chunk($mainMenu, 2),
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => '🎓 *Kurs Markazlari Botiga xush kelibsiz!*

Kerakli boʻlimni tanlang:',
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    public static function sendProvincesMenu(int $chatId): void
    {
        $provinces = BotConfigService::getProvinces();
        
        if (empty($provinces)) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Hozircha viloyatlar topilmadi. Iltimos, keyinroq urinib koʻring.'
            ]);
            return;
        }

        $keyboard = Keyboard::make()->inline();
        $buttons = [];

        foreach ($provinces as $province) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $province,
                'callback_data' => 'province_' . $province
            ]);
        }

        $rows = collect($buttons)->chunk(2);
        foreach ($rows as $row) {
            $keyboard->row([...$row]);
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => '📍 *Viloyatni tanlang:*',
            'parse_mode' => 'Markdown',
            'reply_markup' => $keyboard
        ]);
    }

    public static function sendSubjectsMenu(int $chatId, int $page = 1, bool $isEdit = false, $messageId = null): void
    {
        $perPage = 10; // 10 tadan ko'rsatamiz
        $subjects = Subject::orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($subjects->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Fanlar topilmadi.'
            ]);
            return;
        }

        $keyboard = self::createSubjectsKeyboard($subjects, $page);
        $text = "📚 *Fanlar ({$page}/{$subjects->lastPage()}):*";

        if ($isEdit && $messageId) {
            Telegram::editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
    }

    public static function sendCentersByProvince(int $chatId, string $province, int $page = 1, bool $isEdit = false, $messageId = null): void
    {
        $perPage = 10; // 10 tadan ko'rsatamiz
        $centers = LearningCenter::where('province', $province)
            ->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "❌ *{$province}* viloyatida markazlar topilmadi.",
                'parse_mode' => 'Markdown'
            ]);
            return;
        }

        $keyboard = self::createCentersKeyboard($centers, $page, 'province', $province);
        $text = "🏫 *{$province} viloyati markazlari ({$page}/{$centers->lastPage()}):*";

        if ($isEdit && $messageId) {
            Telegram::editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
    }

    public static function sendCentersBySubject(int $chatId, int $subjectId, int $page = 1, bool $isEdit = false, $messageId = null): void
    {
        $subject = Subject::find($subjectId);
        
        if (!$subject) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Fan topilmadi.'
            ]);
            return;
        }

        $perPage = 10; // 10 tadan ko'rsatamiz
        $centers = LearningCenter::whereHas('subjects', function ($query) use ($subjectId) {
            $query->where('subject_id', $subjectId);
        })->orderBy('name')->paginate($perPage, ['*'], 'page', $page);

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "❌ *{$subject->name}* fanidan markazlar topilmadi.",
                'parse_mode' => 'Markdown'
            ]);
            return;
        }

        $keyboard = self::createCentersKeyboard($centers, $page, 'subject', $subjectId);
        $text = "📚 *{$subject->name} fanidan markazlar ({$page}/{$centers->lastPage()}):*";

        if ($isEdit && $messageId) {
            Telegram::editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'reply_markup' => $keyboard
            ]);
        }
    }

    public static function sendCenterDetails(int $chatId, int $centerId): void
    {
        try {
            // Faqat kerakli ma'lumotlarni olamiz
            $center = LearningCenter::select([
                'id', 'name', 'province', 'region', 'address', 
                'student_count', 'rating', 'about', 'logo', 'location'
            ])->find($centerId);

            if (!$center) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => '❌ Markaz topilmadi.'
                ]);
                return;
            }

            // Fanlarni alohida so'rov bilan olamiz
            $subjects = \App\Models\SubjectsOfLearningCenter::with('subject')
                ->where('learning_centers_id', $centerId)
                ->take(3) // Faqat 3 ta fan
                ->get()
                ->map(function ($item) {
                    $price = $item->price ? number_format($item->price, 0, ',', ' ') . ' so\'m' : 'Narxi belgilanmagan';
                    return "• {$item->subject->name} - {$price}";
                })
                ->implode("\n") ?: "Fanlar mavjud emas";

            $messageText = "🏫 *{$center->name}*

📍 *Manzil:* {$center->province}, {$center->region}
🏘️ *To'liq manzil:* {$center->address}
👥 **O'quvchilar soni:** {$center->student_count}
⭐ **Reyting:** {$center->rating}/5

📚 *Fanlar:*
{$subjects}

ℹ️ *Haqida:*
" . mb_substr($center->about ?? '', 0, 100) . "...";

            // Joylashuvni matnga qo'shamiz
            if ($center->location) {
                [$latitude, $longitude] = explode(',', trim($center->location));
                $locationText = "\n🗺️ *Joylashuv:* {$latitude}, {$longitude}";
                $messageText .= $locationText;
            }

            // Logo yuborish
            if ($center->logo) {
                $logoUrl = null;
                
                if (filter_var($center->logo, FILTER_VALIDATE_URL)) {
                    $logoUrl = $center->logo;
                } else {
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
                [$latitude, $longitude] = explode(',', trim($center->location));
                
                Telegram::sendLocation([
                    'chat_id' => $chatId,
                    'latitude' => trim($latitude),
                    'longitude' => trim($longitude),
                    'title' => $center->name,
                    'address' => $center->address
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Bot sendCenterDetails error: ' . $e->getMessage(), [
                'centerId' => $centerId,
                'trace' => $e->getTraceAsString()
            ]);
            
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => '❌ Xatolik yuz berdi. Iltimos, keyinroq urinib koʻring.'
            ]);
        }
    }

    public static function requestLocation(int $chatId): void
    {
        $keyboard = [
            'keyboard' => [
                [['text' => '📍 Mening joylashuvim', 'request_location' => true]]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => '📍 *Eng yaqin markazlarni topish uchun joylashuvingizni yuboring:*',
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    public static function requestSearchQuery(int $chatId): void
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => '🔍 *Markaz nomini yozing:*',
            'parse_mode' => 'Markdown'
        ]);
    }

    protected static function createSubjectsKeyboard($subjects, int $page): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
        
        foreach ($subjects as $subject) {
            $keyboard->row([
                Keyboard::inlineButton([
                    'text' => $subject->name,
                    'callback_data' => 'subject_' . $subject->id
                ])
            ]);
        }

        // Pagination
        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => 'subjects_page_' . ($page - 1)
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$subjects->lastPage()}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $subjects->lastPage()) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => 'subjects_page_' . ($page + 1)
            ]);
        }

        if (!empty($paginationRow)) {
            $keyboard->row($paginationRow);
        }

        return $keyboard;
    }

    protected static function createCentersKeyboard($centers, int $page, string $type, $typeId): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
        
        foreach ($centers as $center) {
            $keyboard->row([
                Keyboard::inlineButton([
                    'text' => $center->name,
                    'callback_data' => 'center_' . $center->id
                ])
            ]);
        }

        // Pagination
        $paginationRow = [];
        if ($page > 1) {
            $callbackData = $type === 'province' 
                ? "markazlar_page_{$typeId}_" . ($page - 1)
                : "subject_markazlar_page_{$typeId}_" . ($page - 1);
                
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => $callbackData
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$centers->lastPage()}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $centers->lastPage()) {
            $callbackData = $type === 'province' 
                ? "markazlar_page_{$typeId}_" . ($page + 1)
                : "subject_markazlar_page_{$typeId}_" . ($page + 1);
                
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => $callbackData
            ]);
        }

        if (!empty($paginationRow)) {
            $keyboard->row($paginationRow);
        }

        return $keyboard;
    }
}
