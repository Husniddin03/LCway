<?php

return [
    // Page Title
    'title' => 'Добавить учебный центр',

    // Header Section
    'header' => [
        'title' => 'Добавить новый учебный центр',
        'description' => 'Введите полную информацию о вашем учебном центре',
    ],

    // Error Messages
    'error' => [
        'title' => 'Пожалуйста, исправьте ошибки:',
        'file_size' => 'Размер файла не должен превышать 1МБ!',
        'location_not_supported' => 'Ваш браузер не поддерживает определение местоположения!',
        'location_detecting' => 'Определение местоположения...',
        'location_found' => 'Текущее местоположение найдено!',
        'location_failed' => 'Не удалось получить местоположение!',
    ],

    // Form Sections
    'basic_info' => [
        'title' => 'Основная информация',
        'logo_label' => 'Основное изображение центра (логотип)',
        'logo_hint' => 'Нажмите или перетащите для загрузки логотипа',
        'logo_format' => 'PNG, JPG, WebP — макс 1МБ',
        'name_label' => 'Название',
        'name_placeholder' => 'Введите название учебного центра',
        'type_label' => 'Тип',
        'type_placeholder' => 'Выберите тип центра...',
        'about_label' => 'О центре',
        'about_placeholder' => 'Краткая информация об учебном центре...',
    ],

    'images' => [
        'title' => 'Изображения центра',
        'hint' => 'Нажмите для загрузки изображений центра (допускается множественный выбор)',
    ],

    'location' => [
        'title' => 'Информация о местоположении',
        'current_location' => 'Текущее местоположение',
        'hint' => 'Нажмите на карту или перетащите маркер для выбора местоположения — область, район и адрес заполнятся автоматически.',
        'province_label' => 'Область',
        'province_placeholder' => 'Выберите область...',
        'district_label' => 'Район',
        'district_placeholder' => 'Выберите район...',
        'address_label' => 'Адрес',
        'address_placeholder' => 'Полный адрес (автоматически заполняется с карты)',
    ],

    'students' => [
        'title' => 'Количество студентов',
        'label' => 'Текущее количество студентов в вашем центре',
        'placeholder' => '0',
    ],

    // Form Types
    'types' => [
        'center' => 'Учебный центр',
        'academy' => 'Академия',
        'college' => 'Колледж',
        'university' => 'Университет',
    ],

    // Buttons
    'buttons' => [
        'back' => 'Назад',
        'save' => 'Сохранить',
        'saving' => 'Сохранение...',
    ],

    // Required Field
    'required' => '*',

    // Provinces
    'provinces' => [
        'tashkent' => 'Ташкент',
        'sirdaryo' => 'Сырдарья',
        'jizzax' => 'Джизак',
        'samarkand' => 'Самарканд',
        'bukhara' => 'Бухара',
        'navoiy' => 'Навои',
        'kashkadarya' => 'Кашкадарья',
        'surkhandarya' => 'Сурхандарья',
        'khorezm' => 'Хорезм',
        'andijan' => 'Андижан',
        'namangan' => 'Наманган',
        'fergana' => 'Фергана',
        'karakalpakstan' => 'Каракалпакстан',
    ],

    // Map
    'map' => [
        'marker_title' => 'Местоположение учебного центра',
    ],
];
