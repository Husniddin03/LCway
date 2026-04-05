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
                        {{ __('course-edit.header.title', ['name' => $center->name]) }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('course-edit.header.description') }}</p>
            </div>

            <x-card class="mb-8">
                <form action="{{ route('course.update', $center->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                                            @if($center->logo)
                                                @if(str_starts_with($center->logo, 'http'))
                                                    <img src="{{ $center->logo }}" class="w-full h-full object-cover" alt="Logo">
                                                @else
                                                    <img src="{{ asset('storage/' . $center->logo) }}" class="w-full h-full object-cover" alt="Logo">
                                                @endif
                                            @else
                                                <svg class="w-10 h-10 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                                    <circle cx="12" cy="13" r="3"/>
                                                </svg>
                                            @endif
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
                                    {{ __('course-edit.basic_info.name_label') }} {{ __('course-edit.required') }}
                                </label>
                                <x-input type="text" name="name" id="name" value="{{ $center->name }}"
                                    placeholder="{{ __('course-edit.basic_info.name_placeholder') }}" required/>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-edit.basic_info.type_label') }} {{ __('course-edit.required') }}
                                </label>
                                <select name="type" id="type"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required onchange="toggleCustomType(this.value)">
                                    <option value="" disabled {{ !old('type', $center->type) ? 'selected' : '' }}>{{ __('course-edit.basic_info.type_placeholder') }}</option>
                                    
                                    @if($types->isNotEmpty())
                                        <!-- Types from database -->
                                        @foreach($types as $type)
                                            <option value="{{ $type }}" {{ $center->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                        
                                        <!-- Separator -->
                                        <option value="" disabled>──────────</option>
                                    @endif
                                    
                                    <!-- Custom option -->
                                    <option value="custom">📝 Boshqa (qo'lda yozing)</option>
                                </select>
                                
                                <!-- Custom Type Input -->
                                <div id="customTypeDiv" class="mt-3 hidden">
                                    <input type="text" name="custom_type" id="custom_type" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="O'quv markaz turingizni kiriting..."
                                        value="{{ old('custom_type') ?? $center->type }}">
                                </div>
                                
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                                @error('custom_type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <script>
                                function toggleCustomType(value) {
                                    const customDiv = document.getElementById('customTypeDiv');
                                    const customInput = document.getElementById('custom_type');
                                    const typeSelect = document.getElementById('type');
                                    
                                    if (value === 'custom') {
                                        customDiv.classList.remove('hidden');
                                        customInput.required = true;
                                        typeSelect.required = false;
                                    } else {
                                        customDiv.classList.add('hidden');
                                        customInput.required = false;
                                        customInput.value = '';
                                        typeSelect.required = true;
                                    }
                                }
                                
                                function toggleCustomCountry(value) {
                                    const customDiv = document.getElementById('customCountryDiv');
                                    const customInput = document.getElementById('custom_country');
                                    const countrySelect = document.getElementById('country');
                                    
                                    if (value === 'custom') {
                                        customDiv.classList.remove('hidden');
                                        customInput.required = true;
                                        countrySelect.required = false;
                                    } else {
                                        customDiv.classList.add('hidden');
                                        customInput.required = false;
                                        customInput.value = '';
                                        countrySelect.required = true;
                                    }
                                }
                                
                                function toggleCustomProvince(value) {
                                    const customDiv = document.getElementById('customProvinceDiv');
                                    const customInput = document.getElementById('custom_province');
                                    const provinceSelect = document.getElementById('region');
                                    const districtContainer = document.getElementById('district').parentElement;
                                    const districtSelect = document.getElementById('district');
                                    
                                    if (value === 'custom') {
                                        customDiv.classList.remove('hidden');
                                        customInput.required = true;
                                        provinceSelect.required = false;
                                        
                                        // Auto-select custom district when custom province is selected
                                        districtContainer.style.display = 'block';
                                        districtSelect.value = 'custom';
                                        toggleCustomDistrict('custom');
                                    } else if (value === '') {
                                        // Hide district when no province is selected
                                        districtContainer.style.display = 'none';
                                        districtSelect.value = '';
                                        toggleCustomDistrict('');
                                    } else {
                                        customDiv.classList.add('hidden');
                                        customInput.required = false;
                                        customInput.value = '';
                                        provinceSelect.required = true;
                                        
                                        // Show district and reset to default when province is selected
                                        districtContainer.style.display = 'block';
                                        districtSelect.value = '';
                                        toggleCustomDistrict('');
                                    }
                                }
                                
                                function toggleCustomDistrict(value) {
                                    const customDiv = document.getElementById('customDistrictDiv');
                                    const customInput = document.getElementById('custom_district');
                                    const districtSelect = document.getElementById('district');
                                    
                                    if (value === 'custom') {
                                        customDiv.classList.remove('hidden');
                                        customInput.required = true;
                                        districtSelect.required = false;
                                    } else {
                                        customDiv.classList.add('hidden');
                                        customInput.required = false;
                                        customInput.value = '';
                                        districtSelect.required = true;
                                    }
                                }
                                
                                // Check on page load if custom was selected
                                document.addEventListener('DOMContentLoaded', function() {
                                    const typeSelect = document.getElementById('type');
                                    if (typeSelect.value === 'custom') {
                                        toggleCustomType('custom');
                                    }
                                    
                                    const countrySelect = document.getElementById('country');
                                    if (countrySelect.value === 'custom') {
                                        toggleCustomCountry('custom');
                                    }
                                    
                                    const provinceSelect = document.getElementById('region');
                                    if (provinceSelect.value === 'custom') {
                                        toggleCustomProvince('custom');
                                    } else if (provinceSelect.value === '') {
                                        // Hide district if no province is selected on page load
                                        const districtContainer = document.getElementById('district').parentElement;
                                        districtContainer.style.display = 'none';
                                    }
                                    
                                    const districtSelect = document.getElementById('district');
                                    if (districtSelect.value === 'custom') {
                                        toggleCustomDistrict('custom');
                                    }
                                    
                                    // Check if current values are not in database/hardcoded lists
                                    @php
                                        $types = \App\Models\LearningCenter::pluck('type')->filter()->unique()->sort()->values();
                                        $countries = \App\Models\LearningCenter::pluck('country')->filter()->unique()->sort()->values();
                                    @endphp
                                    
                                    // If current type is not in database types, show custom input
                                    const currentType = @json($center->type);
                                    const typesInDb = @json($types->toArray());
                                    if (currentType && !typesInDb.includes(currentType)) {
                                        const typeSelect = document.getElementById('type');
                                        typeSelect.value = 'custom';
                                        toggleCustomType('custom');
                                        const customTypeInput = document.getElementById('custom_type');
                                        if (customTypeInput) {
                                            customTypeInput.value = currentType;
                                        }
                                    }
                                    
                                    // If current country is not in database countries, show custom input
                                    const currentCountry = @json($center->country);
                                    const countriesInDb = @json($countries->toArray());
                                    if (currentCountry && !countriesInDb.includes(currentCountry)) {
                                        const countrySelect = document.getElementById('country');
                                        countrySelect.value = 'custom';
                                        toggleCustomCountry('custom');
                                        const customCountryInput = document.getElementById('custom_country');
                                        if (customCountryInput) {
                                            customCountryInput.value = currentCountry;
                                        }
                                    }
                                    
                                    // If current province is not in the hardcoded list, show custom input
                                    const hardcodedProvinces = ["Toshkent","Sirdaryo","Jizzax","Samarqand","Buxoro","Navoiy","Qashqadaryo","Surxandaryo","Xorazm","Andijon","Namangan","Farg'ona","Qoraqalpog'iston"];
                                    const currentProvince = @json($center->province);
                                    if (currentProvince && !hardcodedProvinces.includes(currentProvince)) {
                                        const provinceSelect = document.getElementById('region');
                                        provinceSelect.value = 'custom';
                                        toggleCustomProvince('custom');
                                        const customProvinceInput = document.getElementById('custom_province');
                                        if (customProvinceInput) {
                                            customProvinceInput.value = currentProvince;
                                        }
                                    }
                                    
                                    // If current district is not in districtsByRegion, show custom input
                                    const currentRegion = @json($center->region);
                                    if (currentRegion && currentProvince) {
                                        const districtsForProvince = districtsByRegion[currentProvince] || [];
                                        if (!districtsForProvince.includes(currentRegion)) {
                                            const districtSelect = document.getElementById('district');
                                            districtSelect.value = 'custom';
                                            toggleCustomDistrict('custom');
                                            const customDistrictInput = document.getElementById('custom_district');
                                            if (customDistrictInput) {
                                                customDistrictInput.value = currentRegion;
                                            }
                                        }
                                    }
                                });
                            </script>

                            <!-- About -->
                            <div class="lg:col-span-2">
                                <label for="about" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-edit.basic_info.about_label') }} {{ __('course-edit.required') }}
                                </label>
                                <div class="relative">
                                    <textarea name="about" id="about" rows="4" maxlength="500"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="{{ __('course-edit.basic_info.about_placeholder') }}">{{ $center->about }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                        <span id="about-char-count">{{ strlen(old('about', $center->about) ?? '') }}</span>/500
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

                        {{-- Hidden fields — controller merge qiladi location = latitude,longitude --}}
                        @php
                            $existingLat = 39.6542; // Default fallback
                            $existingLng = 66.9757; // Default fallback
                            
                            if ($center->location) {
                                $coords = explode(',', $center->location);
                                if (count($coords) == 2) {
                                    $existingLat = floatval($coords[0]);
                                    $existingLng = floatval($coords[1]);
                                }
                            }
                        @endphp

                        <!-- Search and Map Container -->
                        <div class="relative mb-4" id="map-wrapper">
                            <!-- Search Bar -->
                            <div class="absolute top-3 left-20 right-20 z-[1000]">
                                <div class="relative flex items-center">
                                    <svg class="absolute left-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input type="text" id="map-search" 
                                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent !bg-white !text-gray-900"
                                        placeholder="Shahar, ko'cha yoki mo'ljalni kiriting..."
                                        onkeydown="if(event.key==='Enter'){event.preventDefault();searchLocation();}">
                                </div>
                                <!-- Search Results Dropdown -->
                                <div id="search-results" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-gray-200 max-h-48 overflow-y-auto hidden z-[1001]"></div>
                            </div>
                            
                            <!-- Current location button - bottom right -->
                            <div class="absolute bottom-3 right-3 z-[1000]">
                                <button type="button" onclick="getCurrentLocation()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 border-2 border-white"
                                    title="Mening joylashuvim">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Loading Overlay -->
                            <div id="map-loading" class="absolute inset-0 bg-white/80 rounded-xl z-20 hidden flex items-center justify-center">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Yuklanmoqda...</span>
                                </div>
                            </div>

                            <!-- Map -->
                            <div class="h-80 rounded-xl overflow-hidden shadow-inner border border-gray-200">
                                <div id="map" class="w-full h-full"></div>
                            </div>
                            
                            <!-- Coordinates Display -->
                            <div class="absolute bottom-3 left-3 z-10 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 text-xs text-gray-600 border border-gray-200">
                                <span id="coords-display">{{ $existingLat }}, {{ $existingLng }}</span>
                            </div>
                        </div>

                        <!-- Dynamic Address Display -->
                        <div id="address-display" class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 hidden">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-green-800">Tanlangan manzil:</p>
                                    <p id="selected-address-text" class="text-sm text-green-700 mt-1">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Davlat {{ __('course-create.required') }}
                                </label>
                                <select name="country" id="country"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required onchange="toggleCustomCountry(this.value)">
                                    <option value="" disabled {{ !old('country') ? 'selected' : '' }}>Davlatni tanlang</option>
                                    
                                    @php
                                        $countries = \App\Models\LearningCenter::pluck('country')->filter()->unique()->sort()->values();
                                    @endphp
                                    
                                    @if($countries->isNotEmpty())
                                        <!-- Countries from database -->
                                        @foreach($countries as $country)
                                            <option value="{{ $country }}" {{ $center->country == $country ? 'selected' : '' }}>{{ $country }}</option>
                                        @endforeach
                                        
                                        <!-- Separator -->
                                        <option value="" disabled>──────────</option>
                                    @endif
                                    
                                    <!-- Custom option -->
                                    <option value="custom">📝 Boshqa davlat (qo'lda yozing)</option>
                                </select>
                                
                                <!-- Custom Country Input -->
                                <div id="customCountryDiv" class="mt-3 hidden">
                                    <input type="text" name="custom_country" id="custom_country" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Davlat nomini kiriting..."
                                        value="{{ old('custom_country') ?? $center->country }}">
                                </div>
                                
                                @error('country')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                                @error('custom_country')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div>
                                <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.location.province_label') }} {{ __('course-create.required') }}
                                </label>
                                <select name="province" id="region"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required onchange="toggleCustomProvince(this.value)">
                                    <option value="" disabled {{ !old('province') ? 'selected' : '' }}>{{ __('course-create.location.province_placeholder') }}</option>
                                    @foreach(["Toshkent","Sirdaryo","Jizzax","Samarqand","Buxoro","Navoiy","Qashqadaryo","Surxandaryo","Xorazm","Andijon","Namangan","Farg'ona","Qoraqalpog'iston"] as $p)
                                        <option value="{{ $p }}" {{ $center->province == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                    <option value="custom">📝 Boshqa viloyat (qo'lda yozing)</option>
                                </select>
                                
                                <!-- Custom Province Input -->
                                <div id="customProvinceDiv" class="mt-3 hidden">
                                    <input type="text" name="custom_province" id="custom_province" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Viloyat nomini kiriting..."
                                        value="{{ old('custom_province') ?? $center->province }}">
                                </div>
                                
                                @error('province')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                                @error('custom_province')
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
                                    required onchange="toggleCustomDistrict(this.value)">
                                    <option value="" disabled selected>{{ __('course-create.location.district_placeholder') }}</option>
                                    @if(old('region'))
                                        <option value="{{ $center->region }}" selected>{{ $center->region }}</option>
                                    @endif
                                    <option value="custom">📝 Boshqa tuman (qo'lda yozing)</option>
                                </select>
                                
                                <!-- Custom District Input -->
                                <div id="customDistrictDiv" class="mt-3 hidden">
                                    <input type="text" name="custom_district" id="custom_district" 
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Tuman/Shahar nomini kiriting..."
                                        value="{{ old('custom_district') ?? $center->region }}">
                                </div>
                                
                                @error('region')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                                @error('custom_district')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('course-create.location.address_label') }} {{ __('course-create.required') }}
                                </label>
                                <x-input type="text" name="address" id="address" value="{{ $center->address }}"
                                    placeholder="{{ __('course-create.location.address_placeholder') }}" required/>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Hidden fields — controller merge qiladi location = latitude,longitude --}}
                        <input type="hidden" id="latitude" name="latitude" value="{{ $existingLat }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ $existingLng }}">
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
                                value="{{ $center->student_count }}" placeholder="{{ __('course-edit.students.placeholder') }}" min="0"/>
                            @error('student_count')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('blog-single', $center->id) }}"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('course-edit.buttons.back') }}
                        </a>
                        <button type="submit" id="submit-btn"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 hover:from-blue-700 hover:via-cyan-700 hover:to-teal-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                            <svg id="submit-icon" class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span id="submit-text">{{ __('course-edit.buttons.save') }}</span>
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
        let map, marker;
        const DEFAULT_LAT = {{ $existingLat }};
        const DEFAULT_LNG = {{ $existingLng }};
        let searchTimeout;

        function initMap() {
            const center = [DEFAULT_LAT, DEFAULT_LNG];

            // Initialize Leaflet map
            map = L.map('map', {
                zoomControl: false,
                attributionControl: true
            }).setView(center, 13);

            // Add zoom control to bottom left
            L.control.zoom({
                position: 'bottomleft'
            }).addTo(map);

            // Add fullscreen control - pastki o'ng burchak
            const fullscreenControl = L.Control.extend({
                options: {
                    position: 'bottomleft'
                },
                onAdd: function() {
                    const container = L.DomUtil.create('a', 'leaflet-control-fullscreen');
                    container.href = '#';
                    container.title = "To'liq ekran";
                    container.style.cssText = 'width:34px;height:34px;display:flex;align-items:center;justify-content:center;background:white;border-radius:4px;box-shadow:0 2px 5px rgba(0,0,0,0.3);text-decoration:none;margin-bottom:16px;margin-right:10px;z-index:1002;';
                    container.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>';
                    
                    L.DomEvent.on(container, 'click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        L.DomEvent.preventDefault(e);
                        
                        const mapContainer = document.getElementById('map');
                        if (!document.fullscreenElement) {
                            if (mapContainer.requestFullscreen) {
                                mapContainer.requestFullscreen().catch(err => {
                                    showNotification('To\'liq ekran rejimi yoqilmadi', 'error');
                                });
                            } else if (mapContainer.webkitRequestFullscreen) {
                                mapContainer.webkitRequestFullscreen();
                            } else if (mapContainer.msRequestFullscreen) {
                                mapContainer.msRequestFullscreen();
                            }
                        } else {
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            } else if (document.webkitExitFullscreen) {
                                document.webkitExitFullscreen();
                            } else if (document.msExitFullscreen) {
                                document.msExitFullscreen();
                            }
                        }
                    });
                    
                    return container;
                }
            });
            
            map.addControl(new fullscreenControl());

            // Add OpenStreetMap tiles - ALWAYS light mode
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                minZoom: 3
            }).addTo(map);

            // Create modern marker with pulse effect
            const customIcon = L.divIcon({
                html: `
                    <div class="marker-pulse"></div>
                    <div class="marker-pin">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <style>
                        .marker-pulse {
                            position: absolute;
                            width: 40px;
                            height: 40px;
                            background: rgba(59, 130, 246, 0.4);
                            border-radius: 50%;
                            animation: pulse 2s ease-out infinite;
                            transform: translate(-50%, -50%);
                            left: 50%;
                            top: 50%;
                        }
                        @keyframes pulse {
                            0% { transform: translate(-50%, -50%) scale(0.5); opacity: 1; }
                            100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
                        }
                        .marker-pin {
                            position: absolute;
                            width: 32px;
                            height: 32px;
                            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                            border-radius: 50% 50% 50% 0;
                            border: 3px solid white;
                            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
                            transform: rotate(-45deg);
                            left: 50%;
                            top: 50%;
                            margin-left: -16px;
                            margin-top: -28px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 2;
                        }
                        .marker-pin svg {
                            transform: rotate(45deg);
                        }
                    </style>
                `,
                iconSize: [40, 48],
                iconAnchor: [20, 40],
                className: 'custom-marker-container'
            });

            // Add marker
            marker = L.marker(center, {
                icon: customIcon,
                draggable: true,
                title: "O'quv markaz joylashuvi"
            }).addTo(map);

            // Show existing location (don't auto-detect on edit page to preserve user's saved location)
            updateCoordinates(DEFAULT_LAT, DEFAULT_LNG);

            // Map click
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng.lat, e.latlng.lng);
            });

            // Marker drag
            marker.on('dragend', function(e) {
                const position = e.target.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });

            // Map move end - update coords display
            map.on('moveend', function() {
                const center = map.getCenter();
                document.getElementById('coords-display').textContent = 
                    `${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}`;
            });
        }

        // Search location using Nominatim
        async function searchLocation() {
            const query = document.getElementById('map-search').value.trim();
            if (!query) {
                showNotification('Qidirish uchun matn kiriting', 'error');
                return;
            }

            showMapLoading(true);
            
            try {
                // Add Uzbekistan bias to search
                const searchUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Uzbekistan')}&limit=5&countrycodes=uz`;
                
                const response = await fetch(searchUrl);
                const data = await response.json();

                showMapLoading(false);

                if (data && data.length > 0) {
                    if (data.length === 1) {
                        // Single result - move map directly
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lon = parseFloat(result.lon);
                        
                        map.setView([lat, lon], 16);
                        marker.setLatLng([lat, lon]);
                        updateCoordinates(lat, lon);
                        
                        document.getElementById('map-search').value = result.display_name.split(',')[0];
                        showNotification('Joylashuv topildi!', 'success');
                    } else {
                        // Multiple results - show dropdown
                        showSearchResults(data);
                    }
                } else {
                    // Try without Uzbekistan bias
                    const searchUrlGlobal = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`;
                    const responseGlobal = await fetch(searchUrlGlobal);
                    const dataGlobal = await responseGlobal.json();
                    
                    showMapLoading(false);
                    
                    if (dataGlobal && dataGlobal.length > 0) {
                        showSearchResults(dataGlobal);
                    } else {
                        showNotification('Joylashuv topilmadi. Boshqa so\'z bilan urinib ko\'ring.', 'error');
                    }
                }
            } catch (error) {
                showMapLoading(false);
                console.error('Search error:', error);
                showNotification('Qidirishda xatolik yuz berdi', 'error');
            }
        }

        // Show search results dropdown
        function showSearchResults(results) {
            const dropdown = document.getElementById('search-results');
            dropdown.innerHTML = '';
            
            results.forEach((result, index) => {
                const item = document.createElement('div');
                item.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-b-0 transition-colors';
                item.innerHTML = `
                    <div class="font-medium text-sm text-gray-900 dark:text-white">${result.display_name.split(',')[0]}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">${result.display_name}</div>
                `;
                item.onclick = () => {
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);
                    
                    map.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);
                    updateCoordinates(lat, lon);
                    
                    document.getElementById('map-search').value = result.display_name.split(',')[0];
                    dropdown.classList.add('hidden');
                    showNotification('Joylashuv tanlandi!', 'success');
                };
                dropdown.appendChild(item);
            });
            
            dropdown.classList.remove('hidden');
            
            // Close dropdown when clicking outside
            setTimeout(() => {
                document.addEventListener('click', closeSearchResults, { once: true });
            }, 100);
        }

        function closeSearchResults(e) {
            if (!e.target.closest('#search-results') && !e.target.closest('#map-search')) {
                document.getElementById('search-results').classList.add('hidden');
            }
        }

        // Get current location
        function getCurrentLocation() {
            if (!navigator.geolocation) {
                showNotification('Brauzer geolokatsiyani qo\'llab-quvvatlamaydi', 'error');
                return;
            }

            showMapLoading(true);
            
            navigator.geolocation.getCurrentPosition(
                pos => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateCoordinates(lat, lng);
                    
                    showMapLoading(false);
                    showNotification('Sizning joriy joylashuvingiz!', 'success');
                },
                err => {
                    showMapLoading(false);
                    console.error('Geolocation error:', err);
                    
                    let message = 'Joylashuvni aniqlash mumkin emas';
                    if (err.code === 1) message = 'Geolokatsiya ruxsati berilmagan';
                    else if (err.code === 2) message = 'Joylashuv aniqlanmadi';
                    else if (err.code === 3) message = 'Joylashuv aniqlash vaqti tugadi';
                    
                    showNotification(message, 'error');
                },
                { timeout: 10000, enableHighAccuracy: true, maximumAge: 60000 }
            );
        }

        // Show/hide loading overlay
        function showMapLoading(show) {
            const loading = document.getElementById('map-loading');
            if (show) {
                loading.classList.remove('hidden');
            } else {
                loading.classList.add('hidden');
            }
        }

        // Update coordinate fields and address
        async function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('coords-display').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            
            // Show loading state in address field
            const addressInput = document.getElementById('address');
            addressInput.placeholder = 'Manzil aniqlanmoqda...';
            addressInput.classList.add('bg-blue-50');
            
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=uz`);
                const data = await response.json();
                
                if (data && data.display_name) {
                    addressInput.value = data.display_name;
                    addressInput.classList.remove('bg-blue-50');
                    
                    // Show dynamic address display
                    const addressDisplay = document.getElementById('address-display');
                    const selectedAddressText = document.getElementById('selected-address-text');
                    addressDisplay.classList.remove('hidden');
                    selectedAddressText.textContent = data.display_name;
                    
                    // Try to update region and district based on address
                    const address = data.address;
                    if (address) {
                        const regionSel = document.getElementById('region');
                        const districtSel = document.getElementById('district');
                        
                        // Update region - check multiple possible fields
                        const stateName = address.state || address.region || address.province;
                        if (stateName && regionSel) {
                            for (const opt of regionSel.options) {
                                if (opt.value && stateName.toLowerCase().includes(opt.value.toLowerCase())) {
                                    opt.selected = true;
                                    regionSel.dispatchEvent(new Event('change'));
                                    break;
                                }
                            }
                        }
                        
                        // Update district - check multiple possible fields
                        const district = address.city || address.town || address.village || address.district || address.county || address.municipality;
                        if (district && districtSel) {
                            setTimeout(() => {
                                for (const opt of districtSel.options) {
                                    if (opt.value && (district.toLowerCase().includes(opt.value.toLowerCase()) || opt.value.toLowerCase().includes(district.toLowerCase()))) {
                                        opt.selected = true;
                                        break;
                                    }
                                }
                            }, 200);
                        }
                    }
                }
            } catch (error) {
                console.error('Reverse geocoding error:', error);
                addressInput.placeholder = 'Manzilni qo\'lda kiriting';
                addressInput.classList.remove('bg-blue-50');
            }
        }


        window.initMap = initMap;
        
        // Initialize map when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof initMap === 'function') {
                initMap();
            }
        });
    </script>

</x-layout>