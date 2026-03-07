@props([
    'trigger' => 'click',
    'placement' => 'bottom-right',
    'offset' => 4
])

@php
    $placementClasses = match($placement) {
        'bottom-left' => 'right-0',
        'bottom-right' => 'left-0',
        'top-left' => 'bottom-full right-0 mb-2',
        'top-right' => 'bottom-full left-0 mb-2',
        default => 'left-0'
    };
@endphp

<div x-data="{ open: false }" class="relative inline-block w-full">
    <!-- Trigger -->
    <div @click="{{ $trigger === 'click' ? 'open = !open' : '' }}" @mouseenter="{{ $trigger === 'hover' ? 'open = true' : '' }}" @mouseleave="{{ $trigger === 'hover' ? 'open = false' : '' }}">
        {{ $trigger }}
    </div>

    <!-- Dropdown Menu -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.away="open = false"
        class="absolute {{ $placementClasses }} mt-{{ $offset }} w-full rounded-xl shadow-floating bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
        style="display: none;"
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
