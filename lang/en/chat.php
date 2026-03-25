<?php

return [
    // Page Title
    'title' => 'AI Advisor',

    // Sidebar
    'sidebar' => [
        'title' => 'AI Advisor',
        'new_chat' => 'New Chat',
        'history' => 'Chat History',
        'no_sessions' => 'No chats yet',
    ],

    // Topbar
    'topbar' => [
        'title_default' => 'AI Advisor',
        'subtitle' => 'Start new conversation',
        'subtitle_with_count' => 'messages',
        'full_banner' => 'This chat is full ({{ count }} messages).',
        'new_chat_btn' => 'Open new chat →',
    ],

    // Empty State
    'empty' => [
        'greeting' => 'Hello! I\'m AI Advisor',
        'description' => 'Ask about educational centers, courses, and training',
        'suggestions' => [
            'math_courses' => 'Math courses in Tashkent',
            'english_learning' => 'I want to learn English',
            'programming_courses' => 'Programming courses where?',
            'best_region' => 'Which educational center is best?',
        ],
    ],

    // Search
    'search' => [
        'indicator' => 'Searching for centers...',
        'no_results' => 'No chats found',
        'placeholder' => 'Type your question... (e.g.: English courses in Tashkent)',
    ],

    // Messages
    'messages' => [
        'typing' => 'AI is typing...',
        'error' => '❌ An error occurred. Please try again.',
        'user_prefix' => 'You',
        'ai_prefix' => 'AI',
    ],

    // Input
    'input' => [
        'placeholder' => 'Type your question... (e.g.: English courses in Tashkent)',
        'send_btn' => 'Send',
        'keyboard_shortcut' => 'send · Shift+Enter for new line',
        'char_count' => 'characters',
    ],

    // Theme
    'theme' => [
        'toggle' => 'Dark/Light Mode',
        'toggle_title' => 'Dark/Light Mode',
    ],

    // Full Banner
    'full_banner' => [
        'message' => 'This chat is full ({{ max }} messages).',
        'new_chat' => 'Open new chat →',
    ],
];
