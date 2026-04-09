<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Search Service (Optional Enhancement)
    |--------------------------------------------------------------------------
    | Set AI_SEARCH_ENABLED=true in .env and provide a key + URL to activate.
    | The search system works perfectly WITHOUT this configuration.
    | Compatible with OpenAI API or any OpenAI-compatible endpoint (Gemini, etc.)
    */
    'ai_search' => [
        'enabled' => env('AI_SEARCH_ENABLED', false),
        'url'     => env('AI_SEARCH_URL', 'https://api.openai.com/v1/chat/completions'),
        'key'     => env('AI_SEARCH_KEY', ''),
        'model'   => env('AI_SEARCH_MODEL', 'gpt-4o-mini'),
        'timeout' => env('AI_SEARCH_TIMEOUT', 4),
    ],

];
