<x-layout>
    <x-slot:title>{{ __('course-create.title') }}</x-slot:title>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fade-out { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-10px); } }
        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-fade-in { animation: fade-in 0.3s ease-out; }
        .animate-fade-out { animation: fade-out 0.3s ease-out; }
        .animate-spin { animation: spin 1s linear infinite; }
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in, .animate-fade-out, .animate-spin, .transition-all { animation: none !important; transition: none !important; }
        }
    </style>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('course-create.header.title') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('course-create.header.description') }}
                </p>
            </div>

            <x-card class="mb-8">
                <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div id="error-alert" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 animate-fade-in">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">{{ __('course-create.error.title') }}</h4>
                                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" onclick="document.getElementById('error-alert').remove()" class="text-red-400 hover:text-red-600 transition-colors ml-4">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- ===== ASOSIY MA'LUMOTLAR ===== -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('course-create.basic_info.title') }}</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Logo Upload -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.basic_info.logo_label') }} {{ __('course-create.required') }}
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-blue-500 transition-all duration-300 cursor-pointer group hover:bg-blue-50/50 dark:hover:bg-blue-900/10"
                                    onclick="document.getElementById('logo').click()">
                                    <input type="file" name="logo" id="logo" class="hidden" accept="image/*" onchange="previewLogo(this)">
                                    <div class="relative inline-block">
                                        <div id="logo-preview" class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                            <svg class="w-10 h-10 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                                <circle cx="12" cy="13" r="3"/>
                                            </svg>
                                        </div>
                                        <button type="button" id="logo-remove-btn"
                                            class="hidden absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors shadow"
                                            onclick="event.stopPropagation(); removeLogo()">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-blue-600 transition-colors">
                                        {{ __('course-create.basic_info.logo_hint') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __('course-create.basic_info.logo_format') }}</p>
                                </div>
                                @error('logo')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.basic_info.name_label') }} {{ __('course-create.required') }}
                                </label>
                                <x-input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="{{ __('course-create.basic_info.name_placeholder') }}" required/>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.basic_info.type_label') }} {{ __('course-create.required') }}
                                </label>
                                <select name="type" id="type"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                    <option value="" disabled {{ !old('type') ? 'selected' : '' }}>{{ __('course-create.basic_info.type_placeholder') }}</option>
                                    <option value="O'quv markaz" {{ old('type') == "O'quv markaz" ? 'selected' : '' }}>{{ __('course-create.types.center') }}</option>
                                    <option value="Akademiya" {{ old('type') == 'Akademiya' ? 'selected' : '' }}>{{ __('course-create.types.academy') }}</option>
                                    <option value="Kollej" {{ old('type') == 'Kollej' ? 'selected' : '' }}>{{ __('course-create.types.college') }}</option>
                                    <option value="Universitet" {{ old('type') == 'Universitet' ? 'selected' : '' }}>{{ __('course-create.types.university') }}</option>
                                    <option value="Maktab" {{ old('type') == 'Maktab' ? 'selected' : '' }}>{{ __('course-create.types.school') }}</option>
                                    <option value="Maktab/Kurs" {{ old('type') == 'Maktab/Kurs' ? 'selected' : '' }}>{{ __('course-create.types.school_course') }}</option>
                                    <option value="Til kurslar" {{ old('type') == 'Til kurslar' ? 'selected' : '' }}>{{ __('course-create.types.language_course') }}</option>
                                    <option value="Haydovchilik kursi" {{ old('type') == 'Haydovchilik kursi' ? 'selected' : '' }}>{{ __('course-create.types.driving_course') }}</option>
                                    <option value="IT kurslar" {{ old('type') == 'IT kurslar' ? 'selected' : '' }}>{{ __('course-create.types.it_course') }}</option>
                                    <option value="Dizayn kurslar" {{ old('type') == 'Dizayn kurslar' ? 'selected' : '' }}>{{ __('course-create.types.design_course') }}</option>
                                    <option value="Musiqiy maktab" {{ old('type') == 'Musiqiy maktab' ? 'selected' : '' }}>{{ __('course-create.types.music_school') }}</option>
                                    <option value="Sport maktab" {{ old('type') == 'Sport maktab' ? 'selected' : '' }}>{{ __('course-create.types.sports_school') }}</option>
                                    <option value="Badiiy maktab" {{ old('type') == 'Badiiy maktab' ? 'selected' : '' }}>{{ __('course-create.types.art_school') }}</option>
                                    <option value="Kasb-hunar maktab" {{ old('type') == 'Kasb-hunar maktab' ? 'selected' : '' }}>{{ __('course-create.types.vocational_school') }}</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- About -->
                            <div class="lg:col-span-2">
                                <label for="about" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.basic_info.about_label') }} {{ __('course-create.required') }}
                                </label>
                                <div class="relative">
                                    <textarea name="about" id="about" rows="4" maxlength="500"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="{{ __('course-create.basic_info.about_placeholder') }}">{{ old('about') }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                        <span id="about-char-count">{{ strlen(old('about') ?? '') }}</span>/500
                                    </div>
                                </div>
                                @error('about')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- ===== MARKAZ RASMLARI ===== -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('course-create.images.title') }}</h3>
                        </div>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-purple-500 transition-colors cursor-pointer"
                            onclick="document.getElementById('images').click()">
                            <input type="file" name="images[]" id="images" class="hidden" accept="image/*" multiple onchange="previewImages(this)">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('course-create.images.hint') }}</p>
                        </div>
                        <div id="images-preview" class="mt-4"></div>
                        @error('images.*')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ===== MANZIL MA'LUMOTLARI ===== -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('course-create.location.title') }}</h3>
                        </div>

                        <!-- Map -->
                        <div class="relative mb-4">
                            <div class="h-80 bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden shadow-inner">
                                <div id="map" class="w-full h-full"></div>
                            </div>
                            <!-- Current location button -->
                            <div class="absolute top-3 right-3 z-10">
                                <button type="button" onclick="getCurrentLocation()"
                                    class="flex items-center gap-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-lg shadow-lg text-sm font-medium transition-colors border border-gray-200 dark:border-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ __('course-create.location.current_location') }}
                                </button>
                            </div>
                        </div>

                        <!-- Hint -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-6">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    {{ __('course-create.location.hint') }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Province -->
                            <div>
                                <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.location.province_label') }} {{ __('course-create.required') }}
                                </label>
                                <select name="province" id="region"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                    <option value="" disabled {{ !old('province') ? 'selected' : '' }}>{{ __('course-create.location.province_placeholder') }}</option>
                                    @foreach(["Toshkent","Sirdaryo","Jizzax","Samarqand","Buxoro","Navoiy","Qashqadaryo","Surxandaryo","Xorazm","Andijon","Namangan","Farg'ona","Qoraqalpog'iston"] as $p)
                                        <option value="{{ $p }}" {{ old('province') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.location.district_label') }} {{ __('course-create.required') }}
                                </label>
                                <select name="region" id="district"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                    <option value="" disabled selected>{{ __('course-create.location.district_placeholder') }}</option>
                                    @if(old('region'))
                                        <option value="{{ old('region') }}" selected>{{ old('region') }}</option>
                                    @endif
                                </select>
                                @error('region')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.location.address_label') }} {{ __('course-create.required') }}
                                </label>
                                <x-input type="text" name="address" id="address" value="{{ old('address') }}"
                                    placeholder="{{ __('course-create.location.address_placeholder') }}" required/>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Hidden fields — controller merge qiladi location = latitude,longitude --}}
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>

                    <!-- ===== O'QUVCHILAR SONI ===== -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('course-create.students.title') }}</h3>
                        </div>
                        <div>
                            <label for="studentCount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('course-create.students.label') }}
                            </label>
                            <x-input type="number" name="student_count" id="studentCount"
                                value="{{ old('student_count') }}" placeholder="{{ __('course-create.students.placeholder') }}" min="0"/>
                            @error('student_count')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('index') }}"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('course-create.buttons.back') }}
                        </a>
                        <button type="submit" id="submit-btn"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 hover:from-blue-700 hover:via-cyan-700 hover:to-teal-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg id="submit-icon" class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span id="submit-text">{{ __('course-create.buttons.save') }}</span>
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    <script>
        // ===== LOGO PREVIEW =====
        function previewLogo(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            if (file.size > 1024 * 1024) {
                showNotification('{{ __('course-create.error.file_size') }}', 'error');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('logo-preview').innerHTML =
                    `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Logo">`;
                document.getElementById('logo-remove-btn').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeLogo() {
            document.getElementById('logo').value = '';
            document.getElementById('logo-preview').innerHTML = `
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                    <circle cx="12" cy="13" r="3"/>
                </svg>`;
            document.getElementById('logo-remove-btn').classList.add('hidden');
        }

        // ===== IMAGES PREVIEW =====
        function previewImages(input) {
            const container = document.getElementById('images-preview');
            if (!input.files || !input.files.length) { container.innerHTML = ''; return; }
            container.innerHTML = '<div class="grid grid-cols-2 md:grid-cols-4 gap-3">' +
                Array.from(input.files).map((f, i) =>
                    `<div><img id="imgp-${i}" class="w-full h-28 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                     <p class="text-xs text-gray-500 mt-1 truncate text-center">${f.name}</p></div>`
                ).join('') + '</div>';
            Array.from(input.files).forEach((f, i) => {
                const r = new FileReader();
                r.onload = e => { const el = document.getElementById(`imgp-${i}`); if (el) el.src = e.target.result; };
                r.readAsDataURL(f);
            });
        }

        // ===== CHARACTER COUNT =====
        document.getElementById('about').addEventListener('input', function() {
            const el = document.getElementById('about-char-count');
            el.textContent = this.value.length;
            el.classList.toggle('text-orange-500', this.value.length > 450);
        });

        // ===== DISTRICTS =====
        const districtsByRegion = {
            "Toshkent": ["Bekobod","Bo'ka","Chinoz","Oqqo'rg'on","Ohangaron","Piskent","Quyichirchiq","Yuqorichirchiq","Zangiota","Toshkent tumani","Parkent"],
            "Sirdaryo": ["Guliston","Boyovut","Sardoba","Mirzaobod","Hovos","Oqoltin","Sayxunobod","Sirdaryo tumani"],
            "Jizzax": ["Jizzax shahri","Arnasoy","Baxmal","Do'stlik","Forish","G'llaorol","Sharof Rashidov","Paxtakor","Zomin","Yangiobod","Mirzacho'l","Gagarin"],
            "Samarqand": ["Samarqand shahri","Bulung'ur","Jomboy","Ishtixon","Kattaqo'rg'on","Narpay","Oqdaryo","Pastdarg'om","Payariq","Qo'shrabot","Samarqand tumani","Tayloq","Urgut","Chelak","Ziyodin","Kattaqo'rg'on shahri"],
            "Buxoro": ["Buxoro shahri","Buxoro tumani","G'ijduvon","Jondor","Kogon shahri","Kogon tumani","Olot","Peshku","Qorako'l","Qorovulbozor","Shofirkon"],
            "Navoiy": ["Navoiy shahri","Zarafshon shahri","Karmana","Xatirchi","Qiziltepa","Navbahor","Tomdi","Uchquduq"],
            "Qashqadaryo": ["Qarshi shahri","Qarshi tumani","Shahrisabz shahri","Shahrisabz tumani","Kitob","Yakkabog'","Chiroqchi","Nishon","Muborak","Qamashi","Koson","Kasbi","G'uzor","Mirishkor"],
            "Surxandaryo": ["Termiz shahri","Angor","Boysun","Denov","Jarqo'rg'on","Muzrabot","Oltinsoy","Qiziriq","Qumqo'rg'on","Sariosiyo","Sherobod","Sho'rchi","Termiz tumani","Uzun"],
            "Xorazm": ["Urganch shahri","Bog'ot","Gurlan","Hazorasp","Xiva","Qo'shko'pir","Shovot","Tuproqqal'a","Urganch tumani","Xonqa","Yangibozor"],
            "Andijon": ["Andijon shahri","Andijon tumani","Asaka","Baliqchi","Bo'z","Buloqboshi","Izboskan","Jalolquduq","Xo'jaobod","Qo'rg'ontepa","Marhamat","Oltinko'l","Paxtaobod","Shahrixon","Ulug'nor","Xonobod shahri"],
            "Namangan": ["Namangan shahri","Chortoq","Chust","Kosonsoy","Mingbuloq","Norin","Pop","To'raqo'rg'on","Uychi","Yangiqo'rg'on","Namangan tumani"],
            "Farg'ona": ["Farg'ona shahri","Qo'qon shahri","Marg'ilon shahri","Oltiariq","O'zbekiston tumani","Quva","Rishton","Toshloq","Yozyovon","Dang'ara","Beshariq","Bog'dod","So'x","Uchko'prik","Furqat"],
            "Qoraqalpog'iston": ["Nukus shahri","Amudaryo","Beruniy","Chimboy","Ellikqal'a","Kegeyli","Mo'ynoq","Nukus tumani","Qanliko'l","Qo'ng'irot","Qorao'zak","Shumanay","Taxtako'pir","To'tko'l","Xo'jayli","Taxiatosh shahri"]
        };

        document.getElementById('region').addEventListener('change', function() {
            const ds = document.getElementById('district');
            ds.innerHTML = '<option value="" disabled selected>Tumanni tanlang...</option>';
            (districtsByRegion[this.value] || []).forEach(d => {
                const o = document.createElement('option'); o.value = d; o.textContent = d; ds.appendChild(o);
            });
        });

        // Restore old district after validation error
        @if(old('province') && old('region'))
        window.addEventListener('DOMContentLoaded', function() {
            const oldProv = @json(old('province'));
            const oldDist = @json(old('region'));
            const ds = document.getElementById('district');
            ds.innerHTML = '<option value="" disabled>Tumanni tanlang...</option>';
            (districtsByRegion[oldProv] || []).forEach(d => {
                const o = document.createElement('option'); o.value = d; o.textContent = d;
                if (d === oldDist) o.selected = true;
                ds.appendChild(o);
            });
        });
        @endif

        // ===== SUBMIT LOADING =====
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            document.getElementById('submit-text').textContent = '{{ __('course-create.buttons.saving') }}';
            document.getElementById('submit-icon').innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>';
            document.getElementById('submit-icon').classList.add('animate-spin');
        });

        // ===== NOTIFICATION =====
        function showNotification(message, type = 'info') {
            const colors = { error: 'bg-red-500', success: 'bg-green-500', info: 'bg-blue-500' };
            const n = document.createElement('div');
            n.className = `fixed top-4 right-4 ${colors[type] || colors.info} text-white px-5 py-3 rounded-lg shadow-xl z-50 animate-fade-in flex items-center gap-2 text-sm font-medium`;
            n.textContent = message;
            document.body.appendChild(n);
            setTimeout(() => { n.classList.add('animate-fade-out'); setTimeout(() => n.remove(), 300); }, 3000);
        }

        // ===== MAP =====
        let map, marker, geocoder;
        const DEFAULT_LAT = 39.6542; // Samarqand
        const DEFAULT_LNG = 66.9757;

        function initMap() {
            const center = { lat: DEFAULT_LAT, lng: DEFAULT_LNG };

            map = new google.maps.Map(document.getElementById('map'), {
                center,
                zoom: 12,
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true,
                styles: [{ featureType: 'poi', elementType: 'labels', stylers: [{ visibility: 'off' }] }]
            });

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map,
                position: center,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: "{{ __('course-create.map.marker_title') }}"
            });

            // Auto-detect current location on load
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        const loc = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                        map.setCenter(loc);
                        map.setZoom(15);
                        marker.setPosition(loc);
                        reverseGeocode(loc.lat, loc.lng);
                        showNotification('{{ __('course-create.error.location_found') }}', 'success');
                    },
                    () => {
                        // Silently fallback to Samarqand
                        reverseGeocode(DEFAULT_LAT, DEFAULT_LNG);
                    },
                    { timeout: 8000 }
                );
            } else {
                reverseGeocode(DEFAULT_LAT, DEFAULT_LNG);
            }

            // Map click
            map.addListener('click', function(e) {
                marker.setPosition(e.latLng);
                marker.setAnimation(google.maps.Animation.DROP);
                reverseGeocode(e.latLng.lat(), e.latLng.lng());
            });

            // Marker drag
            marker.addListener('dragend', function(e) {
                reverseGeocode(e.latLng.lat(), e.latLng.lng());
            });
        }

        // Manual "Joriy joylashuv" button
        function getCurrentLocation() {
            if (!navigator.geolocation) {
                showNotification('{{ __('course-create.error.location_not_supported') }}', 'error');
                return;
            }
            showNotification('{{ __('course-create.error.location_detecting') }}', 'info');
            navigator.geolocation.getCurrentPosition(
                pos => {
                    const loc = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                    map.setCenter(loc);
                    map.setZoom(15);
                    marker.setPosition(loc);
                    marker.setAnimation(google.maps.Animation.DROP);
                    reverseGeocode(loc.lat, loc.lng);
                    showNotification('{{ __('course-create.error.location_found') }}', 'success');
                },
                () => showNotification('{{ __('course-create.error.location_failed') }}', 'error'),
                { timeout: 10000 }
            );
        }

        // Reverse geocode + fill form fields
        // Controller `store()` ichida: $location = $request->latitude . ',' . $request->longitude;
        // Shuning uchun bu yerda faqat latitude va longitude hidden fieldlarini to'ldiramiz
        function reverseGeocode(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                if (status !== 'OK' || !results[0]) return;

                document.getElementById('address').value = results[0].formatted_address;

                const comps = results[0].address_components;
                const regionComp   = comps.find(c => c.types.includes('administrative_area_level_1'));
                const districtComp = comps.find(c => c.types.includes('administrative_area_level_2'));

                const regionSel = document.getElementById('region');
                if (regionComp) {
                    for (const opt of regionSel.options) {
                        if (opt.value && regionComp.long_name.includes(opt.value)) {
                            opt.selected = true;
                            regionSel.dispatchEvent(new Event('change'));
                            break;
                        }
                    }
                }

                if (districtComp) {
                    setTimeout(() => {
                        for (const opt of document.getElementById('district').options) {
                            if (opt.value && districtComp.long_name.includes(opt.value)) {
                                opt.selected = true;
                                break;
                            }
                        }
                    }, 150);
                }
            });
        }

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer></script>
</x-layout>