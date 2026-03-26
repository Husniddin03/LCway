@props([
    'hover' => false,
    'padding' => 'normal',
    'class' => '',
])

@php
    $baseClasses = 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-medium transition-all duration-300';

    $paddingClasses = match ($padding) {
        'none' => '',
        'sm' => 'p-4',
        'normal' => 'p-6',
        'lg' => 'p-8',
        default => 'p-6',
    };

    $hoverClasses = $hover ? 'hover:shadow-floating hover:scale-105 hover:-translate-y-1 hover:border-primary-300 dark:hover:border-primary-600' : '';

    $classes = implode(' ', array_filter([$baseClasses, $paddingClasses, $hoverClasses, $class]));
@endphp

<div class="{{ $classes }}">
    {{ $slot }}
</div>
