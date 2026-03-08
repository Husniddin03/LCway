<x-layout>
    <x-slot:title>Barcha o'quv markazlar</x-slot:title>

    <!-- Hero Section -->
    <section
        class="text-gray-900 dark:text-white bg-gradient-to-br from-primary-800 via-accent-800 to-primary-900 dark:from-primary-700 dark:via-accent-700 dark:to-primary-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">O'quv markazlar</h1>
                <p class="text-xl text-gray-900 dark:text-white text-white/90 max-w-2xl mx-auto">
                    O'zbekiston bo'ylab eng yaxshi o'quv markazlarini toping va o'zingizga mos kurslarni tanlang
                </p>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Search Bar -->
            <div class="mb-6">
                <form id="searchForm" class="relative">
                    @foreach ($validated as $key => $value)
                        @if ($key !== 'searchText')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                        @endif
                    @endforeach
                    <div class="relative max-w-2xl mx-auto">
                        <input type="text" name="searchText" id="searchText" placeholder="O'quv markazini qidiring..."
                            value="{{ $validated['searchText'] ?? '' }}"
                            class="w-full px-6 py-4 pr-12 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                        <button type="submit" id="searchBtn"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            <svg id="searchIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <svg id="loadingIcon" class="w-5 h-5 hidden animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter Navigation -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="clearAllFilters()"
                        class="text-gray-900 dark:text-white px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        Barchasi
                    </button>

                    <!-- Filter by maps -->


                    {{-- ========== COMPONENT ========== --}}
                    <div class="relative" x-data="mapFilterComp()" x-init="boot()">

                        {{-- Trigger --}}
                        <button type="button" class="mf-btn" :class="open && 'is-open'" @click="toggle()">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Xarita bo'yicha
                            <svg class="mf-chevron" width="13" height="13" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Panel --}}
                        <div class="mf-panel" x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 -translate-y-2 scale-95" @click.outside="open = false"
                            style="display:none;">

                            {{-- Header --}}
                            <div class="mf-header">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="mf-hicon">
                                        <svg width="16" height="16" fill="none" stroke="#fff"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="mf-htitle">Xarita orqali qidirish</div>
                                        <div class="mf-hsub">Joylashuvingizni belgilang va radius kiriting</div>
                                    </div>
                                </div>
                                <button type="button" class="mf-close-btn" @click="open = false">
                                    <svg width="18" height="18" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Map area --}}
                            <div class="mf-map-wrap">
                                <div id="filterMapEl"></div>

                                {{-- Loading placeholder --}}
                                <div class="mf-placeholder" x-show="!mapReady">
                                    <svg width="36" height="36" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24" style="opacity:.4;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 20l-5.447-9.132A1 1 0 013.382 9.5h17.236a1 1 0 01.838 1.368L16 20M9 20h6M9 20V9m6 11V9" />
                                    </svg>
                                    <span>Xarita yuklanmoqda...</span>
                                </div>

                                {{-- Locate button --}}
                                <button type="button" class="mf-locate-btn" @click.stop="locateMe()">
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24"
                                        :style="locating ? 'animation:spin 1s linear infinite' : ''">
                                        <circle cx="12" cy="12" r="3" />
                                        <path d="M12 2v3m0 14v3M2 12h3m14 0h3" />
                                    </svg>
                                    <span x-text="locating ? 'Aniqlanmoqda...' : 'Mening joylashuvim'"></span>
                                </button>

                                <div class="mf-map-hint">🖱 Xaritaga bosing yoki markerni sudrang</div>
                            </div>

                            {{-- Controls --}}
                            <div class="mf-controls">

                                {{-- Location info --}}
                                <div class="mf-loc-box">
                                    <div class="mf-loc-dot"></div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="mf-loc-label">Tanlangan joylashuv</div>
                                        <div class="mf-loc-text" x-text="addressText"></div>
                                        <div class="mf-loc-coords" x-show="lat && lng">
                                            <span x-text="lat ? lat.toFixed(5) : ''"></span>,
                                            <span x-text="lng ? lng.toFixed(5) : ''"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Radius row --}}
                                <div class="mf-radius-row">
                                    <div class="mf-radius-lbl">
                                        <svg width="13" height="13" fill="none" stroke="#6366f1"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        Qidiruv radiusi
                                    </div>
                                    <div class="mf-radius-badge" x-text="radius + ' km'"></div>
                                </div>

                                <input type="range" min="1" max="50" step="1"
                                    x-model.number="radius" @input="onRadiusChange()" class="mf-slider"
                                    :style="`background:linear-gradient(to right,#4f46e5 0%,#4f46e5 ${(radius-1)/49*100}%,${darkMode?'#374151':'#e5e7eb'} ${(radius-1)/49*100}%,${darkMode?'#374151':'#e5e7eb'} 100%)`">

                                <div class="mf-slider-marks">
                                    <span>1 km</span><span>25 km</span><span>50 km</span>
                                </div>

                                <div class="mf-quick">
                                    <template x-for="r in [2,5,10,20]" :key="r">
                                        <button type="button" class="mf-qbtn"
                                            :class="radius == r ? 'mf-qbtn-on' : 'mf-qbtn-off'"
                                            @click="radius = r; onRadiusChange()" x-text="r + ' km'">
                                        </button>
                                    </template>
                                </div>

                                {{-- Hidden form inputs --}}
                                <input type="hidden" name="latitude" :value="lat">
                                <input type="hidden" name="longitude" :value="lng">
                                <input type="hidden" name="radius" :value="radius">

                                {{-- Actions --}}
                                <div class="mf-actions">
                                    <button type="button" class="mf-reset-btn"
                                        @click="resetFilter()">Tozalash</button>
                                    <button type="button" class="mf-apply-btn" @click="applyFilter()">
                                        <svg width="14" height="14" fill="none" stroke="currentColor"
                                            stroke-width="2.5" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8" />
                                            <path stroke-linecap="round" d="m21 21-4.35-4.35" />
                                        </svg>
                                        Qidirish
                                    </button>
                                </div>

                                <div class="mf-result" x-show="resultShown">
                                    <strong x-text="resultCount"></strong> ta markaz topildi
                                    (<span x-text="radius"></span> km radiusda)
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Sort Dropdown -->
                    <div class="text-gray-900 dark:text-white relative" x-data="{ sortDropdown: false }">
                        <button @click="sortDropdown = !sortDropdown"
                            class="text-gray-900 dark:text-white px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center gap-2">
                            Saralash
                            <svg class="w-4 h-4" :class="{ 'rotate-180': sortDropdown }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="sortDropdown" @click.away="sortDropdown = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10">
                            <div class="py-2">
                                @if (!isset($validated['name']))
                                    <button type="button" onclick="applySorting('name', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Nomi ↑↓
                                    </button>
                                @elseif ($validated['name'] == 'asc')
                                    <button type="button" onclick="applySorting('name', 'desc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Nomi ↑
                                    </button>
                                @elseif ($validated['name'] == 'desc')
                                    <button type="button" onclick="applySorting('name', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Nomi ↓
                                    </button>
                                @else
                                    <button type="button" onclick="applySorting('name', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Nomi ↑↓
                                    </button>
                                @endif

                                @if (!isset($validated['distance']))
                                    <button type="button" onclick="applySorting('distance', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Masofasi ↑↓
                                    </button>
                                @elseif ($validated['distance'] == 'asc')
                                    <button type="button" onclick="applySorting('distance', 'desc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Masofasi ↑
                                    </button>
                                @elseif ($validated['distance'] == 'desc')
                                    <button type="button" onclick="applySorting('distance', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Masofasi ↓
                                    </button>
                                @else
                                    <button type="button" onclick="applySorting('distance', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Masofasi ↑↓
                                    </button>
                                @endif

                                @if (!isset($validated['favorites']))
                                    <button type="button" onclick="applySorting('favorites', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Reytingi ↑↓
                                    </button>
                                @elseif ($validated['favorites'] == 'asc')
                                    <button type="button" onclick="applySorting('favorites', 'desc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Reytingi ↑
                                    </button>
                                @elseif ($validated['favorites'] == 'desc')
                                    <button type="button" onclick="applySorting('favorites', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Reytingi ↓
                                    </button>
                                @else
                                    <button type="button" onclick="applySorting('favorites', 'asc')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:border-1 hover:rounded-md">
                                        Reytingi ↑↓
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Filter by subjects -->
                    <div class="text-gray-900 dark:text-white relative" x-data="{ teacherDropdown: false }">
                        <button @click="teacherDropdown = !teacherDropdown"
                            class="text-gray-900 dark:text-white px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center gap-2">
                            Fanlar bo'yicha
                            <svg class="w-4 h-4" :class="{ 'rotate-180': teacherDropdown }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="teacherDropdown" @click.away="teacherDropdown = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10">
                            <div class="py-2 max-h-70 overflow-y-auto">
                                @foreach ($subjects as $subject)
                                    <button type="button" onclick="applyFilter('subject_id', '{{ $subject->id }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:border-1 hover:rounded-md">
                                        {{ $subject->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Announcements Dropdown -->
                    <div class="text-gray-900 dark:text-white relative" x-data="{ teacherDropdown: false }">
                        <button @click="teacherDropdown = !teacherDropdown"
                            class="text-gray-900 dark:text-white px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center gap-2">
                            O'qituvchi e'lonlari
                            <svg class="w-4 h-4" :class="{ 'rotate-180': teacherDropdown }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="teacherDropdown" @click.away="teacherDropdown = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10">
                            <div class="py-2 max-h-70 overflow-y-auto">
                                @foreach ($subjects as $subject)
                                    <button type="button" onclick="applyFilter('needTeachers', '{{ $subject->id }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:border-1 hover:rounded-md">
                                        {{ $subject->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-gray-600 dark:text-gray-400">
                    <span id="resultsCount">{{ $LearningCenters->count() }}</span> ta o'quv markaz topildi
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Centers Grid -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div id="loadingIndicator" class="hidden text-center py-8">
                <svg class="w-8 h-8 animate-spin mx-auto text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Qidiryapman...</p>
            </div>
            <div id="centersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($LearningCenters as $LearningCenter)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $LearningCenter->logo) }}"
                                alt="{{ $LearningCenter->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                class="absolute bottom-4 left-4 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                Ko'proq o'qish
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta Information -->
                            <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $LearningCenter->region . ', ' . $LearningCenter->province }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $LearningCenter->created_at->diffForHumans() }}</span>
                                </div>
                                @if (isset($LearningCenter->distance))
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <span>{{ $LearningCenter->distance }} km</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Rating -->
                            @php
                                $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                            @endphp
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $average - $i;
                                        @endphp
                                        <span
                                            class="text-lg {{ $average >= $i ? 'text-yellow-400' : ($diff > -1 && $diff < 0 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600') }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                                <span
                                    class="text-lg font-semibold text-primary-600 dark:text-primary-400">{{ $average }}</span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}"
                                    class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                                    {{ $LearningCenter->name }}
                                </a>
                            </h3>

                            <!-- Teacher Announcements -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div
                                        class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">E'lon</h4>
                                </div>

                                @if ($LearningCenter->needTeachers->count() > 0)
                                    <div class="space-y-2">
                                        <p class="text-sm font-medium text-success-600 dark:text-success-400">
                                            O'qituvchi kerak</p>
                                        @foreach ($LearningCenter->needTeachers as $teacher)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-700 dark:text-gray-300">🟢
                                                    {{ $teacher->subject->name }}</span>
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $teacher->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hozicha e'lon berilmagan!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sorting buttons based on current URL
    updateSortingButtons();
});
</script>

