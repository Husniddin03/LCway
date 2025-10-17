<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StartCommand extends Command
{
    protected string $name = 'start';

    protected array $aliases = ['boshlash'];

    protected string $description = 'Start Command to get you started';

    public function handle()
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => 'Kurslar',
                    'callback_data' => 'courses'
                ]),
                Keyboard::inlineButton([
                    'text' => 'Qidirish',
                    'callback_data' => 'search'
                ])
                ]);
        $this->replyWithMessage([
            'text' => 'Barcha markazlarni ko\'rish yoki qidirish',
            'reply_markup' => $keyboard
        ]);
    }
}
