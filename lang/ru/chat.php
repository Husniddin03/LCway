<?php

return [
    // Page Title
    'title' => 'AI Консультант',

    // Sidebar
    'sidebar' => [
        'title' => 'AI Консультант',
        'new_chat' => 'Новый чат',
        'history' => 'История чатов',
        'no_sessions' => 'Пока нет чатов',
    ],

    // Topbar
    'topbar' => [
        'title_default' => 'AI Консультант',
        'subtitle' => 'Начать новый разговор',
        'subtitle_with_count' => 'сообщений',
        'full_banner' => 'Этот чат полон ({{ count }} сообщений).',
        'new_chat_btn' => 'Открыть новый чат →',
    ],

    // Empty State
    'empty' => [
        'greeting' => 'Здравствуйте! Я AI консультант',
        'description' => 'Спрашивайте об учебных центрах, курсах и обучении',
        'suggestions' => [
            'math_courses' => 'Курсы математики в Ташкенте',
            'english_learning' => 'Я хочу учить английский',
            'programming_courses' => 'Где курсы программирования?',
            'best_region' => 'Какой учебный центр лучший?',
        ],
    ],

    // Search
    'search' => [
        'indicator' => 'Поиск центров...',
        'no_results' => 'Чаты не найдены',
        'placeholder' => 'Введите ваш вопрос... (напр.: курсы английского в Ташкенте)',
    ],

    // Messages
    'messages' => [
        'typing' => 'AI печатает...',
        'error' => '❌ Произошла ошибка. Попробуйте еще раз.',
        'user_prefix' => 'Вы',
        'ai_prefix' => 'AI',
    ],

    // Input
    'input' => [
        'placeholder' => 'Введите ваш вопрос... (напр.: курсы английского в Ташкенте)',
        'send_btn' => 'Отправить',
        'keyboard_shortcut' => 'отправить · Shift+Enter для новой строки',
        'char_count' => 'символов',
    ],

    // Theme
    'theme' => [
        'toggle' => 'Темный/Светлый режим',
        'toggle_title' => 'Темный/Светлый режим',
    ],

    // Full Banner
    'full_banner' => [
        'message' => 'Этот чат полон ({{ max }} сообщений).',
        'new_chat' => 'Открыть новый чат →',
    ],
];