<!-- AJAX JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form handler
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    // Initialize current filters
    window.currentFilters = new URLSearchParams(window.location.search);
});

function handleSearch(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const searchBtn = document.getElementById('searchBtn');
    const searchIcon = document.getElementById('searchIcon');
    const loadingIcon = document.getElementById('loadingIcon');
    
    // Update URL parameters
    window.currentFilters.set('searchText', formData.get('searchText'));
    
    // Show loading state
    searchBtn.disabled = true;
    searchIcon.classList.add('hidden');
    loadingIcon.classList.remove('hidden');
    
    // Perform AJAX search
    performSearch();
}

function clearAllFilters() {
    window.currentFilters = new URLSearchParams();
    performSearch();
}

function applyFilter(type, value) {
    if (value) {
        window.currentFilters.set(type, value);
    } else {
        window.currentFilters.delete(type);
    }
    performSearch();
}

function applySorting(sortType, direction) {
    // Clear all existing sort parameters
    window.currentFilters.delete('name');
    window.currentFilters.delete('distance');
    window.currentFilters.delete('favorites');
    window.currentFilters.delete('sort');
    
    // Set the new sort type and direction
    window.currentFilters.set(sortType, direction);
    window.currentFilters.set('sort', sortType);
    performSearch();
}

function updateSortingButtons() {
    const urlParams = new URLSearchParams(window.location.search);
    const sortType = urlParams.get('sort');
    const sortDirection = urlParams.get(sortType);
    
    // Update name sorting button
    const nameButton = document.querySelector('[onclick*="applySorting(\'name\'"]');
    if (nameButton) {
        if (sortType === 'name' && sortDirection === 'asc') {
            nameButton.setAttribute('onclick', "applySorting('name', 'desc')");
            nameButton.innerHTML = 'Nomi ↑';
        } else if (sortType === 'name' && sortDirection === 'desc') {
            nameButton.setAttribute('onclick', "applySorting('name', 'asc')");
            nameButton.innerHTML = 'Nomi ↓';
        } else {
            nameButton.setAttribute('onclick', "applySorting('name', 'asc')");
            nameButton.innerHTML = 'Nomi ↑↓';
        }
    }
    
    // Update distance sorting button
    const distanceButton = document.querySelector('[onclick*="applySorting(\'distance\'"]');
    if (distanceButton) {
        if (sortType === 'distance' && sortDirection === 'asc') {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'desc')");
            distanceButton.innerHTML = 'Masofasi ↑';
        } else if (sortType === 'distance' && sortDirection === 'desc') {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'asc')");
            distanceButton.innerHTML = 'Masofasi ↓';
        } else {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'asc')");
            distanceButton.innerHTML = 'Masofasi ↑↓';
        }
    }
    
    // Update favorites sorting button
    const favoritesButton = document.querySelector('[onclick*="applySorting(\'favorites\'"]');
    if (favoritesButton) {
        if (sortType === 'favorites' && sortDirection === 'asc') {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'desc')");
            favoritesButton.innerHTML = 'Reytingi ↑';
        } else if (sortType === 'favorites' && sortDirection === 'desc') {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'asc')");
            favoritesButton.innerHTML = 'Reytingi ↓';
        } else {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'asc')");
            favoritesButton.innerHTML = 'Reytingi ↑↓';
        }
    }
}

