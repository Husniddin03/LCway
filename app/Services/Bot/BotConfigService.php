<?php

namespace App\Services\Bot;

use App\Models\LearningCenter;
use Illuminate\Support\Facades\Cache;

class BotConfigService
{
    protected static array $uzbekistanProvinces = [
        'Toshkent' => 'Tashkent',
        'Andijon' => 'Andijan',
        'Buxoro' => 'Bukhara',
        'Jizzax' => 'Jizzakh',
        'Qashqadaryo' => 'Kashkadarya',
        'Navoiy' => 'Navoi',
        'Namangan' => 'Namangan',
        'Samarqand' => 'Samarkand',
        'Sirdaryo' => 'Sirdarya',
        'Surxondaryo' => 'Surkhandarya',
        'Xorazm' => 'Khorezm',
        'Qoraqalpogʻiston' => 'Karakalpakstan'
    ];

    protected static array $mainMenu = [
        ['text' => '🏫 Markazlar', 'callback' => 'show_provinces'],
        ['text' => '🔍 Qidirish', 'callback' => 'search_mode'],
        ['text' => '📚 Fanlar', 'callback' => 'show_subjects'],
        ['text' => '📍 Eng yaqinlari', 'callback' => 'location_request']
    ];

    public static function getProvinces(): array
    {
        return Cache::remember('bot_provinces', 3600, function () {
            return LearningCenter::distinct()
                ->pluck('province')
                ->filter()
                ->sort()
                ->values()
                ->toArray();
        });
    }

    public static function getMainMenu(): array
    {
        return self::$mainMenu;
    }

    public static function getProvinceName(string $province): string
    {
        return self::$uzbekistanProvinces[$province] ?? $province;
    }

    public static function getPerPage(): int
    {
        return 5;
    }

    public static function getCacheDuration(): int
    {
        return 3600; // 1 hour
    }

    public static function getSearchCacheDuration(): int
    {
        return 300; // 5 minutes
    }
}
