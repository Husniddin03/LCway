<x-layout>
    <x-slot:title>{{ __('centers.title') }}</x-slot:title>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        {{-- Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-800 dark:to-pink-900 transition-colors duration-500">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg viewBox=%220 0 400 400%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22 opacity=%220.05%22/%3E%3C/svg%3E')]"></div>
        </div>

        {{-- Floating Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-1/4 w-80 h-80 bg-pink-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl mb-6">
                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-white/90">{{ __('centers.hero.badge') }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                    {{ __('centers.hero.title') }}
                </h1>
                <p class="text-xl text-white/80 max-w-2xl mx-auto">
                    {{ __('centers.hero.description') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Search and Filter Section --}}
    <section class="relative z-20 py-10 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Search Bar --}}
            <div class="mb-8">
                <form id="searchForm" class="relative">
                    @foreach ($validated as $key => $value)
                        @if ($key !== 'searchText')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                        @endif
                    @endforeach
                    <div class="relative max-w-3xl mx-auto">
                        <div class="relative flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500/30 focus-within:border-indigo-500 transition-all duration-200">
                            <div class="pl-6 pr-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="searchText" id="searchText"
                                placeholder="{{ __('centers.search.placeholder') }}"
                                value="{{ $validated['searchText'] ?? '' }}"
                                class="flex-1 py-5 pr-4 text-gray-900 dark:text-white bg-transparent border-none outline-none text-lg placeholder-gray-400">
                            <button type="submit" id="searchBtn"
                                class="m-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg transition-all duration-200 flex items-center gap-2">
                                <svg id="searchIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <svg id="loadingIcon" class="w-5 h-5 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>{{ __('centers.search.button') }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('centers.search.hint') }}
                        </p>
                        @if(config('services.ai_search.enabled'))
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-medium rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                AI
                            </span>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Filters --}}
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 relative z-20">
                <div class="flex overflow-x-auto pb-2 -mr-6 px-6 xl:mx-0 xl:px-0 xl:pb-0 xl:overflow-visible xl:flex-wrap gap-3 w-full [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    {{-- All Button --}}
                    <button type="button" onclick="clearAllFilters()"
                        class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 whitespace-nowrap flex-shrink-0 font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        {{ __('centers.search_filter.all') }}
                    </button>

                    {{-- Map Filter --}}
                    <div class="relative" x-data="mapFilterComp()" x-init="boot()">
                        <button type="button" 
                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md transition-all whitespace-nowrap flex items-center gap-2"
                            :class="isPanelOpen && 'ring-2 ring-indigo-400'"
                            @click="toggle()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('centers.search_filter.map_filter') }}
                            <svg class="w-4 h-4 transition-transform" :class="isPanelOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Map Panel --}}
                        <div x-show="isPanelOpen" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 -translate-y-2 scale-95" 
                            @click.outside="isPanelOpen = false"
                            class="mf-panel fixed xl:absolute inset-2 sm:inset-4 xl:inset-auto xl:top-full xl:left-0 xl:mt-2 w-[calc(100%-16px)] sm:w-[calc(100%-32px)] xl:w-[900px] xl:max-w-[calc(100vw-40px)] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 max-h-[90vh] xl:max-h-none overflow-hidden flex flex-col"
                            :class="isFullscreen && 'mf-fullscreen'"
                            style="display:none;">
                            
                            {{-- Resize Handle (Desktop only) --}}
                            <div class="hidden xl:block absolute bottom-0 right-0 w-6 h-6 cursor-nwse-resize z-50"
                                @mousedown.prevent="startResize($event)"
                                @touchstart.prevent="startResize($event)">
                                <svg class="w-full h-full text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 22H20V20H22V22ZM22 18H18V22H20V20H22V18ZM18 18H16V20H18V18Z"/>
                                </svg>
                            </div>
                            
                            {{-- Panel Header --}}
                            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('centers.search_filter.map_search') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('centers.search_filter.map_subtitle') }}</div>
                                    </div>
                                </div>
                                <button type="button" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors" @click="isPanelOpen = false">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Map Area --}}
                            <div class="relative bg-gray-50 dark:bg-gray-900 flex-1 min-h-[350px]"
                                :style="`height: ${mapHeight}px`">
                                <div id="filterMapEl" class="absolute inset-0 w-full h-full rounded-lg"></div>
                                
                                {{-- Mobile Resize Handle --}}
                                <div class="xl:hidden absolute bottom-2 left-1/2 transform -translate-x-1/2 w-12 h-1.5 bg-gray-400 rounded-full cursor-ns-resize z-40"
                                    @mousedown.prevent="startResize($event)"
                                    @touchstart.prevent="startResize($event)">
                                </div>
                                
                                {{-- Loading Placeholder --}}
                                <div x-show="!mapReady" class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-gray-400 bg-white dark:bg-gray-800">
                                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-9.132A1 1 0 013.382 9.5h17.236a1 1 0 01.838 1.368L16 20M9 20h6M9 20V9m6 11V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium">{{ __('centers.search_filter.map_loading') }}</span>
                                </div>

                                {{-- Map Toolbar --}}
                                <div class="absolute top-3 left-3 right-3 z-[999] flex items-center gap-2 flex-wrap pointer-events-none">
                                    {{-- Locate Button --}}
                                    <button type="button" 
                                        class="pointer-events-auto flex items-center gap-2 px-3 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white transition-all border border-gray-200 dark:border-gray-700"
                                        @click.stop="locateMe()">
                                        <svg class="w-4 h-4" :class="locating && 'animate-spin'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                            <path d="M12 2v3m0 14v3M2 12h3m14 0h3" stroke-width="2"/>
                                        </svg>
                                        <span x-text="locating ? '{{ __('centers.search_filter.locating') }}' : '{{ __('centers.search_filter.my_location') }}'"></span>
                                    </button>

                                    {{-- Expand Button --}}
                                    <button type="button" 
                                        class="pointer-events-auto p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border border-gray-200 dark:border-gray-700"
                                        @click.stop="toggleFullscreen()">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Hint --}}
                                <div class="absolute bottom-3 left-3 z-10 px-3 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold shadow-lg">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                        </svg>
                                        {{ __('centers.search_filter.map_hint') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Controls --}}
                            <div class="p-4 bg-white dark:bg-gray-800 overflow-y-auto max-h-[35vh]">
                                {{-- Location Info --}}
                                <div class="flex items-start gap-3 p-3 mt-10 bg-indigo-50/50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50 mb-4">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide mb-1">{{ __('centers.search_filter.selected_location') }}</div>
                                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate" x-text="addressText || '{{ __('centers.search_filter.click_map') }}'"></div>
                                        <div class="text-xs text-gray-400 mt-0.5 font-mono" x-show="lat && lng">
                                            <span x-text="lat ? lat.toFixed(5) : ''"></span>,
                                            <span x-text="lng ? lng.toFixed(5) : ''"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Radius Slider --}}
                                <div class="mb-5">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                            <div class="w-7 h-7 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                                    <circle cx="12" cy="12" r="3" fill="currentColor"/>
                                                </svg>
                                            </div>
                                            {{ __('centers.search_filter.search_radius') }}
                                        </div>
                                        <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full shadow-md" x-text="radius + ' km'"></span>
                                    </div>
                                    <div class="relative">
                                        <input type="range" min="1" max="50" step="1"
                                            x-model.number="radius" @input="onRadiusChange()"
                                            class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full appearance-none cursor-pointer accent-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-400 mt-2 font-medium">
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">1 km</span>
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">25 km</span>
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">50 km</span>
                                    </div>
                                </div>

                                {{-- Quick Radius Buttons --}}
                                <div class="flex gap-2 mb-5">
                                    <template x-for="r in [2,5,10,20]" :key="r">
                                        <button type="button"
                                            class="flex-1 px-3 py-2 text-xs font-semibold rounded-xl transition-all border"
                                            :class="radius == r ? 'bg-indigo-600 border-indigo-600 text-white shadow-md' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-indigo-300 dark:hover:border-indigo-700'"
                                            @click="radius = r; onRadiusChange()" x-text="r + ' km'">
                                        </button>
                                    </template>
                                </div>

                                <input type="hidden" name="latitude" :value="lat">
                                <input type="hidden" name="longitude" :value="lng">
                                <input type="hidden" name="radius" :value="radius">

                                {{-- Actions --}}
                                <div class="flex gap-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <button type="button"
                                        class="flex-1 px-4 py-3 border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-all"
                                        @click="resetFilter()">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            {{ __('centers.search_filter.clear') }}
                                        </span>
                                    </button>
                                    <button type="button" 
                                        class="flex-1 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all flex items-center justify-center gap-2"
                                        @click="applyMapFilter()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-4.35-4.35" />
                                        </svg>
                                        {{ __('centers.search_filter.search') }}
                                    </button>
                                </div>

                                {{-- Results --}}
                                <div x-show="resultShown" class="mt-3 text-center text-sm text-gray-600 dark:text-gray-400">
                                    <strong x-text="resultCount"></strong> {{ __('centers.search_filter.results_found') }}
                                    (<span x-text="radius"></span> {{ __('centers.search_filter.results_radius') }})
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative inline-block" x-data="dropdown()" x-init="init('sort')">
                        <button @click="toggle()" type="button"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-gray-900 dark:text-white rounded-lg transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            {{ __('centers.search_filter.sort') }}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Desktop Dropdown -->
                        <div x-show="isOpen && !isMobile" @click.away="close()" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl z-[100]">
                            <div class="py-2">
                                @if (!isset($validated['name']))
                                    <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_name') }} ↑↓</button>
                                @elseif ($validated['name'] == 'asc')
                                    <button type="button" onclick="applySorting('name', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_name') }} ↑</button>
                                @elseif ($validated['name'] == 'desc')
                                    <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_name') }} ↓</button>
                                @else
                                    <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_name') }} ↑↓</button>
                                @endif

                                @if (!isset($validated['distance']))
                                    <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_distance') }} ↑↓</button>
                                @elseif ($validated['distance'] == 'asc')
                                    <button type="button" onclick="applySorting('distance', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_distance') }} ↑</button>
                                @elseif ($validated['distance'] == 'desc')
                                    <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_distance') }} ↓</button>
                                @else
                                    <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_distance') }} ↑↓</button>
                                @endif

                                @if (!isset($validated['favorites']))
                                    <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_rating') }} ↑↓</button>
                                @elseif ($validated['favorites'] == 'asc')
                                    <button type="button" onclick="applySorting('favorites', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_rating') }} ↑</button>
                                @elseif ($validated['favorites'] == 'desc')
                                    <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_rating') }} ↓</button>
                                @else
                                    <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_rating') }} ↑↓</button>
                                @endif
                            </div>
                        </div>

                        <!-- Mobile Dropdown -->
                        <div x-show="isOpen && isMobile" x-cloak
                            class="fixed inset-0 z-[9999] flex items-start justify-center pt-20 px-4"
                            @click.self="close()">
                            <div class="absolute inset-0 bg-black/50" @click="close()"></div>
                            <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ __('centers.search_filter.sort') }}</span>
                                    <button @click="close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="py-2 max-h-[60vh] overflow-y-auto">
                                    @if (!isset($validated['name']))
                                        <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_name') }} ↑↓</button>
                                    @elseif ($validated['name'] == 'asc')
                                        <button type="button" onclick="applySorting('name', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_name') }} ↑</button>
                                    @elseif ($validated['name'] == 'desc')
                                        <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_name') }} ↓</button>
                                    @else
                                        <button type="button" onclick="applySorting('name', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_name') }} ↑↓</button>
                                    @endif

                                    @if (!isset($validated['distance']))
                                        <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_distance') }} ↑↓</button>
                                    @elseif ($validated['distance'] == 'asc')
                                        <button type="button" onclick="applySorting('distance', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_distance') }} ↑</button>
                                    @elseif ($validated['distance'] == 'desc')
                                        <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_distance') }} ↓</button>
                                    @else
                                        <button type="button" onclick="applySorting('distance', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_distance') }} ↑↓</button>
                                    @endif

                                    @if (!isset($validated['favorites']))
                                        <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_rating') }} ↑↓</button>
                                    @elseif ($validated['favorites'] == 'asc')
                                        <button type="button" onclick="applySorting('favorites', 'desc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_rating') }} ↑</button>
                                    @elseif ($validated['favorites'] == 'desc')
                                        <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20">{{ __('centers.search_filter.sort_rating') }} ↓</button>
                                    @else
                                        <button type="button" onclick="applySorting('favorites', 'asc'); dropdowns.sort.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.sort_rating') }} ↑↓</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verified Filter -->
                    <div class="relative inline-block" x-data="dropdown()" x-init="init('verified')">
                        <button @click="toggle()" type="button"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-gray-900 dark:text-white rounded-lg transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            @if (!isset($validated['checked']))
                                {{ __('centers.search_filter.all_status') }}
                            @elseif ($validated['checked'] == '1')
                                {{ __('centers.search_filter.verified_only') }}
                            @elseif ($validated['checked'] == '0')
                                {{ __('centers.search_filter.unverified_only') }}
                            @else
                                {{ __('centers.search_filter.all_status') }}
                            @endif
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Desktop Dropdown -->
                        <div x-show="isOpen && !isMobile" @click.away="close()" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl z-[100]">
                            <div class="py-2">
                                <button type="button" onclick="removeFilter('checked'); dropdowns.verified.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.all_status') }}</button>
                                <button type="button" onclick="applyFilter('checked', '1'); dropdowns.verified.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.verified_only') }}</button>
                                <button type="button" onclick="applyFilter('checked', '0'); dropdowns.verified.close()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.unverified_only') }}</button>
                            </div>
                        </div>

                        <!-- Mobile Dropdown -->
                        <div x-show="isOpen && isMobile" x-cloak
                            class="fixed inset-0 z-[9999] flex items-start justify-center pt-20 px-4"
                            @click.self="close()">
                            <div class="absolute inset-0 bg-black/50" @click="close()"></div>
                            <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ __('centers.search_filter.status') }}</span>
                                    <button @click="close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="py-2 max-h-[60vh] overflow-y-auto">
                                    <button type="button" onclick="removeFilter('checked'); dropdowns.verified.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.all_status') }}</button>
                                    <button type="button" onclick="applyFilter('checked', '1'); dropdowns.verified.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.verified_only') }}</button>
                                    <button type="button" onclick="applyFilter('checked', '0'); dropdowns.verified.close()" class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('centers.search_filter.unverified_only') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div class="relative inline-block" x-data="dropdown()" x-init="init('type')">
                        <button @click="toggle()" type="button"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-gray-900 dark:text-white rounded-lg transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            {{ __('centers.search_filter.type') }}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Desktop Dropdown -->
                        <div x-show="isOpen && !isMobile" @click.away="close()" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl z-[100]">
                            <div class="py-2 max-h-64 overflow-y-auto">
                                @foreach ($types as $type)
                                    <button type="button" onclick='applyFilter("type", "{{ $type }}"); dropdowns.type.close()'
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        {{ $type }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Mobile Dropdown -->
                        <div x-show="isOpen && isMobile" x-cloak
                            class="fixed inset-0 z-[9999] flex items-start justify-center pt-20 px-4"
                            @click.self="close()">
                            <div class="absolute inset-0 bg-black/50" @click="close()"></div>
                            <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ __('centers.search_filter.type') }}</span>
                                    <button @click="close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="py-2 max-h-[60vh] overflow-y-auto">
                                    @foreach ($types as $type)
                                        <button type="button" onclick='applyFilter("type", "{{ $type }}"); dropdowns.type.close()'
                                            class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            {{ $type }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Dropdown -->
                    <div class="relative inline-block" x-data="dropdown()" x-init="init('price')">
                        <button @click="toggle()" type="button"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-gray-900 dark:text-white rounded-lg transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                            {{ __('centers.search_filter.price') ?? 'Narx' }}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Desktop Dropdown -->
                        <div x-show="isOpen && !isMobile" @click.away="close()" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl z-[100] p-4">
                            
                            <div class="flex flex-col gap-3 mb-4">
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('centers.search_filter.min_price') ?? 'Min. narx' }}</label>
                                    <input type="number" id="minPriceInput" min="0" placeholder="Masalan: 0" class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('centers.search_filter.max_price') ?? 'Max. narx' }}</label>
                                    <input type="number" id="maxPriceInput" min="0" placeholder="Masalan: 1000000" class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                </div>
                            </div>
                            <button type="button" onclick="applyPriceFilter(); dropdowns.price.close()"
                                class="w-full bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium py-2 rounded-md transition-colors">
                                {{ __('centers.search_filter.apply') }}
                            </button>
                        </div>

                        <!-- Mobile Dropdown -->
                        <div x-show="isOpen && isMobile" x-cloak
                            class="fixed inset-0 z-[9999] flex items-start justify-center pt-20 px-4"
                            @click.self="close()">
                            <div class="absolute inset-0 bg-black/50" @click="close()"></div>
                            <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ __('centers.search_filter.price') ?? 'Narx' }}</span>
                                    <button @click="close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <div class="flex flex-col gap-3 mb-4">
                                        <div>
                                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('centers.search_filter.min_price') ?? 'Min. narx' }}</label>
                                            <input type="number" id="minPriceInputMobile" min="0" placeholder="Masalan: 0" class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('centers.search_filter.max_price') ?? 'Max. narx' }}</label>
                                            <input type="number" id="maxPriceInputMobile" min="0" placeholder="Masalan: 1000000" class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                        </div>
                                    </div>
                                    <button type="button" onclick="applyPriceFilterMobile(); dropdowns.price.close()"
                                        class="w-full bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium py-2 rounded-md transition-colors">
                                        {{ __('centers.search_filter.apply') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-gray-600 dark:text-gray-400 text-sm whitespace-nowrap">
                    <span id="resultsCount">{{ $pagination['total'] ?? $LearningCenters->count() }}</span> {{ __('centers.search_filter.results_count') }}
                </div>
            </div>
        </div>
    </section>

    {{-- Centers Grid --}}
    <section class="py-16 bg-white dark:bg-gray-900 relative z-10 overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-gray-50/80 to-transparent dark:from-gray-800/50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Loading Indicator --}}
            <div id="loadingIndicator" class="hidden text-center py-12">
                <svg class="w-12 h-12 animate-spin mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('centers.search_filter.searching') }}</p>
            </div>

            {{-- Grid --}}
            <div id="centersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($LearningCenters as $LearningCenter)
                    <div class="group relative">
                        {{-- Glow Effect --}}
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-30 blur transition duration-500"></div>
                        
                        {{-- Card --}}
                        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden h-full border border-gray-100 dark:border-gray-700 group-hover:-translate-y-1">
                            {{-- Image --}}
                            <div class="relative h-52 overflow-hidden">
                                @if($LearningCenter->logo)
                                    @if(str_starts_with($LearningCenter->logo, 'http://') || str_starts_with($LearningCenter->logo, 'https://'))
                                        <x-optimized-image src="{{ $LearningCenter->logo }}" alt="{{ $LearningCenter->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" width="400" height="208" />
                                    @else
                                        <x-optimized-image src="{{ asset('storage/' . $LearningCenter->logo) }}" alt="{{ $LearningCenter->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" width="400" height="208" />
                                    @endif
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 dark:from-indigo-600 dark:via-purple-700 dark:to-pink-800 flex items-center justify-center relative overflow-hidden">
                                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2220%22 height=%2220%22 viewBox=%220 0 20 20%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.05%22 fill-rule=%22evenodd%22%3E%3Ccircle cx=%223%22 cy=%223%22 r=%223%22/%3E%3Ccircle cx=%2213%22 cy=%2213%22 r=%223%22/%3E%3C/g%3E%3C/svg%3E')]"></div>
                                        <div class="text-white text-center px-4 relative z-10">
                                            <div class="text-2xl font-bold mb-1 drop-shadow-lg">{{ $LearningCenter->type }}</div>
                                            <div class="text-sm opacity-90">{{ Str::limit($LearningCenter->name, 25) }}</div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Rating Badge --}}
                                <div class="absolute top-3 right-3 bg-white dark:bg-gray-800 px-2.5 py-1 rounded-full shadow-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center gap-1">
                                        <span class="text-amber-500 text-sm">★</span>
                                        <span class="text-sm font-black text-gray-900 dark:text-white">{{ $LearningCenter->calculated_total_reyting }}</span>
                                    </div>
                                </div>

                                {{-- Verified Badge --}}
                                @if ($LearningCenter->checked)
                                    <div class="absolute top-3 left-3 bg-emerald-500/95 backdrop-blur p-1.5 rounded-full shadow-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- View Button Overlay --}}
                                <a href="{{ route('center', $LearningCenter->slug) }}"
                                    class="absolute inset-0 flex items-end justify-center p-4 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-xl shadow-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                        {{ __('centers.centers_grid.read_more') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </a>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                {{-- Title --}}
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('center', $LearningCenter->slug) }}">{{ $LearningCenter->name }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $LearningCenter->type }}</p>

                                {{-- Meta --}}
                                <div class="flex flex-wrap gap-2 mb-3 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate">{{ $LearningCenter->region . ', ' . $LearningCenter->province }}</span>
                                    </div>
                                    @if (isset($LearningCenter->distance))
                                        <div class="flex items-center gap-1.5 px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-full">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">{{ round($LearningCenter->distance, 1) }} km</span>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full">
                        <div class="relative max-w-lg mx-auto">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-20 blur"></div>
                            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 text-center border border-gray-100 dark:border-gray-700">
                                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('centers.centers_grid.no_centers_found') }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('centers.centers_grid.try_adjusting') }}</p>

                                @if(!empty($typoSuggestion))
                                    <div class="mb-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-xl">
                                        <p class="text-indigo-800 dark:text-indigo-200 text-sm">
                                            {{ __('centers.centers_grid.did_you_mean') }}:
                                            <a href="{{ route('centers', array_merge(request()->except('searchText'), ['searchText' => $typoSuggestion])) }}"
                                               class="font-semibold underline hover:text-indigo-600 dark:hover:text-indigo-400">"{{ $typoSuggestion }}"</a>?
                                        </p>
                                    </div>
                                @endif

                                <button onclick="clearAllFilters()"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                                    {{ __('centers.centers_grid.clear_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            
            {{-- Infinite Scroll Loading --}}
            <div id="infiniteScrollLoading" class="hidden text-center py-12">
                <svg class="w-10 h-10 animate-spin mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('centers.centers_grid.loading_more') }}</p>
            </div>

            {{-- No More Results --}}
            <div id="noMoreResults" class="hidden text-center py-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700/50 rounded-full">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">{{ __('centers.centers_grid.all_results') }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Centers JavaScript --}}
    <script src="{{ asset('js/centers.js') }}"></script>

    <script>
        window._CENTERS = @json($centersForMap ?? []);
        window.currentPage = @json($pagination['current_page'] ?? 1);
        window.hasMorePages = @json(($pagination['has_more_pages'] ?? false) ? 'true' : 'false');

        // Global dropdown registry
        window.dropdowns = {};

        // Dropdown Alpine.js component
        function dropdown() {
            return {
                isOpen: false,
                isMobile: false,
                name: null,
                init(name) {
                    this.name = name;
                    this.checkMobile();
                    window.addEventListener('resize', () => this.checkMobile());
                    // Register this dropdown
                    window.dropdowns[name] = this;
                },
                checkMobile() {
                    this.isMobile = window.innerWidth < 768;
                },
                toggle() {
                    if (this.isOpen) {
                        this.close();
                    } else {
                        // Close all other dropdowns first
                        Object.values(window.dropdowns).forEach(d => {
                            if (d !== this) d.close();
                        });
                        this.open();
                    }
                },
                open() {
                    this.isOpen = true;
                },
                close() {
                    this.isOpen = false;
                }
            }
        }

        // Make dropdown function available globally for Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', dropdown);
        });
    </script>

    {{-- Map Styles with Resize and Responsive Support --}}
    <style>
        /* Fullscreen mode */
        .mf-panel.mf-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-width: none !important;
            max-height: none !important;
            z-index: 9999 !important;
            border-radius: 0 !important;
            margin: 0 !important;
            inset: 0 !important;
        }
        
        .mf-panel.mf-fullscreen .relative {
            height: calc(100vh - 200px) !important;
        }
        
        body.mf-fullscreen-open {
            overflow: hidden !important;
        }
        
        /* Map resize handle - desktop */
        .mf-panel .cursor-nwse-resize {
            cursor: nwse-resize;
            transition: all 0.2s;
        }
        .mf-panel .cursor-nwse-resize:hover {
            transform: scale(1.2);
            color: #6366f1;
        }
        
        /* Map resize handle - mobile */
        .mf-panel .cursor-ns-resize {
            cursor: ns-resize;
            transition: all 0.2s;
        }
        .mf-panel .cursor-ns-resize:active {
            background-color: #6366f1;
        }
        
        /* Custom cluster styles */
        .custom-cluster {
            background: transparent !important;
            border: none !important;
        }
        .custom-cluster div {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 2px solid white;
        }
        
        /* Pin styles */
        .mf-pin {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        .mf-pin:hover {
            transform: scale(1.1);
        }
        .mf-pin-dot {
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }
        .mf-pin-center .mf-pin-dot {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }
        .mf-pin-user .mf-pin-dot {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        /* Map popup styles */
        .mf-popup .leaflet-popup-content-wrapper {
            border-radius: 16px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 10px 20px -5px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .dark .mf-popup .leaflet-popup-content-wrapper {
            background: #1f2937;
        }
        .mf-popup .leaflet-popup-content {
            margin: 0;
            width: 280px !important;
        }
        .mf-popup .leaflet-popup-tip {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .dark .mf-popup .leaflet-popup-tip {
            background: #1f2937;
        }
        
        /* Popup Card Styles */
        .mf-card {
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        /* Image Section */
        .mf-card-image {
            position: relative;
            width: 100%;
            height: 140px;
            overflow: hidden;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }
        .mf-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .mf-card-image:hover img {
            transform: scale(1.05);
        }
        .mf-card-image--gradient {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }
        .mf-card-image-letter {
            font-size: 48px;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .mf-card-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.4), transparent 50%);
        }
        
        /* Content Section */
        .mf-card-content {
            padding: 16px;
        }
        
        /* Header with badges */
        .mf-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 8px;
        }
        .mf-card-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        
        /* Type Badge */
        .mf-card-type {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            background: #eff6ff;
            color: #3b82f6;
            font-size: 11px;
            font-weight: 600;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .dark .mf-card-type {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }
        
        /* Rating Badge */
        .mf-card-rating {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            font-size: 12px;
            font-weight: 700;
            border-radius: 20px;
        }
        .mf-card-star {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }
        
        /* Verified Badge */
        .mf-card-verified {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .mf-card-verified svg {
            width: 14px;
            height: 14px;
        }
        
        /* Name */
        .mf-card-name {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 8px 0;
            line-height: 1.4;
        }
        .dark .mf-card-name {
            color: #f9fafb;
        }
        
        /* Address */
        .mf-card-address {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 14px;
            line-height: 1.5;
        }
        .dark .mf-card-address {
            color: #9ca3af;
        }
        .mf-card-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            color: #9ca3af;
        }
        .dark .mf-card-icon {
            color: #6b7280;
        }
        
        /* Actions */
        .mf-card-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }
        .dark .mf-card-actions {
            border-color: #374151;
        }
        
        /* Buttons */
        .mf-card-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1.5px solid #e5e7eb;
            background: white;
            color: #374151;
        }
        .dark .mf-card-btn {
            background: #374151;
            border-color: #4b5563;
            color: #e5e7eb;
        }
        .mf-card-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }
        .dark .mf-card-btn:hover {
            background: #4b5563;
        }
        
        .mf-card-btn--primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
        }
        .mf-card-btn--primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 6px 8px -1px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }
        
        .mf-card-btn-icon {
            width: 16px;
            height: 16px;
        }
        
        /* Selected Location Popup */
        .mf-selected-popup {
            padding: 12px 16px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
        }
        .dark .mf-selected-popup {
            background: #1f2937;
            color: #f9fafb;
        }
        .mf-selected-popup-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            color: #111827;
        }
        .dark .mf-selected-popup-title {
            color: #f9fafb;
        }
        .mf-selected-popup-coords {
            font-size: 12px;
            color: #6b7280;
            font-family: monospace;
        }
        .dark .mf-selected-popup-coords {
            color: #9ca3af;
        }
        
        /* Dark mode map tiles */
        .dark .leaflet-tile {
            filter: brightness(0.75) contrast(1.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .mf-panel {
                inset: 8px;
                width: calc(100% - 16px);
            }
            .mf-panel.mf-fullscreen .relative {
                height: calc(100vh - 180px) !important;
            }
        }
        
        /* Map loading animation */
        @keyframes mf-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .mf-loading {
            animation: mf-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</x-layout>