function performSearch() {
    const loadingIndicator = document.getElementById('loadingIndicator');
    const centersGrid = document.getElementById('centersGrid');
    const resultsCount = document.getElementById('resultsCount');
    
    // Show loading
    loadingIndicator.classList.remove('hidden');
    centersGrid.classList.add('hidden');
    
    // Build URL
    const url = window.location.pathname + '?' + window.currentFilters.toString();
    
    // Update browser URL without reload
    history.pushState(null, '', url);
    
    // Perform AJAX request
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update results count
            resultsCount.textContent = data.count;
            
            // Update centers grid
            centersGrid.innerHTML = data.html;
            
            // Update sorting buttons based on current URL
            updateSortingButtons();
            
            // Reinitialize map component if needed
            if (typeof window.mapFilterComp === 'function') {
                // Update centers data for map
                if (data.centers) {
                    updateMapCenters(data.centers);
                }
            }
        } else {
            // Show error
            centersGrid.innerHTML = '<div class="col-span-full text-center py-8 text-red-600">Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.</div>';
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        centersGrid.innerHTML = '<div class="col-span-full text-center py-8 text-red-600">Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.</div>';
    })
    .finally(() => {
        // Hide loading and reset button
        loadingIndicator.classList.add('hidden');
        centersGrid.classList.remove('hidden');
        
        const searchBtn = document.getElementById('searchBtn');
        const searchIcon = document.getElementById('searchIcon');
        const loadingIcon = document.getElementById('loadingIcon');
        
        if (searchBtn) {
            searchBtn.disabled = false;
            searchIcon.classList.remove('hidden');
            loadingIcon.classList.add('hidden');
        }
        
        // Close all dropdowns after AJAX request
        closeAllDropdowns();
    });
}

function updateMapCenters(centers) {
    // Update global centers data for map component
    if (typeof _CENTERS !== 'undefined') {
        _CENTERS = centers.map(function(center) {
            const coords = (center.location || '').split(',');
            return {
                id: center.id,
                name: center.name,
                latitude: parseFloat(coords[0] || 0),
                longitude: parseFloat(coords[1] || 0),
                address: center.address || '',
            };
        });
    }
}

