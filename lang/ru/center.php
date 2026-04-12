<?php

return [
    // Page title
    'title' => 'Подробная информация о :name',
    
    // Tab buttons
    'tabs' => [
        'quick_info' => 'Быстрая информация',
        'images' => 'Изображения',
        'subjects' => 'Предметы',
        'teachers' => 'Учителя',
        'about_center' => 'О центре',
        'location' => 'Местоположение',
        'announcements' => 'Объявления',
        'comments' => 'Комментарии',
    ],
    
    // Quick Info Section
    'quick_info' => [
        'title' => 'Быстрая информация',
        'type' => 'Тип',
        'country' => 'Страна',
        'province' => 'Область',
        'region' => 'Район/Город',
        'address' => 'Адрес',
        'added_date' => 'Дата добавления',
        'student_count' => 'Количество студентов',
        'edit_center' => 'Редактировать центр',
        'add_teacher' => 'Добавить учителя',
        'add_announcement' => 'Добавить объявление',
        'delete_confirm' => 'Вы уверены, что хотите удалить центр :name?',
        'delete_center' => 'Удалить',
    ],
    
    // Images Section
    'images' => [
        'title' => 'Изображения',
        'add_images' => 'Добавить изображения',
        'edit_images' => 'Редактировать изображения',
    ],
    
    // Schedule Section
    'schedule' => [
        'title' => 'График работы',
        'edit_schedule' => 'Редактировать график',
        'add_schedule' => 'Добавить график',
    ],
    
    // Subjects Section
    'subjects' => [
        'title' => 'Предметы',
        'no_subjects' => 'Предметов пока нет',
        'no_subjects_desc' => 'В этом учебном центре еще нет зарегистрированных предметов',
        'add_subject' => 'Добавить',
        'add_first_subject' => 'Добавить первый предмет',
        'delete_confirm' => 'Вы уверены, что хотите удалить предмет :name?',
        'add_subjects' => 'Управление предметами',
    ],
    
    // Teachers Section
    'teachers' => [
        'title' => 'Учителя',
        'no_teachers' => 'Учителей пока нет',
        'no_teachers_desc' => 'В этом учебном центре еще нет зарегистрированных учителей',
        'add_teacher' => 'Новый учитель',
        'add_first_teacher' => 'Добавить первого учителя',
        'delete_confirm' => 'Вы уверены, что хотите удалить :name?',
        'add_teachers' => 'Управление учителями',
        'experience' => 'Опыт',
        'years' => 'лет',
    ],
    
    // About Center Section
    'about_center' => [
        'title' => 'О центре',
        'no_description' => 'Описание еще не добавлено',
        'edit_description' => 'Редактировать описание',
    ],
    
    // Location Section
    'location' => [
        'title' => 'Местоположение',
        'get_directions' => 'Получить направления',
    ],
    
    // Announcements Section
    'announcements' => [
        'title' => 'Объявления',
        'no_announcements' => 'Объявлений нет',
        'no_announcements_desc' => 'В этом учебном центре еще нет объявлений учителей',
        'add_announcement' => 'Новое объявление',
        'add_first_announcement' => 'Добавить первое объявление',
        'teacher_needed' => 'учитель нужен',
        'active_announcement' => 'Активное объявление',
        'delete_confirm' => 'Вы уверены, что хотите удалить это объявление?',
        'delete_announcement' => 'Удалить объявление',
        'posted' => 'Опубликовано',
    ],
    
    // Social Media Section
    'social' => [
        'title' => 'Социальные сети',
        'no_socials' => 'Нет социальных сетей',
        'no_socials_desc' => 'В этом учебном центре еще нет зарегистрированных социальных сетей',
        'add_first_network' => 'Добавить первую сеть',
        'manage' => 'Управление',
    ],
    
    // Comments Section
    'comments' => [
        'title' => 'Комментарии',
        'no_comments' => 'Комментариев пока нет',
        'add_comment' => 'Оставить комментарий',
        'comment_placeholder' => 'Напишите ваш комментарий здесь...',
        'send_comment' => 'Отправить комментарий',
        'delete_confirm' => 'Вы уверены, что хотите удалить этот комментарий?',
        'delete_comment' => 'Удалить комментарий',
        'rate_center' => 'Оцените центр',
        'login_to_comment' => 'Войдите чтобы оставить комментарий',
        'login_desc' => 'Вам нужно войти чтобы поделиться мыслями и комментариями',
        'total_comments' => 'Всего комментариев',
        'login' => 'Войти',
        'register' => 'Регистрация',
    ],
    
    // CTA Section
    'cta' => [
        'title' => 'Заинтересованы в этом центре?',
        'description' => 'Получите больше информации, связавшись с нами или обратившись в центр напрямую',
        'login' => 'Войти',
    ],

    // Additional keys for blade file
    'verified' => 'Подтвержденный центр',
    'about_title' => 'О центре',
    'no_description' => 'Описание недоступно',
    'gallery_title' => 'Фотогалерея',
    'edit_images_btn' => 'Редактировать изображения',
    'schedule_title' => 'График работы',
    'edit_schedule_btn' => 'Редактировать график',
    'new_teacher' => 'Новый учитель',
    'no_subject_assigned' => 'Предмет не назначен',
    'delete_teacher_confirm' => 'Вы уверены, что хотите удалить :name?',
    'no_teachers_title' => 'Учителей пока нет',
    'no_teachers_message' => 'В этом учебном центре еще нет зарегистрированных учителей',
    'add_first_teacher_btn' => 'Добавить первого учителя',
    'location_title' => 'Местоположение',
    'comments_title' => 'Отзывы и комментарии',
    'comments_count' => 'отзывов',
    'rate_this_center' => 'Оцените центр',
    'write_comment' => 'Напишите отзыв',
    'comment_placeholder' => 'Поделитесь своим опытом об этом учебном центре...',
    'submit_comment' => 'Отправить отзыв',
    'login_to_comment' => 'Войдите, чтобы оставить отзыв',
    'login_button' => 'Войти',
    'quick_info' => 'Быстрая информация',
    'type' => 'Тип',
    'address' => 'Адрес',
    'added' => 'Добавлен',
    'student_count' => 'Студенты',
    'edit' => 'Редактировать',
    'delete' => 'Удалить',
    'delete_center_confirm' => 'Вы уверены, что хотите удалить центр :name?',
    'legal_info' => 'Юридическая информация',
    'tin' => 'ИНН',
    'license_number' => 'Номер лицензии',
    'license_date' => 'Дата выдачи лицензии',
    'license_validity' => 'Срок действия лицензии',
    'manager' => 'Руководитель',
    'phone' => 'Телефон',
    'email' => 'Email',
    'ifut_code' => 'Код ИФУТ',
    'territory' => 'Отдел надзора',
    'legal_address' => 'Юридический адрес',
    'subjects_title' => 'Предметы',
    'add' => 'Добавить',
    'no_subject_type' => 'Тип предмета не указан',
    'no_description_short' => 'Описание не указано',
    'currency' => 'сум',
    'period' => 'мес',
    'no_teacher_assigned' => 'Учитель не назначен',
    'delete_subject_confirm' => 'Вы уверены, что хотите удалить предмет :name?',
    'no_subjects_title' => 'Предметов пока нет',
    'no_subjects_message' => 'В этом учебном центре еще нет зарегистрированных предметов',
    'add_first_subject_btn' => 'Добавить первый предмет',
    'weekly_schedule' => 'Еженедельное расписание',
    'time_separator' => '-',
    'no_schedule' => 'Расписание недоступно',
    'no_schedule_title' => 'Расписания пока нет',
    'no_schedule_message' => 'В этом учебном центре еще не установлено расписание работы',
    'add_schedule_btn' => 'Добавить расписание',
    'social_networks' => 'Социальные сети',
    'no_socials_title' => 'Нет социальных сетей',
    'no_socials_message' => 'В этом учебном центре еще нет зарегистрированных контактов',
    'add_contact_btn' => 'Добавить контакт',
    'teacher_announcements' => 'Объявления учителей',
    'add_announcement_btn' => 'Добавить объявление',
    'no_announcements_title' => 'Объявлений нет',
    'no_announcements_message' => 'В этом учебном центре пока нет объявлений учителей',
    'create_announcement_btn' => 'Создать объявление',
    'related_centers' => 'Похожие центры',
    'related_centers_desc' => 'Другие учебные центры, похожие на понравившийся вам',
    'rating_count' => 'оценок',
    'details' => 'Подробнее',
    'rating_labels' => ['Очень плохо', 'Плохо', 'Средне', 'Хорошо', 'Отлично'],
    'just_now' => 'Только что',
    'delete_comment_confirm' => 'Вы уверены, что хотите удалить этот комментарий?',
    'network_error' => 'Ошибка сети. Пожалуйста, попробуйте снова.',
    'error_occurred' => 'Произошла ошибка',
    'delete_comment_error' => 'Ошибка при удалении комментария',
    
    // Hero section
    'contact_btn' => 'Связаться',
    'gallery_btn' => 'Галерея',
    
    // Navigation
    'nav_about' => 'О нас',
    'nav_gallery' => 'Галерея',
    'nav_teachers' => 'Преподаватели',
    'nav_comments' => 'Комментарии',
    'nav_contact' => 'Контакт',
    
    // About section
    'about_title' => 'О нас',
    'no_info_available' => 'Информация недоступна',
    
    // Stats
    'students' => 'Студенты',
    'teachers_count' => 'Преподаватели',
    'subjects_count' => 'Предметы',
    'ratings_count' => 'Оценки',
    
    // Contact sidebar
    'contact_title' => 'Контакт',
    'phone_label' => 'Телефон',
    'email_label' => 'Email',
    'address_label' => 'Адрес',
    
    // Social networks
    'social_networks_title' => 'Социальные сети',
    
    // Gallery
    'gallery_title' => 'Фотогалерея',
    'gallery_description' => 'Нажмите на изображение для увеличения',
    'zoom_image' => 'Увеличить',
    'gallery_navigation' => 'Навигация клавишами ? ESC или клик для закрытия',
    
    // Teachers
    'teachers_title' => 'Наши преподаватели',
    'teachers_description' => 'Опытная и квалифицированная команда преподавателей',
    
    // Legal info
    'legal_info_title' => 'Юридическая информация',
    'legal_info_description' => 'Официальная информация о центре и лицензии',
    'legal_info_section' => 'Юридическая информация',
    'inn_label' => 'ИНН',
    'legal_address_label' => 'Юридический адрес',
    'license_section' => 'Лицензия',
    'license_number_label' => 'Номер лицензии',
    'license_date_label' => 'Дата регистрации',
    'license_validity_label' => 'Срок действия',
    'manager_section' => 'Информация о менеджере',
    'manager_name_label' => 'Имя менеджера',
    'phone_number_label' => 'Номер телефона',
    'ifut_code_label' => 'Код ИФУТ',
    'territory_section' => 'Территория',
    'territory_label' => 'Зона обслуживания',
    
    // Subjects and teachers
    'subjects_teachers_title' => 'Предметы и преподаватели',
    'subjects_teachers_description' => 'Предметы и их квалифицированные преподаватели в нашем центре',
    'prices_label' => 'Цены',
    'price_not_set' => 'Цена не указана',
    'teachers_list' => 'Преподаватели',
    'no_teacher_assigned' => 'Преподаватель не назначен',
    
    // Comments
    'comments_title' => 'Отзывы и мнения',
    'comments_description' => 'Поделитесь своим мнением об учебном центре',
    'rate_center' => 'Оцените центр',
    'leave_comment' => 'Оставить комментарий',
    'comment_placeholder' => 'Напишите свое мнение...',
    'submit' => 'Отправить',
    'login_to_comment_text' => 'Войдите чтобы оставить комментарий',
    'login_btn' => 'Войти',
    
    // Share section
    'share_title' => 'Другим должно это знать!',
    'share_description' => 'Расскажите друзьям об этом учебном центре',
    'share_function_not_available' => 'Функция деления недоступна',
    'share_with_friends' => 'Поделиться с друзьями',
    
    // Time labels
    'just_now' => 'Только что',
    
    // Error messages
    'error_occurred' => 'Произошла ошибка',
    'network_error' => 'Сетевая ошибка',
    
    // Confirm messages
    'delete_comment_confirm' => 'Удалить этот комментарий?',
    'delete_confirm_js' => 'Подтвердите удаление',
    'delete_error_js' => 'Ошибка удаления',
    
    // Gallery lightbox
    'lightbox_more_text' => 'Еще',
    
    // Rating count
    'rating_count_suffix' => 'оценок',
];
