<?php

return [
    // Page Title
    'title' => 'Add Learning Center',

    // Header Section
    'header' => [
        'title' => 'Add New Learning Center',
        'description' => 'Enter complete information about your learning center',
    ],

    // Error Messages
    'error' => [
        'title' => 'Please correct the errors:',
        'file_size' => 'File size must not exceed 1MB!',
        'location_not_supported' => 'Your browser does not support location services!',
        'location_detecting' => 'Detecting location...',
        'location_found' => 'Current location found!',
        'location_failed' => 'Unable to get location!',
    ],

    // Form Sections
    'basic_info' => [
        'title' => 'Basic Information',
        'logo_label' => 'Center Main Image (Logo)',
        'logo_hint' => 'Click or drag to upload logo',
        'logo_format' => 'PNG, JPG, WebP — max 1MB',
        'name_label' => 'Name',
        'name_placeholder' => 'Enter learning center name',
        'type_label' => 'Type',
        'type_placeholder' => 'Select center type...',
        'about_label' => 'About',
        'about_placeholder' => 'Brief information about the learning center...',
    ],

    'images' => [
        'title' => 'Center Images',
        'hint' => 'Click to upload center images (multiple selection allowed)',
    ],

    'location' => [
        'title' => 'Location Information',
        'current_location' => 'Current Location',
        'hint' => 'Click on the map or drag the marker to select location — province, district, and address will be filled automatically.',
        'province_label' => 'Province',
        'province_placeholder' => 'Select province...',
        'district_label' => 'District',
        'district_placeholder' => 'Select district...',
        'address_label' => 'Address',
        'address_placeholder' => 'Full address (automatically filled from map)',
    ],

    'students' => [
        'title' => 'Number of Students',
        'label' => 'Current number of students in your center',
        'placeholder' => '0',
    ],

    // Form Types
    'types' => [
        'center' => 'Learning Center',
        'academy' => 'Academy',
        'college' => 'College',
        'university' => 'University',
        'school' => 'School',
        'school_course' => 'School/Course',
        'language_course' => 'Language Courses',
        'driving_course' => 'Driving School',
        'it_course' => 'IT Courses',
        'design_course' => 'Design Courses',
        'music_school' => 'Music School',
        'sports_school' => 'Sports School',
        'art_school' => 'Art School',
        'vocational_school' => 'Vocational School',
    ],

    // Buttons
    'buttons' => [
        'back' => 'Back',
        'save' => 'Save',
        'saving' => 'Saving...',
    ],

    // Required Field
    'required' => '*',

    // Provinces
    'provinces' => [
        'tashkent' => 'Tashkent',
        'sirdaryo' => 'Sirdaryo',
        'jizzax' => 'Jizzax',
        'samarkand' => 'Samarkand',
        'bukhara' => 'Bukhara',
        'navoiy' => 'Navoiy',
        'kashkadarya' => 'Kashkadarya',
        'surkhandarya' => 'Surkhandarya',
        'khorezm' => 'Khorezm',
        'andijan' => 'Andijan',
        'namangan' => 'Namangan',
        'fergana' => 'Fergana',
        'karakalpakstan' => 'Karakalpakstan',
    ],

    // Map
    'map' => [
        'marker_title' => 'Learning Center Location',
    ],
];
