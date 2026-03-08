<x-layout>
    <x-slot:title>O'quv markazni tahrirlash</x-slot:title>

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
                    {{ $center->name }} markazini tahrirlash
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    O'quv markaz ma'lumotlarini yangilang
                </p>
            </div>
            <!-- Form Card -->
            <x-card class="mb-8">
                <form action="{{ route('course.update', $center->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

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

                    <!-- Current Logo -->
                    @isset($center->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mavjud Logo
                            </label>
                            <div class="w-32 h-32 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                <img src="{{ asset('storage/' . $center->logo) }}" alt="Current logo"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endisset

                        <div class="relative">
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Yangi Logo
                                <span class="text-xs text-gray-500 ml-2">(PNG, JPG, WebP - maks 2MB)</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-primary-500 transition-all duration-300 cursor-pointer group hover:bg-primary-50/50 dark:hover:bg-primary-900/10"
                                onclick="document.getElementById('logo').click()">
                                <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                    onchange="previewLogo(this)">
                                <div id="logo-preview-container" class="relative">
                                    <div id="logo-preview"
                                        class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                        <svg class="w-10 h-10 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                            <circle cx="12" cy="13" r="3" />
                                        </svg>
                                    </div>
                                    <div id="logo-remove-btn" class="hidden absolute top-0 right-0 bg-danger-500 text-white rounded-full p-1 cursor-pointer hover:bg-danger-600 transition-colors"
                                        onclick="event.stopPropagation(); removeLogo()">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    Yangi logo yuklash uchun bosing yoki torting olib qo'ying
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Yoki kompyuterdan fayl tanlang</p>
                            </div>
                            <div id="logo-progress" class="hidden mt-2">
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                            </div>
                            @error('logo')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

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
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Nomi <span class="text-danger-500 ml-1">*</span>
                            </label>
                            <x-input type="text" name="name" id="name" value="{{ $center->name }}"
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
                                <option value="" disabled {{ !$center->type ? 'selected' : '' }}>Markaz turini tanlang...</option>
                                <option value="O'quv markaz" {{ $center->type == 'O\'quv markaz' ? 'selected' : '' }}>O'quv markaz</option>
                                <option value="Akademiya" {{ $center->type == 'Akademiya' ? 'selected' : '' }}>Akademiya</option>
                                <option value="Kollej" {{ $center->type == 'Kollej' ? 'selected' : '' }}>Kollej</option>
                                <option value="Universitet" {{ $center->type == 'Universitet' ? 'selected' : '' }}>Universitet</option>
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
                                        placeholder="O'quv markaz haqida qisqacha ma'lumot..." maxlength="500">{{ $center->about }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                        <span id="about-char-count">{{ strlen($center->about) }}</span>/500
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

                    <!-- Location Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Manzil ma'lumotlari</h3>
                        </div>

                        <!-- Map -->
                        <div class="relative">
                            <div class="h-96 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden shadow-inner">
                                <div id="map" class="w-full h-full"></div>
                            </div>
                            <div class="absolute top-4 right-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-2 z-10">
                                <button onclick="getCurrentLocation()" class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Joriy joylashuv
                                </button>
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium mb-1">Xaritadan manzilni tanlang</p>
                                    <p class="text-blue-700 dark:text-blue-300">Xaritadan manzilni tanlasangiz Viloyat, Tuman, manzil va manzil URL'i avtomatik to'ldiriladi. Agarda xato bo'lsa, o'zgartirishingiz mumkin.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Region -->
                            <div class="form-group">
                                <label for="region"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                    Viloyat <span class="text-danger-500 ml-1">*</span>
                                </label>
                                <select name="province" id="region"
                                    class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent"
                                    required>
                                    <option value="{{ $center->province }}" selected>{{ $center->province }}</option>
                                    <option value="Toshkent">Toshkent</option>
                                    <option value="Sirdaryo">Sirdaryo</option>
                                    <option value="Jizzax">Jizzax</option>
                                    <option value="Samarqand">Samarqand</option>
                                    <option value="Buxoro">Buxoro</option>
                                    <option value="Navoiy">Navoiy</option>
                                    <option value="Qashqadaryo">Qashqadaryo</option>
                                    <option value="Surxandaryo">Surxandaryo</option>
                                    <option value="Xorazm">Xorazm</option>
                                    <option value="Andijon">Andijon</option>
                                    <option value="Namangan">Namangan</option>
                                    <option value="Farg'ona">Farg'ona</option>
                                    <option value="Qoraqalpog'iston">Qoraqalpog'iston</option>
                                </select>
                                @error('province')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div class="form-group">
                                <label for="district"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Tuman <span class="text-danger-500 ml-1">*</span>
                                </label>
                                <select name="region" id="district"
                                    class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:border-transparent"
                                    required>
                                    <option value="{{ $center->region }}" selected>{{ $center->region }}</option>
                                </select>
                                @error('region')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2 form-group">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Manzil <span class="text-danger-500 ml-1">*</span>
                                </label>
                                <x-input type="text" name="address" id="address"
                                    value="{{ $center->address }}" placeholder="To'liq manzilni kiriting" required class="transition-all duration-200 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                                @error('address')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Location URL -->
                            <div class="md:col-span-2 form-group">
                                <label for="location"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    URL
                                </label>
                                <x-input type="text" name="location" id="location"
                                    value="{{ $center->location }}" placeholder="Manzil URL avtomatik yoziladi" class="transition-all duration-200 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                                @error('location')
                                    <p class="mt-2 text-sm text-danger-600 dark:text-danger-400 flex items-center animate-fade-in">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden location fields -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <!-- Student Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Qo'shimcha ma'lumotlar</h3>
                        </div>
                        <div class="form-group">
                            <label for="studentCount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Hozirda markazingizdagi o'quvchilar soni
                            </label>
                            <div class="relative">
                                <x-input type="number" name="student_count" id="studentCount"
                                    value="{{ $center->student_count }}" placeholder="0" min="0" class="pl-10 transition-all duration-200 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
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
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 mobile-stack">
                        <button type="submit" id="submit-btn"
                            class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 flex items-center justify-center group mobile-full"
                            aria-label="Formani saqlash">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                <polyline points="17,21 17,13 7,13 7,21" />
                                <polyline points="7,3 7,8 15,8" />
                            </svg>
                            <span id="submit-text">Saqlash</span>
                            <div id="submit-loader" class="hidden ml-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <span class="sr-only">Formani saqlash</span>
                        </button>
                        <a href="{{ route('blog-single', $center->id) }}"
                            class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-all duration-300 text-center flex items-center justify-center group mobile-full"
                            aria-label="Bekor qilish va orqaga qaytish">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Bekor qilish
                            <span class="sr-only">Bekor qilish va orqaga qaytish</span>
                        </a>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <script>
        // Logo preview functionality
        function previewLogo(input) {
            const previewContainer = document.getElementById('logo-preview');
            const removeBtn = document.getElementById('logo-remove-btn');
            const progressBar = document.querySelector('#logo-progress .bg-primary-600');
            const progressContainer = document.getElementById('logo-progress');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Fayl hajmi 2MB dan oshmasligi kerak!', 'error');
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    showNotification('Faqat rasm fayllariga ruxsat berilgan!', 'error');
                    input.value = '';
                    return;
                }
                
                // Show progress
                progressContainer.classList.remove('hidden');
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.random() * 30;
                    if (progress > 90) progress = 90;
                    progressBar.style.width = progress + '%';
                }, 100);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    setTimeout(() => {
                        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Logo preview" class="w-full h-full object-cover rounded-full">`;
                        removeBtn.classList.remove('hidden');
                        progressBar.style.width = '100%';
                        setTimeout(() => {
                            progressContainer.classList.add('hidden');
                            progressBar.style.width = '0%';
                        }, 500);
                        clearInterval(interval);
                    }, 800);
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Remove logo function
        function removeLogo() {
            document.getElementById('logo').value = '';
            document.getElementById('logo-preview').innerHTML = `
                <svg class="w-10 h-10 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
            `;
            document.getElementById('logo-remove-btn').classList.add('hidden');
        }
        
        // Character counter for about field
        const aboutField = document.getElementById('about');
        const charCount = document.getElementById('about-char-count');
        
        aboutField.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 450) {
                charCount.classList.add('text-orange-500');
            } else {
                charCount.classList.remove('text-orange-500');
            }
        });
        
        // Form submission with loading state
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoader = document.getElementById('submit-loader');
        
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitText.textContent = 'Saqlanmoqda...';
            submitLoader.classList.remove('hidden');
        });
        
        // Notification system
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
        
        // Drag and drop for logo
        const logoDropZone = document.querySelector('.border-dashed');
        
        logoDropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary-500', 'bg-primary-50/50');
        });
        
        logoDropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50/50');
        });
        
        logoDropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary-500', 'bg-primary-50/50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('logo').files = files;
                previewLogo(document.getElementById('logo'));
            }
        });
        
        // Auto-save functionality (optional)
        let autoSaveTimeout;
        const formInputs = form.querySelectorAll('input, textarea, select');
        
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Auto-save logic here if needed
                    console.log('Auto-save triggered');
                }, 2000);
            });
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                form.submit();
            }
            
            // Escape to cancel
            if (e.key === 'Escape') {
                const cancelLink = document.querySelector('a[href*="blog-single"]');
                if (cancelLink) {
                    cancelLink.click();
                }
            }
        });
    </script>

    @php
        // Default to Samarkand center coordinates if location is empty or invalid
        $location = [39.6542, 66.9757]; // Samarkand coordinates
        if (!empty($center->location)) {
            $parts = explode(',', $center->location);
            if (count($parts) >= 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $location = $parts;
            }
        }
    @endphp

    <script>
        // Dinamik tumanlar ro'yxati
        const districtsByRegion = {
            Toshkent: ["Bekobod", "Bo'ka", "Chinoz", "Oqqo'rg'on", "Ohangaron",
                "Piskent", "Quyichirchiq", "Yuqorichirchiq", "Zangiota",
                "Toshkent tumani", "Parkent"
            ],
            Sirdaryo: ["Guliston", "Boyovut", "Sardoba", "Mirzaobod", "Hovos",
                "Oqoltin", "Sayxunobod", "Sirdaryo tumani"
            ],
            Jizzax: ["Jizzax shahri", "Arnasoy", "Baxmal", "Do'stlik", "Forish",
                "G'llaorol", "Sharof Rashidov", "Paxtakor", "Zomin",
                "Yangiobod", "Mirzacho'l", "Gagarin"
            ],
            Samarqand: ["Samarqand shahri", "Bulung'ur", "Jomboy", "Ishtixon",
                "Kattaqo'rg'on", "Narpay", "Oqdaryo", "Pastdarg'om",
                "Payariq", "Qo'shrabot", "Samarqand tumani", "Tayloq",
                "Urgut", "Chelak", "Ziyodin", "Kattaqo'rg'on shahri"
            ],
            Buxoro: ["Buxoro shahri", "Buxoro tumani", "G'ijduvon", "Jondor",
                "Kogon shahri", "Kogon tumani", "Olot", "Peshku",
                "Qorako'l", "Qorovulbozor", "Shofirkon"
            ],
            Navoiy: ["Navoiy shahri", "Zarafshon shahri", "Karmana", "Xatirchi",
                "Qiziltepa", "Navbahor", "Tomdi", "Uchquduq"
            ],
            Qashqadaryo: ["Qarshi shahri", "Qarshi tumani", "Shahrisabz shahri",
                "Shahrisabz tumani", "Kitob", "Yakkabog'", "Chiroqchi",
                "Nishon", "Muborak", "Qamashi", "Koson", "Kasbi",
                "G'uzor", "Mirishkor"
            ],
            Surxandaryo: ["Termiz shahri", "Angor", "Boysun", "Denov", "Jarqo'rg'on",
                "Muzrabot", "Oltinsoy", "Qiziriq", "Qumqo'rg'on",
                "Sariosiyo", "Sherobod", "Sho'chi", "Termiz tumani", "Uzun"
            ],
            Xorazm: ["Urganch shahri", "Bog'ot", "Gurlan", "Hazorasp", "Xiva",
                "Qo'shko'pir", "Shovot", "Tuproqqal'a", "Urganch tumani",
                "Xonqa", "Yangibozor"
            ],
            Andijon: ["Andijon shahri", "Andijon tumani", "Asaka", "Baliqchi",
                "Bo'z", "Buloqboshi", "Izboskan", "Jalolquduq",
                "Xo'jaobod", "Qo'rg'ontepa", "Marhamat", "Oltinko'l",
                "Paxtaobod", "Shahrixon", "Ulug'nor", "Xonobod shahri"
            ],
            Namangan: ["Namangan shahri", "Chortoq", "Chust", "Kosonsoy", "Mingbuloq",
                "Norin", "Pop", "To'raqo'rg'on", "Uychi", "Yangiqo'rg'on",
                "Namangan tumani"
            ],
            "Farg'ona": ["Farg'ona shahri", "Qo'qon shahri", "Marg'ilan shahri",
                "Oltiariq", "O'zbekiston tumani", "Quva", "Rishton",
                "Toshloq", "Yozyovon", "Dang'ara", "Beshariq", "Bog'dod",
                "So'x", "Uchko'prik", "Furqat"
            ],
            "Qoraqalpog'iston": ["Nukus shahri", "Amudaryo", "Beruniy", "Chimboy",
                "Ellikqal'a", "Kegeyli", "Mo'ynoq", "Nukus tumani",
                "Qanliko'l", "Qo'ng'irot", "Qorao'zak", "Shumanay",
                "Taxtako'pir", "To'tko'l", "Xo'jayli", "Taxiatosh shahri"
            ]
        };

        const regionSelect = document.getElementById("region");
        const districtSelect = document.getElementById("district");

        // Viloyat tanlanganda tumanni yangilash
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
        
        // Get current location function
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        marker.setPosition(userLocation);
                        updateLocation(userLocation.lat, userLocation.lng);
                        showNotification('Joriy joylashuv topildi!', 'success');
                    },
                    () => {
                        showNotification('Joriy joylashuvni olish imkonsiz!', 'error');
                    }
                );
            } else {
                showNotification('Brauzeringiz geolocationni qo'llab-quvvatlamaydi!', 'error');
            }
        }
    </script>

    <script>
        let map, geocoder, marker;

        function initMap() {
            const defaultCenter = {
                lat: {{ $location[0] }},
                lng: {{ $location[1] }}
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultCenter,
                zoom: 12,
                styles: [
                    {
                        "featureType": "poi",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "off" }]
                    }
                ]
            });

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                position: defaultCenter,
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        marker.setPosition(userLocation);
                        updateLocation(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        updateLocation(defaultCenter.lat, defaultCenter.lng);
                    }
                );
            } else {
                updateLocation(defaultCenter.lat, defaultCenter.lng);
            }

            map.addListener("click", function(event) {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                marker.setPosition({ lat, lng });
                marker.setAnimation(google.maps.Animation.DROP);
                updateLocation(lat, lng);
            });

            marker.addListener("dragend", function(event) {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                updateLocation(lat, lng);
            });
        }

        function updateLocation(lat, lng) {
            const url = `${lat},${lng}`;

            geocoder.geocode({
                location: { lat, lng }
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const address = results[0].formatted_address;

                    document.getElementById("address").value = address;
                    document.getElementById("location").value = url;
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;

                    let regionSelect = document.getElementById("region");
                    let districtSelect = document.getElementById("district");

                    let components = results[0].address_components;

                    let region = components.find(c => c.types.includes("administrative_area_level_1"));
                    let district = components.find(c => c.types.includes("administrative_area_level_2"));

                    if (region) {
                        for (let option of regionSelect.options) {
                            if (option.value && region.long_name.includes(option.value)) {
                                option.selected = true;
                                // Trigger change to update districts
                                regionSelect.dispatchEvent(new Event('change'));
                                break;
                            }
                        }
                    }

                    if (district) {
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

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
    </script>

</x-layout>
