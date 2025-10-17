<?php

use App\Http\Controllers\Bot\TelegramBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('telegram/webhook', [TelegramBotController::class, 'handle']);