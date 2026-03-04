@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'href' => null,
    'class' => ''
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizeClasses = match($size) {
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
        default => 'px-6 py-3 text-base'
    };
    
    $variantClasses = match($variant) {
        'primary' => 'bg-gradient-to-r from-primary-600 to-accent-600 text-white hover:scale-105 shadow-lg hover:shadow-xl focus:ring-primary-500',
        'secondary' => 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-primary-500',
        'outline' => 'bg-transparent text-primary-600 border-2 border-primary-600 hover:bg-primary-600 hover:text-white focus:ring-primary-500',
        'ghost' => 'bg-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-primary-500',
        'danger' => 'bg-danger-600 text-white hover:bg-danger-700 focus:ring-danger-500',
        'success' => 'bg-success-600 text-white hover:bg-success-700 focus:ring-success-500',
        default => 'bg-gradient-to-r from-primary-600 to-accent-600 text-white hover:scale-105 shadow-lg hover:shadow-xl focus:ring-primary-500'
    };
    
    $classes = implode(' ', array_filter([$baseClasses, $sizeClasses, $variantClasses, $class]));
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" {{ $disabled ? 'tabindex="-1" aria-disabled="true"' : '' }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}" {{ $disabled ? 'disabled' : '' }}>
        {{ $slot }}
    </button>
@endif
