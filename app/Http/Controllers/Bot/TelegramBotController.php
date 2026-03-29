<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use App\Models\Subject;
use App\Services\Bot\BotConfigService;
use App\Services\Bot\BotMessageService;
use App\Services\Bot\BotSearchService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        try {
            if ($update->isType('callback_query')) {
                $this->handleCallbackQuery($update);
            } elseif ($update->isType('message')) {
                $this->handleMessage($update);
            }
        } catch (\Exception $e) {
            \Log::error('Telegram bot error: ' . $e->getMessage(), [
                'update' => $update->toArray(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return response('OK', 200);
    }

    protected function handleCallbackQuery($update)
    {
        $callbackData = $update->callbackQuery->data;
        $chatId = $update->callbackQuery->message->chat->id;
        $messageId = $update->callbackQuery->message->message_id;

        // Handle pagination callbacks
        if (strpos($callbackData, 'subjects_page_') === 0) {
            $page = (int) str_replace('subjects_page_', '', $callbackData);
            BotMessageService::sendSubjectsMenu($chatId, $page, true, $messageId);
            return;
        }

        if (strpos($callbackData, 'markazlar_page_') === 0) {
            $data = explode('_', str_replace('markazlar_page_', '', $callbackData));
            $province = $data[0];
            $page = $data[1] ?? 1;
            BotMessageService::sendCentersByProvince($chatId, $province, $page, true, $messageId);
            return;
        }

        if (strpos($callbackData, 'subject_markazlar_page_') === 0) {
            $data = explode('_', str_replace('subject_markazlar_page_', '', $callbackData));
            $subjectId = $data[0];
            $page = $data[1] ?? 1;
            BotMessageService::sendCentersBySubject($chatId, $subjectId, $page, true, $messageId);
            return;
        }

        if (strpos($callbackData, 'nearest_page_') === 0) {
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

            BotSearchService::displayNearestPage($chatId, $centers, $page, true, $messageId);
            return;
        }

        // Handle main action callbacks
        if (strpos($callbackData, 'province_') === 0) {
            $province = str_replace('province_', '', $callbackData);
            BotMessageService::sendCentersByProvince($chatId, $province, 1);
        } elseif (strpos($callbackData, 'subject_') === 0) {
            $subjectId = (int) str_replace('subject_', '', $callbackData);
            BotMessageService::sendCentersBySubject($chatId, $subjectId, 1);
        } elseif (strpos($callbackData, 'center_') === 0) {
            $centerId = (int) str_replace('center_', '', $callbackData);
            BotMessageService::sendCenterDetails($chatId, $centerId);
        } elseif (strpos($callbackData, 'search_center_') === 0) {
            $centerId = (int) str_replace('search_center_', '', $callbackData);
            BotSearchService::sendSearchCenterDetails($chatId, $centerId);
        }
    }

    protected function handleMessage($update)
    {
        $chatId = $update->message->chat->id;
        $userId = $update->message->from->id;
        $text = trim($update->message->text ?? '');

        // Handle /start command
        if ($text === '/start') {
            BotMessageService::sendMainMenu($chatId);
            return;
        }

        // Handle main menu buttons
        $mainMenu = BotConfigService::getMainMenu();
        foreach ($mainMenu as $menuItem) {
            if ($text === $menuItem['text']) {
                switch ($menuItem['callback']) {
                    case 'show_provinces':
                        BotMessageService::sendProvincesMenu($chatId);
                        break;
                    case 'search_mode':
                        Cache::put("search_state_{$userId}", ['state' => 'waiting_for_search'], now()->addMinutes(BotConfigService::getSearchCacheDuration() / 60));
                        BotMessageService::requestSearchQuery($chatId);
                        break;
                    case 'show_subjects':
                        BotMessageService::sendSubjectsMenu($chatId, 1);
                        break;
                    case 'location_request':
                        BotMessageService::requestLocation($chatId);
                        break;
                }
                return;
            }
        }

        // Handle location
        if ($update->message->location) {
            $latitude = $update->message->location->latitude;
            $longitude = $update->message->location->longitude;
            BotSearchService::findNearestCenters($chatId, $userId, $latitude, $longitude, 1);
            return;
        }

        // Handle search query
        if (Cache::has("search_state_{$userId}") && Cache::get("search_state_{$userId}")['state'] === 'waiting_for_search') {
            Cache::forget("search_state_{$userId}");
            BotSearchService::searchCenters($chatId, $text);
            return;
        }

        // If no command matches, show help
        $this->showHelp($chatId);
    }

    protected function showHelp(int $chatId): void
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => '❓ *Yordam*

Botdan foydalanish uchun quyidagi buyruqlardan foydalaning:

/start - Bosh menyuga qaytish

Yoki pastdagi tugmalardan birini tanlang:
🏫 Markazlar - Viloyat boʻyicha markazlar
🔍 Qidirish - Markaz nomi boʻyicha qidirish
📚 Fanlar - Fan boʻyicha markazlar
📍 Eng yaqinlari - Joylashuvingizga yaqin markazlar',
            'parse_mode' => 'Markdown'
        ]);
    }
}
