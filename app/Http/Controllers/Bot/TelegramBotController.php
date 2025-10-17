<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        // Agar callback query bo'lsa
        if ($update->isType('callback_query')) {
            $callbackData = $update->callbackQuery->data;

            switch ($callbackData) {
                case 'courses':
                    $this->showCourses($update);
                    break;
            }
        } else {
            Telegram::commandsHandler(true);
        }

        return response('OK', 200);
    }
    protected function showCourses($update)
    {

        $chatId = $update->callbackQuery->message->chat->id;

        $centers = LearningCenter::paginate(10);

        $buttons = [];

        // Har bir kurs uchun tugma
        foreach ($centers as $center) {
            $buttons[] = Keyboard::inlineButton([
                'text' => $center->name,
                'callback_data' => 'center_' . $center->id
            ]);
        }

        // Har 3 tadan qilib bo‘lamiz
        $rows = collect($buttons)->chunk(2);

        $keyboard = Keyboard::make()->inline();

        // ❗ Har bir qatorni yoyib qo‘shamiz
        foreach ($rows as $row) {
            $keyboard->row([...$row]);
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Barcha kurslar:',
            'reply_markup' => $keyboard
        ]);
    }
}
