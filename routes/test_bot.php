<?php
use Illuminate\Support\Facades\Route;

Route::get('/test-bot-keyboard', function () {
    try {
        $query = 'jizzax';
        $chatId = 123456789; // Doesn't matter, we want to see the array it tries to send
        
        $centers = \App\Models\LearningCenter::where('name', 'like', "%{$query}%")
                ->orWhere('about', 'like', "%{$query}%")
                ->take(10)
                ->get(['id', 'name']);

        $keyboard = \Telegram\Bot\Keyboard\Keyboard::make()->inline();
        foreach ($centers as $index => $center) {
            $number = $index + 1;
            $keyboard->row([
                \Telegram\Bot\Keyboard\Keyboard::inlineButton([
                    'text' => "{$number}. {$center->name}",
                    'callback_data' => 'search_center_' . $center->id
                ])
            ]);
        }
        
        $appUrl = env('APP_URL', 'https://your-domain.com');
        $keyboard->row([
            \Telegram\Bot\Keyboard\Keyboard::inlineButton([
                'text' => '🌐 Barchasi veb-saytda',
                'url' => "{$appUrl}/search?q=" . urlencode($query)
            ])
        ]);

        $keyboard->row([
            \Telegram\Bot\Keyboard\Keyboard::inlineButton([
                'text' => '📢 Bizning kanal',
                'url' => 'https://t.me/' . env('TELEGRAM_CHANNEL', 'lcway_channel')
            ])
        ]);

        return response()->json([
            'keyboard_array' => $keyboard->toArray()
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
    }
});
