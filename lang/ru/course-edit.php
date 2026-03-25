<?php

return [
    // Page Title
    'title' => 'Редактировать учебный центр',

    // Header Section
    'header' => [
        'title' => 'Редактировать центр :name',
        'description' => 'Обновите информацию об учебном центре',
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
        'existing_logo' => 'Существующий логотип',
        'new_logo' => 'Новый логотип',
        'new_logo_hint' => 'Нажмите или перетащите для загрузки нового логотипа',
        'new_logo_note' => '(PNG, JPG, WebP — макс 1МБ. Оставьте пустым чтобы сохранить существующий логотип)',
        'name_label' => 'Название',
        'name_placeholder' => 'Введите название учебного центра',
        'type_label' => 'Тип',
        'type_placeholder' => 'Выберите тип центра...',
        'about_label' => 'О центре',
        'about_placeholder' => 'Краткая информация об учебном центре...',
    ],

    'location' => [
        'title' => 'Информация о местоположении',
        'current_location' => 'Текущее местоположение',
        'hint' => 'Нажмите на карту или перетащите маркер для изменения местоположения — область, район и адрес обновятся автоматически.',
        'province_label' => 'Область',
        'province_placeholder' => 'Выберите область...',
        'district_label' => 'Район',
        'district_placeholder' => 'Выберите район...',
        'address_label' => 'Адрес',
        'address_placeholder' => 'Введите полный адрес',
        'coordinates_label' => 'Координаты местоположения (lat,lng)',
        'coordinates_placeholder' => 'Автоматически заполняется при выборе с карты',
    ],

    'additional_info' => [
        'title' => 'Дополнительная информация',
        'students_label' => 'Текущее количество студентов в вашем центре',
        'students_placeholder' => '0',
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
