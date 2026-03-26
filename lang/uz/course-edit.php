<?php

return [
    // Page Title
    'title' => "O'quv markazni tahrirlash",

    // Header Section
    'header' => [
        'title' => ":name markazini tahrirlash",
        'description' => "O'quv markaz ma'lumotlarini yangilang",
    ],

    // Error Messages
    'error' => [
        'title' => 'Iltimos, xatolarni to\'g\'rilang:',
        'file_size' => 'Fayl hajmi 1MB dan oshmasligi kerak!',
        'location_not_supported' => 'Brauzeringiz joylashuvni qo\'llab-quvvatlamaydi!',
        'location_detecting' => 'Joylashuv aniqlanmoqda...',
        'location_found' => 'Joriy joylashuv topildi!',
        'location_failed' => 'Joylashuvni olish imkonsiz!',
    ],

    // Form Sections
    'basic_info' => [
        'title' => 'Asosiy ma\'lumotlar',
        'existing_logo' => 'Mavjud Logo',
        'new_logo' => 'Yangi Logo',
        'new_logo_hint' => 'Yangi logo yuklash uchun bosing yoki tortib oling',
        'new_logo_note' => '(PNG, JPG, WebP — maks 1MB. Bo\'sh qoldirsangiz eski logo saqlanadi)',
        'name_label' => 'Nomi',
        'name_placeholder' => 'O\'quv markaz nomini kiriting',
        'type_label' => 'Turi',
        'type_placeholder' => 'Markaz turini tanlang...',
        'about_label' => 'Haqida',
        'about_placeholder' => 'O\'quv markaz haqida qisqacha ma\'lumot...',
    ],

    'location' => [
        'title' => 'Manzil ma\'lumotlari',
        'current_location' => 'Joriy joylashuv',
        'hint' => 'Xaritaga bosing yoki markerni sudrab manzilni o\'zgartiring — viloyat, tuman va manzil avtomatik yangilanadi.',
        'province_label' => 'Viloyat',
        'province_placeholder' => 'Viloyatni tanlang...',
        'district_label' => 'Tuman',
        'district_placeholder' => 'Tumanni tanlang...',
        'address_label' => 'Manzil',
        'address_placeholder' => 'To\'liq manzilni kiriting',
        'coordinates_label' => 'Joylashuv koordinatalari (lat,lng)',
        'coordinates_placeholder' => 'Xaritadan tanlasangiz avtomatik to\'ldiriladi',
    ],

    'additional_info' => [
        'title' => 'Qo\'shimcha ma\'lumotlar',
        'students_label' => 'Hozirda markazingizdagi o\'quvchilar soni',
        'students_placeholder' => '0',
    ],

    // Form Types
    'types' => [
        'center' => 'O\'quv markaz',
        'academy' => 'Akademiya',
        'college' => 'Kollej',
        'university' => 'Universitet',
        'school' => 'Maktab',
        'school_course' => 'Maktab/Kurs',
        'language_course' => 'Til kurslar',
        'driving_course' => 'Haydovchilik kursi',
        'it_course' => 'IT kurslar',
        'design_course' => 'Dizayn kurslar',
        'music_school' => 'Musiqiy maktab',
        'sports_school' => 'Sport maktab',
        'art_school' => 'Badiiy maktab',
        'vocational_school' => 'Kasb-hunar maktab',
    ],

    // Buttons
    'buttons' => [
        'back' => 'Orqaga',
        'save' => 'Saqlash',
        'saving' => 'Saqlanmoqda...',
    ],

    // Required Field
    'required' => '*',

    // Provinces
    'provinces' => [
        'tashkent' => 'Toshkent',
        'sirdaryo' => 'Sirdaryo',
        'jizzax' => 'Jizzax',
        'samarkand' => 'Samarqand',
        'bukhara' => 'Buxoro',
        'navoiy' => 'Navoiy',
        'kashkadarya' => 'Qashqadaryo',
        'surkhandarya' => 'Surxandaryo',
        'khorezm' => 'Xorazm',
        'andijan' => 'Andijon',
        'namangan' => 'Namangan',
        'fergana' => 'Farg\'ona',
        'karakalpakstan' => 'Qoraqalpog\'iston',
    ],

    // Map
    'map' => [
        'marker_title' => 'O\'quv markaz manzili',
    ],
];
