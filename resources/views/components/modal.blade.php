@props([
    'id' => 'modal',
    'show' => false,
    'size' => 'md',
    'closeOnBackdrop' => true
])

@php
    $sizeClasses = match($size) {
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
        default => 'max-w-lg'
    };
@endphp

<div 
    x-data="{ 
        open: {{ $show ? 'true' : 'false' }},
        closeModal() { 
            this.open = false;
            @if($closeOnBackdrop)
            document.body.style.overflow = 'auto';
            @endif
        },
        openModal() { 
            this.open = true;
            @if($closeOnBackdrop)
            document.body.style.overflow = 'hidden';
            @endif
        }
    }"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
        @if($closeOnBackdrop)
        @click="closeModal()"
        @endif
    ></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative {{ $sizeClasses }} w-full bg-white dark:bg-gray-800 rounded-2xl shadow-floating"
        >
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $title ?? 'Modal' }}
                </h3>
                <button 
                    @click="closeModal()"
                    class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                {{ $slot }}
            </div>

            <!-- Footer (if provided) -->
            @if(isset($footer))
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 rounded-b-2xl">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
