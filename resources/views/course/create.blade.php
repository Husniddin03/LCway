<x-layout>
    <x-slot:title>O'quv markaz qo'shish</x-slot:title>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-out {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
        
        .animate-fade-out {
            animation: fade-out 0.3s ease-out;
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        .form-group {
            @apply transition-all duration-200;
        }
        
        .form-group:focus-within {
            @apply transform scale-[1.01];
        }
        
        @media (max-width: 640px) {
            .mobile-stack {
                flex-direction: column !important;
            }
            
            .mobile-full {
                width: 100% !important;
            }
        }
        
        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .border-gray-300 {
                border-color: #000;
            }
            
            .text-gray-600 {
                color: #000;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in,
            .animate-fade-out,
            .animate-spin,
            .transition-all {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Yangi o'quv markaz qo'shing
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    O'quv markazingiz haqida to'liq ma'lumotlarni kiriting
                </p>
            </div>

            <!-- Form Card -->
            <x-card class="mb-8">
                <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div id="error-alert" class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 rounded-xl p-4 mb-6 animate-fade-in">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-danger-600 dark:text-danger-400 mr-3 flex-shrink-0 mt-0.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-danger-800 dark:text-danger-200">Iltimos, xatolarni to'g'rilang:</h4>
                                        <ul class="mt-2 text-sm text-danger-700 dark:text-danger-300 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li class="flex items-start">• <span class="ml-1">{{ $error }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button onclick="document.getElementById('error-alert').remove()" class="text-danger-400 hover:text-danger-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                    <polyline points="17,21 17,13 7,13 7,21" />
                                    <polyline points="7,3 7,8 15,8" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Asosiy ma'lumotlar</h3>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Logo Upload -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Markazning asosiy rasmi (logo)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                onclick="document.getElementById('logo').click()">
                                <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                    onchange="document.getElementById('logo-preview').src = window.URL.createObjectURL(this.files[0])">
                                <div id="logo-preview"
                                    class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Logo yuklash uchun bosing
                                </p>
                            </div>
                            @error('logo')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Nomi <span class="text-danger-500 ml-1">*</span>
                            </label>
                            <x-input type="text" name="name" id="name" value="{{ old('name') }}"
                                placeholder="O'quv markaz nomini kiriting" required class="transition-all duration-200 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                            @error('name')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="form-group">
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Turi <span class="text-danger-500 ml-1">*</span>
                            </label>
                            <select name="type" id="type"
                                class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent"
                                required>
                                <option value="" disabled {{ !old('type') ? 'selected' : '' }}>Markaz turini tanlang...</option>
                                <option value="O'quv markaz" {{ old('type') == 'O\'quv markaz' ? 'selected' : '' }}>O'quv markaz</option>
                                <option value="Akademiya" {{ old('type') == 'Akademiya' ? 'selected' : '' }}>Akademiya</option>
                                <option value="Kollej" {{ old('type') == 'Kollej' ? 'selected' : '' }}>Kollej</option>
                                <option value="Universitet" {{ old('type') == 'Universitet' ? 'selected' : '' }}>Universitet</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                            <!-- About -->
                            <div class="lg:col-span-2 form-group">
                                <label for="about"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Haqida
                                </label>
                                <div class="relative">
                                    <textarea name="about" id="about" rows="4"
                                class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent"
                                    placeholder="O'quv markaz haqida qisqacha ma'lumot..." maxlength="500">{{ old('about') }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                        <span id="about-char-count">{{ strlen(old('about') ?? '') }}</span>/500
                                    </div>
                                </div>
                                @error('about')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Images Upload -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Markaz rasmlari</h3>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Markaz rasmlari
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-colors cursor-pointer"
                                onclick="document.getElementById('images').click()">
                                <input type="file" name="images[]" id="images" class="hidden" accept="image/*"
                                    multiple>
                                <div
                                    class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Markaz rasmlarini yuklash uchun bosing
                                </p>
                            </div>
                            @error('images.*')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Manzil ma'lumotlari</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Region -->
                            <div>
                                <label for="region"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Viloyat <span class="text-danger-500">*</span>
                                </label>
                                <select name="province" id="region" class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent" required>
                                    <option value="" disabled {{ !old('province') ? 'selected' : '' }}>Viloyatni
                                        tanlang...</option>
                                    <option value="Toshkent" {{ old('province') == 'Toshkent' ? 'selected' : '' }}>
                                        Toshkent</option>
                                    <option value="Sirdaryo" {{ old('province') == 'Sirdaryo' ? 'selected' : '' }}>
                                        Sirdaryo</option>
                                    <option value="Jizzax" {{ old('province') == 'Jizzax' ? 'selected' : '' }}>Jizzax
                                    </option>
                                    <option value="Samarqand" {{ old('province') == 'Samarqand' ? 'selected' : '' }}>
                                        Samarqand</option>
                                    <option value="Buxoro" {{ old('province') == 'Buxoro' ? 'selected' : '' }}>Buxoro
                                    </option>
                                    <option value="Navoiy" {{ old('province') == 'Navoiy' ? 'selected' : '' }}>Navoiy
                                    </option>
                                    <option value="Qashqadaryo"
                                        {{ old('province') == 'Qashqadaryo' ? 'selected' : '' }}>Qashqadaryo</option>
                                    <option value="Surxandaryo"
                                        {{ old('province') == 'Surxandaryo' ? 'selected' : '' }}>Surxandaryo</option>
                                    <option value="Xorazm" {{ old('province') == 'Xorazm' ? 'selected' : '' }}>Xorazm
                                    </option>
                                    <option value="Andijon" {{ old('province') == 'Andijon' ? 'selected' : '' }}>
                                        Andijon</option>
                                    <option value="Namangan" {{ old('province') == 'Namangan' ? 'selected' : '' }}>
                                        Namangan</option>
                                    <option value="Farg'ona" {{ old('province') == 'Farg\'ona' ? 'selected' : '' }}>
                                        Farg'ona</option>
                                    <option value="Qoraqalpog'iston"
                                        {{ old('province') == 'Qoraqalpog\'iston' ? 'selected' : '' }}>Qoraqalpog'iston
                                    </option>
                                </select>
                                @error('province')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div>
                                <label for="district"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tuman <span class="text-danger-500">*</span>
                                </label>
                                <select name="region" id="district" class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent" required>
                                    <option value="" disabled {{ !old('region') ? 'selected' : '' }}>Tumanni
                                        tanlang...</option>
                                    <option value="{{ old('region') }}" selected>{{ old('region') }}</option>
                                </select>
                                @error('region')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Manzil <span class="text-danger-500">*</span>
                                </label>
                                <x-input type="text" name="address" id="address" value="{{ old('address') }}"
                                    placeholder="To'liq manzilni kiriting" required />
                                @error('address')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="h-96 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden">
                            <div id="map" class="w-full h-full"></div>
                        </div>

                        <!-- Hidden location fields -->
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>

                    <!-- Student Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">O'quvchilar soni</h3>
                        </div>
                        <div class="form-group">
                            <label for="studentCount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Hozirda markazingizdagi o'quvchilar soni
                            </label>
                            <x-input type="number" name="student_count" id="studentCount"
                                value="{{ old('student_count') }}" placeholder="0" min="0" class="transition-all duration-200 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                            @error('student_count')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                        <a href="{{ route('index') }}" 
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Orqaga
                        </a>
                        <button type="submit"
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 hover:from-blue-700 hover:via-cyan-700 hover:to-teal-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Saqlash
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <script>
        // Logo preview functionality
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('logo-preview').innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Multiple images preview functionality
        document.getElementById('images').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const previewContainer = document.getElementById('images-preview');

            if (files.length > 0) {
                let previewHtml = '<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">';

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = document.getElementById(`preview-${index}`);
                        if (imgElement) {
                            imgElement.src = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);

                    previewHtml += `
                        <div class="relative group">
                            <img id="preview-${index}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600" alt="Preview ${index + 1}">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">${file.name}</span>
                            </div>
                        </div>
                    `;
                });

                previewHtml += '</div>';

                // Create or update preview container
                if (!previewContainer) {
                    const container = document.querySelector('input[name="images[]"]').parentElement;
                    const div = document.createElement('div');
                    div.id = 'images-preview';
                    div.innerHTML = previewHtml;
                    container.appendChild(div);
                } else {
                    previewContainer.innerHTML = previewHtml;
                }
            }
        });

        // Character counter for about field
        const aboutField = document.getElementById('about');
        const charCount = document.getElementById('about-char-count');
        
        if (aboutField && charCount) {
            aboutField.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count;
                
                if (count > 450) {
                    charCount.classList.add('text-orange-500');
                } else {
                    charCount.classList.remove('text-orange-500');
                }
            });
        }
        
        // Districts by region data
        const districtsByRegion = {
            "Toshkent": ["Bekobod", "Bo'ka", "Chinoz", "Oqqo'rg'on", "Ohangaron", "Piskent", "Quyichirchiq",
                "Yuqorichirchiq", "Zangiota", "Toshkent tumani", "Parkent"
            ],
            "Sirdaryo": ["Guliston", "Boyovut", "Sardoba", "Mirzaobod", "Hovos", "Oqoltin", "Sayxunobod",
                "Sirdaryo tumani"
            ],
            "Jizzax": ["Jizzax shahri", "Arnasoy", "Baxmal", "Do'stlik", "Forish", "G'llaorol", "Sharof Rashidov",
                "Paxtakor", "Zomin", "Yangiobod", "Mirzacho'l", "Gagarin"
            ],
            "Samarqand": ["Samarqand shahri", "Bulung'ur", "Jomboy", "Ishtixon", "Kattaqo'rg'on", "Narpay", "Oqdaryo",
                "Pastdarg'om", "Payariq", "Qo'shrabot", "Samarqand tumani", "Tayloq", "Urgut", "Chelak", "Ziyodin",
                "Kattaqo'rg'on shahri"
            ],
            "Buxoro": ["Buxoro shahri", "Buxoro tumani", "G'ijduvon", "Jondor", "Kogon shahri", "Kogon tumani", "Olot",
                "Peshku", "Qorako'l", "Qorovulbozor", "Shofirkon"
            ],
            "Navoiy": ["Navoiy shahri", "Zarafshon shahri", "Karmana", "Xatirchi", "Qiziltepa", "Navbahor", "Tomdi",
                "Uchquduq"
            ],
            "Qashqadaryo": ["Qarshi shahri", "Qarshi tumani", "Shahrisabz shahri", "Shahrisabz tumani", "Kitob",
                "Yakkabog'", "Chiroqchi", "Nishon", "Muborak", "Qamashi", "Koson", "Kasbi", "G'uzor", "Mirishkor"
            ],
            "Surxandaryo": ["Termiz shahri", "Angor", "Boysun", "Denov", "Jarqo'rg'on", "Muzrabot", "Oltinsoy",
                "Qiziriq", "Qumqo'rg'on", "Sariosiyo", "Sherobod", "Sho'rch", "Termiz tumani", "Uzun"
            ],
            "Xorazm": ["Urganch shahri", "Bog'ot", "Gurlan", "Hazorasp", "Xiva", "Qo'shko'pir", "Shovot", "Tuproqqal'a",
                "Urganch tumani", "Xonqa", "Yangibozor"
            ],
            "Andijon": ["Andijon shahri", "Andijon tumani", "Asaka", "Baliqchi", "Bo'z", "Buloqboshi", "Izboskan",
                "Jalolquduq", "Xo'jaobod", "Qo'rg'ontepa", "Marhamat", "Oltinko'l", "Paxtaobod", "Shahrixon",
                "Ulug'nor", "Xonobod shahri"
            ],
            "Namangan": ["Namangan shahri", "Chortoq", "Chust", "Kosonsoy", "Mingbuloq", "Norin", "Pop",
                "To'raqo'rg'on", "Uychi", "Yangiqo'rg'on", "Namangan tumani"
            ],
            "Farg'ona": ["Farg'ona shahri", "Qo'qon shahri", "Marg'ilon shahri", "Oltiariq", "O'zbekiston tumani",
                "Quva", "Rishton", "Toshloq", "Yozyovon", "Dang'ara", "Beshariq", "Bog'dod", "So'x", "Uchko'prik",
                "Furqat"
            ],
            "Qoraqalpog'iston": ["Nukus shahri", "Amudaryo", "Beruniy", "Chimboy", "Ellikqal'a", "Kegeyli", "Mo'ynoq",
                "Nukus tumani", "Qanliko'l", "Qo'ng'irot", "Qorao'zak", "Shumanay", "Taxtako'pir", "To'tko'l",
                "Xo'jayli", "Taxiatosh shahri"
            ]
        };

        // Region/District functionality
        const regionSelect = document.getElementById("region");
        const districtSelect = document.getElementById("district");

        regionSelect.addEventListener("change", () => {
            const selectedRegion = regionSelect.value;
            districtSelect.innerHTML = '<option value="" disabled selected>Tumanni tanlang...</option>';

            if (districtsByRegion[selectedRegion]) {
                districtsByRegion[selectedRegion].forEach((district) => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Saqlanmoqda...
            `;
            
            // Reset after 3 seconds if form hasn't submitted
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 3000);
        });

        // Map initialization
        function initMap() {
            const mapElement = document.getElementById("map");
            if (!mapElement) return;

            // Default location (Samarqand, Uzbekistan)
            const defaultLocation = {
                lat: 39.6542,
                lng: 66.9757
            };

            const map = new google.maps.Map(mapElement, {
                center: defaultLocation,
                zoom: 12,
                styles: [
                    {
                        "featureType": "poi",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "off" }]
                    }
                ],
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true
            });

            let marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: "O'quv markaz manzili"
            });

            // Update hidden fields when marker is dragged
            marker.addListener('dragend', function(event) {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                updateLocationFields(lat, lng);
            });

            // Update marker position when map is clicked
            map.addListener('click', function(event) {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                marker.setPosition(event.latLng);
                marker.setAnimation(google.maps.Animation.DROP);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                updateLocationFields(lat, lng);
            });

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        marker.setPosition(userLocation);
                        document.getElementById('latitude').value = userLocation.lat;
                        document.getElementById('longitude').value = userLocation.lng;
                        updateLocationFields(userLocation.lat, userLocation.lng);
                        showNotification('Joriy joylashuv topildi!', 'success');
                    },
                    function(error) {
                        console.log('Geolokatsiya xatosi:', error.message);
                        // Keep default location (Samarqand) if geolocation fails
                        updateLocationFields(defaultLocation.lat, defaultLocation.lng);
                    }
                );
            } else {
                updateLocationFields(defaultLocation.lat, defaultLocation.lng);
            }
        }
        
        // Update location fields function
        function updateLocationFields(lat, lng) {
            const url = `${lat},${lng}`;
            
            // Update location URL field
            const locationField = document.getElementById('location');
            if (locationField) {
                locationField.value = url;
            }
            
            // Try to reverse geocode to get address
            if (typeof google !== 'undefined' && google.maps) {
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                    if (status === "OK" && results[0]) {
                        const address = results[0].formatted_address;
                        const addressField = document.getElementById('address');
                        if (addressField) {
                            addressField.value = address;
                        }
                        
                        // Try to update region and district
                        const components = results[0].address_components;
                        const region = components.find(c => c.types.includes("administrative_area_level_1"));
                        const district = components.find(c => c.types.includes("administrative_area_level_2"));
                        
                        const regionSelect = document.getElementById("region");
                        const districtSelect = document.getElementById("district");
                        
                        if (region && regionSelect) {
                            for (let option of regionSelect.options) {
                                if (option.value && region.long_name.includes(option.value)) {
                                    option.selected = true;
                                    regionSelect.dispatchEvent(new Event('change'));
                                    break;
                                }
                            }
                        }
                        
                        if (district && districtSelect) {
                            setTimeout(() => {
                                for (let option of districtSelect.options) {
                                    if (option.value && district.long_name.includes(option.value)) {
                                        option.selected = true;
                                        break;
                                    }
                                }
                            }, 100);
                        }
                    }
                });
            }
        }
        
        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-danger-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500';
            
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in flex items-center`;
            notification.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('animate-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Initialize map when page loads
        if (typeof google !== 'undefined') {
            window.initMap = initMap;
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    </script>
</x-layout>
