<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $keyboard = \Telegram\Bot\Keyboard\Keyboard::make()->inline();
    $centers = \App\Models\LearningCenter::where('name', 'like', "%jizzax%")
        ->orWhere('about', 'like', "%jizzax%")->take(10)->get();

    foreach ($centers as $index => $center) {
        $number = $index + 1;
        $keyboard->row([
            \Telegram\Bot\Keyboard\Keyboard::inlineButton([
                'text' => "{$number}. {$center->name}",
                'callback_data' => 'search_center_' . $center->id
            ])
        ]);
    }
    
    $query = 'jizzax';
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

    // print output instead of sending
    echo "Keyboard:\n";
    print_r($keyboard->toArray());

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
