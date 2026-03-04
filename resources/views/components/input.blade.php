@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'label' => null,
    'class' => ''
])

@php
    $inputId = $id ?? $name;
    $baseClasses = 'w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent';
    
    $stateClasses = $error 
        ? 'border-danger-500 focus:ring-danger-500' 
        : 'border-gray-300 dark:border-gray-600 focus:ring-primary-500 focus:border-primary-500';
    
    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100 dark:bg-gray-700' : '';
    
    $classes = implode(' ', array_filter([$baseClasses, $stateClasses, $disabledClasses, $class]));
@endphp

<div class="space-y-2">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-danger-500">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $inputId }}" 
        value="{{ $value }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="{{ $classes }}"
    >
    
    @if($error)
        <p class="text-sm text-danger-600 dark:text-danger-400">{{ $error }}</p>
    @endif
</div>
