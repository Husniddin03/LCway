<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    protected $uzbekistanProvinces = [
        'Toshkent' => 'Tashkent',
        'Andijan' => 'Andijan',
        'Buxoro' => 'Bukhara',
        'Jizzax' => 'Jizzakh',
        'Qashqadarya' => 'Kashkadarya',
        'Navoi' => 'Navoi',
        'Namangan' => 'Namangan',
        'Samarqand' => 'Samarkand',
        'Sirdarya' => 'Sirdarya',
        'Surxondarya' => 'Surkhandarya',
        'Xorazm' => 'Khorezm',
        'Qoraqolpog\'iston' => 'Karakalpakstan'
    ];

    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        if ($update->isType('callback_query')) {
            $this->handleCallbackQuery($update);
        } elseif ($update->isType('message') && $update->message->text == '/start') {
            $this->showStartMenu($update);
        } elseif ($update->isType('message')) {
            $this->handleMessage($update);
        }

        return response('OK', 200);
    }

    protected function showStartMenu($update)
    {
        $chatId = $update->message->chat->id;

        $keyboard = [
            'keyboard' => [
                [['text' => '🏫 Markazlar'], ['text' => '🔍 Qidirish']],
                [['text' => '📚 Fanlar'], ['text' => '📍 Eng yaqinlari']]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Xush kelibsiz! Nima qilmoqchisiz?',
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    protected function handleCallbackQuery($update)
    {
        $callbackData = $update->callbackQuery->data;

        if (strpos($callbackData, 'province_') === 0) {
            $province = str_replace('province_', '', $callbackData);
            $this->showProvinceMarkazlar($update, $province, 1);
        } elseif (strpos($callbackData, 'markazlar_page_') === 0) {
            $data = explode('_', str_replace('markazlar_page_', '', $callbackData));
            $province = $data[0];
            $page = $data[1] ?? 1;
            $this->showProvinceMarkazlar($update, $province, $page, true);
        } elseif (strpos($callbackData, 'nearest_page_') === 0) {
            $page = (int) str_replace('nearest_page_', '', $callbackData);
            $userId = $update->callbackQuery->from->id;
            $centers = Cache::get("nearest_centers_{$userId}");

            if (!$centers) {
                Telegram::answerCallbackQuery([
                    'callback_query_id' => $update->callbackQuery->id,
                    'text' => 'Sessiya tugadi. Iltimos, joylashuvni qayta yuboring',
                    'show_alert' => false
                ]);
                return;
            }

            $this->displayNearestPage($update, $centers, $page);
        } elseif (strpos($callbackData, 'subject_') === 0) {
            $subjectId = (int) str_replace('subject_', '', $callbackData);
            $this->showSubjectMarkazlar($update, $subjectId, 1);
        } elseif (strpos($callbackData, 'subject_markazlar_page_') === 0) {
            $data = explode('_', str_replace('subject_markazlar_page_', '', $callbackData));
            $subjectId = $data[0];
            $page = $data[1] ?? 1;
            $this->showSubjectMarkazlar($update, $subjectId, $page, true);
        } elseif (strpos($callbackData, 'subjects_page_') === 0) {
            $page = (int) str_replace('subjects_page_', '', $callbackData);
            $this->showSubjects($update, $page, true);
        } elseif (strpos($callbackData, 'center_') === 0) {
            $centerId = (int) str_replace('center_', '', $callbackData);
            $this->showCenterDetails($update, $centerId);
        }
    }

    protected function handleMessage($update)
    {
        $chatId = $update->message->chat->id;
        $userId = $update->message->from->id;
        $text = trim($update->message->text ?? '');

        // Markazlar tugmasi
        if ($text === '🏫 Markazlar') {
            $this->showProvincesMenu($update);
        }
        // Qidirish tugmasi
        elseif ($text === '🔍 Qidirish') {
            Cache::put("search_state_{$userId}", ['state' => 'waiting_for_search'], now()->addMinutes(5));
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Markaz nomini yozing',
            ]);
        }
        // Fanlar tugmasi
        elseif ($text === '📚 Fanlar') {
            $this->showSubjects($update, 1);
        }
        // Eng yaqinlari tugmasi
        elseif ($text === '📍 Eng yaqinlari') {
            $keyboard = [
                'keyboard' => [
                    [['text' => '📍 Mening joylashuvim', 'request_location' => true]]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ];

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Iltimos, joylashuvingizni yuboring',
                'reply_markup' => json_encode($keyboard)
            ]);
        }
        // Joylashuv (location)
        elseif ($update->message->location) {
            $latitude = $update->message->location->latitude;
            $longitude = $update->message->location->longitude;
            $this->showNearestCenters($update, $latitude, $longitude, 1);
        }
        // Qidiruv
        elseif (Cache::has("search_state_{$userId}") && Cache::get("search_state_{$userId}")['state'] === 'waiting_for_search') {
            Cache::forget("search_state_{$userId}");
            $this->searchCenters($update, $text);
        }
    }

    protected function showProvincesMenu($update)
    {
        $chatId = $update->message->chat->id;

        $keyboard = Keyboard::make()->inline();
        $buttons = [];

        foreach ($this->uzbekistanProvinces as $uz => $en) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $uz,
                'callback_data' => 'province_' . $uz
            ]);
        }

        $rows = collect($buttons)->chunk(2);
        foreach ($rows as $row) {
            $keyboard->row([...$row]);
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Viloyatni tanlang:",
            'reply_markup' => $keyboard
        ]);
    }

    protected function showSubjects($update, $page = 1, $isEdit = false)
    {
        $chatId = $isEdit ? $update->callbackQuery->message->chat->id : $update->message->chat->id;
        $messageId = $isEdit ? $update->callbackQuery->message->message_id : null;

        $perPage = 5;
        $subjects = Subject::paginate($perPage, ['*'], 'page', $page);

        if ($subjects->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Fanlar topilmadi',
            ]);
            return;
        }

        $buttons = [];
        foreach ($subjects as $subject) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $subject->name,
                'callback_data' => 'subject_' . $subject->id
            ]);
        }

        $rows = collect($buttons)->chunk(1);
        $keyboard = Keyboard::make()->inline();

        foreach ($rows as $row) {
            $keyboard->row([...$row]);
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

        $keyboard->row($paginationRow);

        if ($isEdit) {
            Telegram::editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Fanlarni tanlang:',
                'reply_markup' => $keyboard
            ]);
        }
    }

    protected function showSubjectMarkazlar($update, $subjectId, $page = 1, $isEdit = false)
    {
        $chatId = $update->callbackQuery->message->chat->id;
        $messageId = $update->callbackQuery->message->message_id;

        $subject = Subject::find($subjectId);

        if (!$subject) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Fan topilmadi',
            ]);
            return;
        }

        $perPage = 5;
        // Subject bilan bog'langan markazlarni olish
        $centers = LearningCenter::whereHas('subjects', function ($query) use ($subjectId) {
            $query->where('subject_id', $subjectId);
        })->paginate($perPage, ['*'], 'page', $page);

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "'{$subject->name}' fanidan markaz topilmadi",
            ]);
            return;
        }

        $buttons = [];
        foreach ($centers as $center) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $center->name,
                'callback_data' => 'center_' . $center->id
            ]);
        }

        $rows = collect($buttons)->chunk(1);
        $keyboard = Keyboard::make()->inline();

        foreach ($rows as $row) {
            $keyboard->row([...$row]);
        }

        // Pagination
        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => 'subject_markazlar_page_' . $subjectId . '_' . ($page - 1)
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$centers->lastPage()}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $centers->lastPage()) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => 'subject_markazlar_page_' . $subjectId . '_' . ($page + 1)
            ]);
        }

        $keyboard->row($paginationRow);

        if ($isEdit) {
            Telegram::editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "'{$subject->name}' fanidan markazlar:",
                'reply_markup' => $keyboard
            ]);
        }
    }

    protected function showProvinceMarkazlar($update, $province, $page = 1, $isEdit = false)
    {
        $chatId = $update->callbackQuery->message->chat->id;
        $messageId = $update->callbackQuery->message->message_id;

        $perPage = 5;
        $centers = LearningCenter::where('province', $province)
            ->paginate($perPage, ['*'], 'page', $page);

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Bu viloyatda markaz topilmadi',
            ]);
            return;
        }

        $buttons = [];
        foreach ($centers as $center) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $center->name,
                'callback_data' => 'center_' . $center->id
            ]);
        }

        $rows = collect($buttons)->chunk(1);
        $keyboard = Keyboard::make()->inline();

        foreach ($rows as $row) {
            $keyboard->row([...$row]);
        }

        // Pagination
        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️',
                'callback_data' => 'markazlar_page_' . $province . '_' . ($page - 1)
            ]);
        }

        $paginationRow[] = Keyboard::inlineButton([
            'text' => "{$page}/{$centers->lastPage()}",
            'callback_data' => 'page_info'
        ]);

        if ($page < $centers->lastPage()) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '➡️',
                'callback_data' => 'markazlar_page_' . $province . '_' . ($page + 1)
            ]);
        }

        $keyboard->row($paginationRow);

        if ($isEdit) {
            Telegram::editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => $keyboard
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "{$province} viloyatining markazlari:",
                'reply_markup' => $keyboard
            ]);
        }
    }

    protected function showNearestCenters($update, $latitude, $longitude, $page = 1)
    {
        $chatId = $update->message->chat->id;
        $userId = $update->message->from->id;

        // Barcha markazlarni olish va masofani hisoblash
        $centers = LearningCenter::all()
            ->map(function ($center) use ($latitude, $longitude) {
                if (!$center->location) {
                    return null;
                }

                [$centerLat, $centerLon] = explode(',', trim($center->location));
                $distance = $this->calculateDistance($latitude, $longitude, (float)$centerLat, (float)$centerLon);
                $center->distance = $distance;
                return $center;
            })
            ->filter()
            ->sortBy('distance')
            ->values();

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Yaqin markazlar topilmadi',
            ]);
            return;
        }

        // Pagination
        $perPage = 5;
        $totalPages = ceil($centers->count() / $perPage);
        $paginatedCenters = $centers->slice(($page - 1) * $perPage, $perPage);

        $messageText = "📍 <b>Eng yaqin markazlar:</b>\n\n";

        foreach ($paginatedCenters as $index => $center) {
            $distanceKm = round($center->distance, 2);
            $number = ($page - 1) * $perPage + $index + 1;
            $messageText .= "{$number}. <b>{$center->name}</b> - {$distanceKm} km\n";
        }

        $keyboard = Keyboard::make()->inline();

        // Pagination tugmalari
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

        // Cache-ga markazlarni saqlash (pagination uchun)
        Cache::put("nearest_centers_{$userId}", $centers, now()->addHours(1));

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $messageText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard
        ]);
    }

    protected function displayNearestPage($update, $centers, $page)
    {
        $chatId = $update->callbackQuery->message->chat->id;
        $messageId = $update->callbackQuery->message->message_id;

        $perPage = 5;
        $totalPages = ceil($centers->count() / $perPage);
        $paginatedCenters = $centers->slice(($page - 1) * $perPage, $perPage);

        $messageText = "📍 <b>Eng yaqin markazlar:</b>\n\n";

        foreach ($paginatedCenters as $index => $center) {
            $distanceKm = round($center->distance, 2);
            $number = ($page - 1) * $perPage + $index + 1;
            $messageText .= "{$number}. <b>{$center->name}</b> - {$distanceKm} km\n";
        }

        $keyboard = Keyboard::make()->inline();

        // Pagination tugmalari
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

        Telegram::editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $messageText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard
        ]);
    }

    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
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

    protected function searchCenters($update, $text)
    {
        $chatId = $update->message->chat->id;

        $centers = LearningCenter::where('name', 'like', "%{$text}%")->take(5)->get();

        if ($centers->isEmpty()) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Markaz topilmadi',
            ]);
            return;
        }

        foreach ($centers as $center) {
            $this->sendCenterMessage($chatId, $center);
        }
    }

    protected function showCenterDetails($update, $centerId)
    {
        $chatId = $update->callbackQuery->message->chat->id;
        $center = LearningCenter::find($centerId);

        if (!$center) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Markaz topilmadi',
            ]);
            return;
        }

        $this->sendCenterMessage($chatId, $center);
    }

    protected function sendCenterMessage($chatId, $center)
    {
        // Markazning fanlarini olish - hasMany orqali
        $subjects = $center->subjects()
            ->with('subject')
            ->get()
            ->map(function ($item) {
                return $item->subject->name;
            })
            ->implode(', ') ?: "Fan yo'q";

        $messageText =
            "🏫 <b>Nomi:</b> {$center->name}\n" .
            "📍 <b>Viloyat:</b> {$center->province}\n" .
            "🏘️ <b>Rayon:</b> {$center->region}\n" .
            "📮 <b>Manzil:</b> {$center->address}\n" .
            "👥 <b>O'quvchilar soni:</b> {$center->student_count}\n" .
            "📚 <b>Fanlar:</b> {$subjects}\n" .
            "ℹ️ <b>Haqida:</b> {$center->about}";

        if ($center->logo) {
            $logoPath = public_path('storage/' . $center->logo);

            if (file_exists($logoPath)) {
                Telegram::sendPhoto([
                    'chat_id' => $chatId,
                    'photo' => \Telegram\Bot\FileUpload\InputFile::create($logoPath),
                    'caption' => $messageText,
                    'parse_mode' => 'HTML'
                ]);
            } else {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $messageText,
                    'parse_mode' => 'HTML'
                ]);
            }
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $messageText,
                'parse_mode' => 'HTML'
            ]);
        }

        // Joylashuv
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
    }
}
