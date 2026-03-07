@props([
    'variant' => 'primary',
    'size' => 'normal',
    'class' => '',
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';

    $sizeClasses = match ($size) {
        'sm' => 'px-2 py-1 text-xs',
        'normal' => 'px-3 py-1 text-xs',
        'lg' => 'px-4 py-2 text-sm',
        default => 'px-3 py-1 text-xs',
    };

    $variantClasses = match ($variant) {
        'primary' => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200',
        'success' => 'bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200',
        'danger' => 'bg-danger-100 text-danger-800 dark:bg-danger-900 dark:text-danger-200',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
        default => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200',
    };

    $classes = implode(' ', array_filter([$baseClasses, $sizeClasses, $variantClasses, $class]));
@endphp

<span class="{{ $classes }}">
    {{ $slot }}
</span>