function closeAllDropdowns() {
    // Close all dropdown panels by clicking outside or setting their display to none
    const dropdownPanels = document.querySelectorAll('[x-show]');
    dropdownPanels.forEach(function(panel) {
        // Check if this panel is currently shown
        const xShowAttr = panel.getAttribute('x-show');
        if (xShowAttr) {
            // Try to evaluate the expression to see if it's true
            try {
                const context = panel.closest('[x-data]');
                if (context && window.Alpine) {
                    // Force the expression to be false by updating the underlying data
                    if (xShowAttr === 'sortDropdown') {
                        window.Alpine.evaluate(context, 'sortDropdown = false');
                    } else if (xShowAttr === 'teacherDropdown') {
                        window.Alpine.evaluate(context, 'teacherDropdown = false');
                    } else if (xShowAttr === 'open') {
                        window.Alpine.evaluate(context, 'open = false');
                    }
                }
            } catch (e) {
                // Fallback: hide the panel directly
                panel.style.display = 'none';
            }
        }
    });
    
    // Alternative approach: click outside to trigger @click.away
    document.body.click();
}

// Handle browser back/forward buttons
window.addEventListener('popstate', function() {
    window.currentFilters = new URLSearchParams(window.location.search);
    performSearch();
});
</script>

<style>
    /* Rating Stars */
    .star {
        transition: color 0.2s ease;
    }

    /* Map Container */
    #map-container.hidden {
        display: none;
    }

    #map-container.show {
        display: block;
    }

    /* Search Results */
    .search-result-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s;
    }

    .search-result-item:hover {
        background-color: #f3f4f6;
    }

    .dark .search-result-item {
        border-bottom-color: #374151;
    }

    .dark .search-result-item:hover {
        background-color: #374151;
    }

    /* Base styles remain the same */
    .favorite {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
    }

    .favorite .stars {
        display: flex;
        justify-content: center;
        gap: 5px;
        font-size: 40px;
        cursor: pointer;
        position: relative;
    }

    .favorite .star {
        color: #ddd;
        transition: color 0.2s ease;
        user-select: none;
        position: relative;
    }

    .favorite .star.full {
        color: #ffc107;
    }

    .favorite .star.half {
        background: linear-gradient(90deg, #ffc107 50%, #ddd 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .favorite .result {
        font-size: 18px;
        color: #667eea;
        font-weight: bold;
        min-height: 30px;
    }

    .standard-img {
        aspect-ratio: 4 / 3;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    /* Navigation Links - Responsive */
    .nav-links {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        list-style: none;
        padding: 0;
        flex-wrap: wrap;
        align-items: center;
    }

    .nav-links-li:hover {
        color: blue;
    }

    /* Map Container - Responsive */
    #map-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
        position: relative;
    }

    #map-container.active {
        max-height: 700px;
        margin-top: 10px;
    }

    #map {
        width: 100%;
        height: 400px;
        border-radius: 10px;
    }

    /* Map Form - Desktop */
    .map-form {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 320px;
        z-index: 1000;
        max-height: 90vh;
        overflow-y: auto;
    }

    .map-form input,
    .map-form select,
    .map-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .map-form button {
        background-color: #4285f4;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .map-form button:hover {
        background-color: #3367d6;
    }

    /* Search Box - Responsive */
    .search-box {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 300px;
        z-index: 1000;
        max-width: calc(100vw - 360px);
    }

    .search-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .search-results {
        max-height: 250px;
        overflow-y: auto;
        margin-top: 8px;
        display: none;
        background: white;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .result-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .result-item:hover {
        background: #f5f5f5;
    }

    /* Locate Button */
    .locate-btn {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: white;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        z-index: 1000;
    }

    .locate-btn:hover {
        background: #f5f5f5;
    }

    /* Toggle Button */
    .toggle-btn {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 1001;
        font-weight: 500;
        border: none;
        font-size: 14px;
    }

    /* Learning Centers Grid - Responsive */
    .learning-centers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .learning-center-card {
        width: 100%;
        max-width: none;
    }

    /* Card Meta - Responsive */
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Announcement Header */
    .announcement-header {
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
    }

    /* Dropdown Menus - Responsive */
    .dropdown-container {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        z-index: 1000;
    }

    /* Info Window Content */
    .info-content {
        padding: 10px;
        max-width: 250px;
    }

    .info-content img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .info-title {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: bold;
    }

    .info-distance {
        margin: 0 0 5px 0;
        font-size: 13px;
        color: #1976d2;
        font-weight: 500;
    }

    .info-address {
        margin: 0 0 10px 0;
        font-size: 12px;
        color: #666;
    }

    .info-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #4285f4;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 5px;
    }

    .info-btn:hover {
        background-color: #3367d6;
    }

    /* Scrollbar styling */
    .search-results::-webkit-scrollbar,
    .map-form::-webkit-scrollbar {
        width: 6px;
    }

    .search-results::-webkit-scrollbar-thumb,
    .map-form::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {

        /* Navigation */
        .nav-links {
            overflow-x: auto;
            white-space: nowrap;
            gap: 15px;
            padding-bottom: 10px;
        }

        .nav-links li {
            flex-shrink: 0;
        }

        /* Map Container Mobile */
        #map-container.active {
            max-height: 80vh;
        }

        #map {
            height: 300px;
        }

        /* Map Form Mobile */
        .map-form {
            position: relative;
            top: 0;
            right: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin: 10px 0;
            box-sizing: border-box;
        }

        /* Search Box Mobile */
        .search-box {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        /* Toggle Button Mobile */
        .toggle-btn {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            margin-bottom: 10px;
        }

        /* Locate Button Mobile */
        .locate-btn {
            right: 15px;
            bottom: 15px;
            width: 50px;
            height: 50px;
            font-size: 22px;
        }

        /* Learning Centers Grid Mobile */
        .learning-centers-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        /* Card Meta Mobile */
        .card-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .meta-item {
            width: 100%;
            justify-content: flex-start;
        }

        .meta-item p {
            font-size: 14px;
        }

        /* Stars Mobile */
        .favorite {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .favorite .stars {
            font-size: 32px;
            gap: 3px;
        }

        .favorite .result {
            font-size: 20px;
        }

        /* Dropdown Mobile */
        .dropdown-menu {
            position: fixed;
            top: auto;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            max-height: 50vh;
            overflow-y: auto;
            border-radius: 8px 8px 0 0;
        }

        /* Announcement Header Mobile */
        .announcement-header {
            flex-direction: row;
            align-items: center;
        }

        .announcement-header img {
            width: 1.5rem !important;
            height: 1.5rem !important;
            margin-right: 1rem !important;
        }
    }

    /* TABLET RESPONSIVE STYLES */
    @media (max-width: 1024px) and (min-width: 769px) {

        /* Learning Centers Grid Tablet */
        .learning-centers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        /* Map Form Tablet */
        .map-form {
            width: 280px;
        }

        /* Search Box Tablet */
        .search-box {
            width: 250px;
            max-width: calc(100vw - 320px);
        }

        /* Navigation Tablet */
        .nav-links {
            gap: 18px;
        }
    }

    /* LARGE DESKTOP STYLES */
    @media (min-width: 1200px) {
        .learning-centers-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .map-form {
            width: 350px;
        }

        .search-box {
            width: 320px;
        }
    }

    /* EXTRA LARGE DESKTOP STYLES */
    @media (min-width: 1400px) {
        .learning-centers-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* SMALL MOBILE STYLES */
    @media (max-width: 480px) {
        .nav-links {
            gap: 10px;
            font-size: 14px;
        }

        .favorite .stars {
            font-size: 28px;
        }

        .favorite .result {
            font-size: 18px;
        }

        .meta-item p {
            font-size: 13px;
        }

        #map {
            height: 250px;
        }

        .map-form {
            padding: 10px;
        }

        .search-box {
            padding: 8px;
        }
    }
</style>



{{--
    ============================================================
    Xarita bo'yicha filter — Map Filter Component
    - Google Maps API kaliti: env('MAP_API_KEY')
    - Default: Samarqand (39.6542, 66.9597)
    - Light/Dark mode + Mobile responsive
    - Alpine.js x-data component
    ============================================================
--}}

{{-- ========== STYLES ========== --}}
<style>
    /* ---- TRIGGER BUTTON ---- */
    .mf-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        white-space: nowrap;
        transition: all .25s ease;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(99, 102, 241, .35);
    }

    .mf-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, .48);
    }

    .mf-btn:active {
        transform: translateY(0);
    }

    .mf-chevron {
        transition: transform .25s;
    }

    .mf-btn.is-open .mf-chevron {
        transform: rotate(180deg);
    }

    /* ---- PANEL ---- */
    .mf-panel {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        width: 500px;
        max-width: calc(100vw - 20px);
        border-radius: 20px;
        overflow: hidden;
        z-index: 9999;
        /* Light */
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .18), 0 0 0 1px rgba(0, 0, 0, .04);
    }

    .dark .mf-panel {
        background: #111827;
        border-color: rgba(255, 255, 255, .08);
        box-shadow: 0 20px 60px rgba(0, 0, 0, .55);
    }

    /* ---- HEADER ---- */
    .mf-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: linear-gradient(135deg, #f5f6ff 0%, #eff0ff 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    .dark .mf-header {
        background: linear-gradient(135deg, #1a1d2e 0%, #1e2140 100%);
        border-bottom-color: rgba(255, 255, 255, .07);
    }

    .mf-hicon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mf-htitle {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .dark .mf-htitle {
        color: #f9fafb;
    }

    .mf-hsub {
        font-size: 11px;
        color: #6b7280;
        margin-top: 1px;
    }

    .dark .mf-hsub {
        color: rgba(255, 255, 255, .45);
    }

    .mf-close-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        padding: 4px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .15s, color .15s;
    }

    .mf-close-btn:hover {
        background: rgba(0, 0, 0, .06);
        color: #374151;
    }

    .dark .mf-close-btn:hover {
        background: rgba(255, 255, 255, .1);
        color: #f9fafb;
    }

    /* ---- MAP AREA ---- */
    .mf-map-wrap {
        position: relative;
        height: 265px;
    }

    #filterMapEl {
        width: 100%;
        height: 100%;
    }

    .mf-placeholder {
        position: absolute;
        inset: 0;
        z-index: 5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #9ca3af;
        font-size: 13px;
        background: #f3f4f6;
    }

    .dark .mf-placeholder {
        background: #1f2937;
    }

    .mf-locate-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: all .2s;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, .92);
        color: #374151;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .18);
    }

    .dark .mf-locate-btn {
        background: rgba(17, 24, 39, .88);
        color: #f3f4f6;
    }

    .mf-locate-btn:hover {
        background: #4f46e5;
        color: #fff;
        box-shadow: 0 4px 14px rgba(99, 102, 241, .4);
    }

    .mf-map-hint {
        position: absolute;
        bottom: 8px;
        left: 8px;
        z-index: 10;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 11px;
        background: rgba(0, 0, 0, .55);
        color: rgba(255, 255, 255, .8);
        backdrop-filter: blur(4px);
        pointer-events: none;
    }

    /* ---- CONTROLS ---- */
    .mf-controls {
        padding: 16px 18px;
        background: #fff;
    }

    .dark .mf-controls {
        background: #111827;
    }

    .mf-loc-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        margin-bottom: 14px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
    }

    .dark .mf-loc-box {
        background: rgba(255, 255, 255, .04);
        border-color: rgba(255, 255, 255, .08);
    }

    .mf-loc-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .2);
        flex-shrink: 0;
        margin-top: 4px;
    }

    .mf-loc-label {
        font-size: 10px;
        font-weight: 600;
        color: #9ca3af;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .mf-loc-text {
        font-size: 13px;
        color: #374151;
        line-height: 1.4;
    }

    .dark .mf-loc-text {
        color: #e5e7eb;
    }

    .mf-loc-coords {
        font-size: 10px;
        color: #9ca3af;
        margin-top: 2px;
        font-family: monospace;
    }

    .mf-radius-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .mf-radius-lbl {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dark .mf-radius-lbl {
        color: #d1d5db;
    }

    .mf-radius-badge {
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        background: rgba(99, 102, 241, .12);
        color: #4f46e5;
        border: 1px solid rgba(99, 102, 241, .25);
    }

    .dark .mf-radius-badge {
        color: #818cf8;
        background: rgba(99, 102, 241, .18);
    }

    .mf-slider {
        width: 100%;
        height: 5px;
        border-radius: 999px;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        outline: none;
        border: none;
    }

    .mf-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
        border: 2.5px solid #fff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, .3), 0 2px 6px rgba(0, 0, 0, .2);
    }

    .mf-slider-marks {
        display: flex;
        justify-content: space-between;
        font-size: 10px;
        color: #9ca3af;
        margin-top: 4px;
        padding: 0 2px;
    }

    .mf-quick {
        display: flex;
        gap: 6px;
        margin-top: 8px;
    }

    .mf-qbtn {
        flex: 1;
        padding: 6px 0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all .15s;
    }

    .mf-qbtn-off {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .dark .mf-qbtn-off {
        background: rgba(255, 255, 255, .06);
        color: #9ca3af;
        border-color: rgba(255, 255, 255, .08);
    }

    .mf-qbtn-off:hover {
        background: rgba(99, 102, 241, .1);
        color: #4f46e5;
        border-color: rgba(99, 102, 241, .3);
    }

    .dark .mf-qbtn-off:hover {
        background: rgba(99, 102, 241, .15);
        color: #818cf8;
    }

    .mf-qbtn-on {
        background: rgba(99, 102, 241, .15);
        color: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .dark .mf-qbtn-on {
        color: #818cf8;
        border-color: #6366f1;
        background: rgba(99, 102, 241, .2);
    }

    .mf-actions {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }

    .mf-reset-btn {
        padding: 10px 18px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all .2s;
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .dark .mf-reset-btn {
        background: rgba(255, 255, 255, .06);
        color: #9ca3af;
        border-color: rgba(255, 255, 255, .08);
    }

    .mf-reset-btn:hover {
        background: #fee2e2;
        color: #ef4444;
        border-color: #fca5a5;
    }

    .dark .mf-reset-btn:hover {
        background: rgba(239, 68, 68, .12);
        color: #f87171;
        border-color: rgba(239, 68, 68, .3);
    }

    .mf-apply-btn {
        flex: 1;
        padding: 10px 20px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        border: none;
        transition: all .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        box-shadow: 0 4px 12px rgba(99, 102, 241, .35);
    }

    .mf-apply-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(99, 102, 241, .5);
    }

    .mf-apply-btn:active {
        transform: translateY(0);
    }

    cle .mf-result {
        text-align: center;
        margin-top: 8px;
        font-size: 12px;
        color: #9ca3af;
    }

    .mf-result strong {
        color: #4f46e5;
    }

    .dark .mf-result strong {
        color: #818cf8;
    }

    /* ---- MOBILE ---- */
    @media (max-width: 540px) {
        .mf-panel {
            position: fixed !important;
            top: auto !important;
            left: 0 !important;
            right: 0;
            bottom: 0;
            width: 100%;
            max-width: 100%;
            border-radius: 20px 20px 0 0;
            max-height: 88vh;
            overflow-y: auto;
        }

        .mf-map-wrap {
            height: 220px;
        }
    }
</style>


<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

{{-- ========== ALPINE JS COMPONENT ========== --}}
<script>
    (function() {
        /* --------------------------------------------------
           Centers data from Laravel
        -------------------------------------------------- */
        var _CENTERS = {!! json_encode(
            $LearningCenters->map(function ($center) {
                $coords = explode(',', $center->location ?? '');
                return [
                    'id' => $center->id,
                    'name' => $center->name,
                    'latitude' => (float) ($coords[0] ?? 0),
                    'longitude' => (float) ($coords[1] ?? 0),
                    'address' => $center->address ?? '',
                ];
            }),
        ) !!};

        var DEFAULT_LAT = 39.6542; // Samarqand
        var DEFAULT_LNG = 66.9597;

        window.mapFilterComp = function() {
            return {
                /* public state */
                open: false,
                mapReady: false,
                locating: false,
                resultShown: false,
                resultCount: 0,
                lat: null,
                lng: null,
                radius: 5,
                darkMode: false,
                addressText: 'Xaritadan joy tanlang yoki "Mening joylashuvim" tugmasini bosing',

                /* private */
                _map: null,
                _uMark: null,
                _circle: null,
                _iws: [],
                _geo: null,

                /* ---------- boot ---------- */
                boot() {
                    /* detect dark mode */
                    this.darkMode = document.documentElement.classList.contains('dark');

                    /* read URL params */
                    var p = new URLSearchParams(window.location.search);
                    if (p.get('latitude')) this.lat = parseFloat(p.get('latitude'));
                    if (p.get('longitude')) this.lng = parseFloat(p.get('longitude'));
                    if (p.get('radius')) this.radius = parseFloat(p.get('radius'));

                    /* register GLOBAL callback that Google Maps SDK calls */
                    window.__mfInitMap = () => {
                        if (this.open) this._initMap();
                    };

                    /* if SDK already present, bind immediately */
                    if (window.google && window.google.maps) {
                        // no-op; _initMap() called when panel opens
                    }

                    /* observe dark-mode toggle */
                    new MutationObserver(() => {
                        this.darkMode = document.documentElement.classList.contains('dark');
                    }).observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['class']
                    });
                },

                /* ---------- toggle panel ---------- */
                toggle() {
                    this.open = !this.open;
                    if (this.open) {
                        this.$nextTick(() => setTimeout(() => this._initMap(), 150));
                    }
                },

                /* ---------- init map ---------- */
                _initMap() {
                    if (this._map) {
                        google.maps.event.trigger(this._map, 'resize');
                        return;
                    }
                    if (!window.google || !window.google.maps) return;

                    var el = document.getElementById('filterMapEl');
                    if (!el) return;

                    var center = {
                        lat: this.lat || DEFAULT_LAT,
                        lng: this.lng || DEFAULT_LNG,
                    };

                    var darkStyles = [{
                            elementType: 'geometry',
                            stylers: [{
                                color: '#1a1d2e'
                            }]
                        },
                        {
                            elementType: 'labels.text.fill',
                            stylers: [{
                                color: '#8ec3b9'
                            }]
                        },
                        {
                            elementType: 'labels.text.stroke',
                            stylers: [{
                                color: '#1a1d2e'
                            }]
                        },
                        {
                            featureType: 'road',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#2c2f45'
                            }]
                        },
                        {
                            featureType: 'road.highway',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#3c3f5e'
                            }]
                        },
                        {
                            featureType: 'water',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#17263c'
                            }]
                        },
                        {
                            featureType: 'poi',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#2c2d3a'
                            }]
                        },
                        {
                            featureType: 'poi.park',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#263c3f'
                            }]
                        },
                        {
                            featureType: 'administrative',
                            elementType: 'geometry',
                            stylers: [{
                                color: '#4a4e6a'
                            }]
                        },
                    ];

                    this._map = new google.maps.Map(el, {
                        center: center,
                        zoom: 13,
                        gestureHandling: 'greedy',
                        mapTypeControl: false,
                        streetViewControl: false,
                        fullscreenControl: false,
                        zoomControl: true,
                        styles: this.darkMode ? darkStyles : [],
                    });

                    this._geo = new google.maps.Geocoder();

                    /* User marker (blue circle) */
                    this._uMark = new google.maps.Marker({
                        map: this._map,
                        position: center,
                        draggable: true,
                        zIndex: 999,
                        title: 'Sizning joylashuvingiz',
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 10,
                            fillColor: '#4f46e5',
                            fillOpacity: 1,
                            strokeColor: '#ffffff',
                            strokeWeight: 2.5,
                        },
                    });

                    /* Radius circle */
                    this._circle = new google.maps.Circle({
                        map: this._map,
                        center: center,
                        radius: this.radius * 1000,
                        fillColor: '#6366f1',
                        fillOpacity: 0.07,
                        strokeColor: '#6366f1',
                        strokeOpacity: 0.45,
                        strokeWeight: 1.5,
                    });

                    /* Click on map */
                    this._map.addListener('click', (e) => {
                        this._moveUser(e.latLng.lat(), e.latLng.lng());
                    });

                    /* Drag user marker */
                    this._uMark.addListener('dragend', (e) => {
                        this._moveUser(e.latLng.lat(), e.latLng.lng());
                    });

                    /* Add center markers */
                    this._addCenters();

                    this.mapReady = true;

                    /* Restore from URL */
                    if (this.lat && this.lng) {
                        this._uMark.setPosition({
                            lat: this.lat,
                            lng: this.lng
                        });
                        this._circle.setCenter({
                            lat: this.lat,
                            lng: this.lng
                        });
                        this._map.setCenter({
                            lat: this.lat,
                            lng: this.lng
                        });
                    }
                },

                /* ---------- add center markers ---------- */
                _addCenters() {
                    var self = this;
                    var pin = function(color) {
                        return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="36" viewBox="0 0 28 36">' +
                            '<path d="M14 0C6.268 0 0 6.268 0 14c0 9.333 14 22 14 22S28 23.333 28 14C28 6.268 21.732 0 14 0z" fill="' +
                            color + '"/>' +
                            '<circle cx="14" cy="14" r="6" fill="white"/>' +
                            '<circle cx="14" cy="14" r="3.5" fill="' + color + '"/>' +
                            '</svg>'
                        );
                    };

                    _CENTERS.forEach(function(c) {
                        if (!c.latitude || !c.longitude) return;

                        var marker = new google.maps.Marker({
                            map: self._map,
                            position: {
                                lat: c.latitude,
                                lng: c.longitude
                            },
                            title: c.name,
                            icon: {
                                url: pin('#e53e3e'),
                                scaledSize: new google.maps.Size(26, 33),
                                anchor: new google.maps.Point(13, 33),
                            },
                        });

                        var iw = new google.maps.InfoWindow({
                            maxWidth: 260,
                        });

                        marker.addListener('click', function() {
                            self._iws.forEach(function(w) {
                                w.close();
                            });
                            iw.setContent(self._buildIW(c));
                            iw.open(self._map, marker);
                        });

                        self._iws.push(iw);
                    });
                },

                /* ---------- info window HTML ---------- */
                _buildIW(c) {
                    var dist = (this.lat && this.lng) ?
                        this._haversine(this.lat, this.lng, c.latitude, c.longitude).toFixed(1) + ' km' :
                        '—';
                    var dark = this.darkMode;
                    var bg = dark ? '#1e2231' : '#ffffff';
                    var clr = dark ? '#f3f4f6' : '#111827';
                    var sub = dark ? '#9ca3af' : '#6b7280';
                    var btn2bg = dark ? 'rgba(255,255,255,.1)' : '#f3f4f6';
                    var btn2bd = dark ? 'rgba(255,255,255,.12)' : '#e5e7eb';
                    return '<div style="background:' + bg +
                        ';border-radius:12px;padding:14px;min-width:210px;font-family:sans-serif;">' +
                        '<div style="font-size:14px;font-weight:700;color:' + clr + ';margin-bottom:6px;">' + c
                        .name + '</div>' +
                        '<div style="font-size:12px;color:#6366f1;margin-bottom:4px;">📍 Masofa: ' + dist +
                        '</div>' +
                        '<div style="font-size:11px;color:' + sub + ';margin-bottom:10px;line-height:1.4;">' + (
                            c.address || "Manzil ko'rsatilmagan") + '</div>' +
                        '<div style="display:flex;gap:7px;">' +
                        '<a href="/blog-single/' + c.id +
                        '" style="flex:1;padding:6px 8px;border-radius:8px;font-size:12px;font-weight:600;text-align:center;text-decoration:none;background:#4f46e5;color:#fff;">Batafsil</a>' +
                        '<a href="https://www.google.com/maps/dir/?api=1&destination=' + c.latitude + ',' + c
                        .longitude +
                        '" target="_blank" style="flex:1;padding:6px 8px;border-radius:8px;font-size:12px;font-weight:600;text-align:center;text-decoration:none;background:' +
                        btn2bg + ';color:' + clr + ';border:1px solid ' + btn2bd + ';">Yo\'nalish</a>' +
                        '</div></div>';
                },

                /* ---------- move user marker ---------- */
                _moveUser(lat, lng, doGeocode) {
                    this.lat = lat;
                    this.lng = lng;
                    if (doGeocode === undefined) doGeocode = true;

                    var pos = {
                        lat: lat,
                        lng: lng
                    };
                    if (this._uMark) this._uMark.setPosition(pos);
                    if (this._circle) this._circle.setCenter(pos);

                    if (doGeocode && this._geo) {
                        var self = this;
                        this._geo.geocode({
                            location: pos
                        }, function(res, status) {
                            if (status === 'OK' && res[0]) {
                                self.addressText = res[0].formatted_address;
                            } else {
                                self.addressText = lat.toFixed(5) + ', ' + lng.toFixed(5);
                            }
                        });
                    }
                },

                /* ---------- locate me ---------- */
                locateMe() {
                    if (!navigator.geolocation) return;
                    this.locating = true;
                    var self = this;
                    navigator.geolocation.getCurrentPosition(
                        function(pos) {
                            self.locating = false;
                            var lat = pos.coords.latitude;
                            var lng = pos.coords.longitude;
                            if (!self._map) {
                                self.lat = lat;
                                self.lng = lng;
                                self._initMap();
                                return;
                            }
                            self._map.setCenter({
                                lat: lat,
                                lng: lng
                            });
                            self._map.setZoom(14);
                            self._moveUser(lat, lng);
                        },
                        function() {
                            self.locating = false;
                            /* Fallback to Samarqand */
                            if (self._map) {
                                self._map.setCenter({
                                    lat: DEFAULT_LAT,
                                    lng: DEFAULT_LNG
                                });
                                self._moveUser(DEFAULT_LAT, DEFAULT_LNG);
                            }
                        }, {
                            timeout: 8000
                        }
                    );
                },

                /* ---------- radius change ---------- */
                onRadiusChange() {
                    if (this._circle) this._circle.setRadius(this.radius * 1000);
                },

                /* ---------- apply ---------- */
                applyFilter() {
                    var finalLat = this.lat || DEFAULT_LAT;
                    var finalLng = this.lng || DEFAULT_LNG;

                    this.resultCount = _CENTERS.filter(function(c) {
                        if (!c.latitude || !c.longitude) return false;
                        return _haversine(finalLat, finalLng, c.latitude, c.longitude) <= this.radius;
                    }.bind(this)).length;
                    this.resultShown = true;

                    // Update URL parameters and perform AJAX search
                    window.currentFilters.set('latitude', finalLat);
                    window.currentFilters.set('longitude', finalLng);
                    window.currentFilters.set('radius', this.radius);
                    window.currentFilters.delete('searchText');
                    
                    // Use global performSearch function
                    if (typeof performSearch === 'function') {
                        performSearch();
                    }
                },

                /* ---------- reset ---------- */
                resetFilter() {
                    this.lat = null;
                    this.lng = null;
                    this.resultShown = false;
                    this.addressText = 'Xaritadan joy tanlang yoki "Mening joylashuvim" tugmasini bosing';
                    if (this._uMark) this._uMark.setPosition({
                        lat: DEFAULT_LAT,
                        lng: DEFAULT_LNG
                    });
                    if (this._circle) this._circle.setCenter({
                        lat: DEFAULT_LAT,
                        lng: DEFAULT_LNG
                    });
                    
                    // Update URL parameters and perform AJAX search
                    window.currentFilters.delete('latitude');
                    window.currentFilters.delete('longitude');
                    window.currentFilters.delete('radius');
                    
                    // Use global performSearch function
                    if (typeof performSearch === 'function') {
                        performSearch();
                    }
                },

                /* ---------- haversine ---------- */
                _haversine(lat1, lon1, lat2, lon2) {
                    var R = 6371;
                    var dLat = (lat2 - lat1) * Math.PI / 180;
                    var dLon = (lon2 - lon1) * Math.PI / 180;
                    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                },
            };
        };

        /* module-level haversine for filter closure */
        function _haversine(lat1, lon1, lat2, lon2) {
            var R = 6371,
                dLat = (lat2 - lat1) * Math.PI / 180,
                dLon = (lon2 - lon1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math
                .PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }
    })();
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=__mfInitMap">
</script>
