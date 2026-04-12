<x-layout>
    <x-slot:title>{{ __('index.title') }}</x-slot:title>

    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-800 dark:to-pink-900 transition-colors duration-500">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        </div>

        {{-- Animated Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-96 h-96 bg-purple-500/20 dark:bg-purple-400/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-pink-500/20 dark:bg-pink-400/10 rounded-full blur-3xl animate-pulse [animation-delay:1s]"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-500/20 dark:bg-indigo-400/10 rounded-full blur-3xl animate-pulse [animation-delay:2s]"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-sm font-medium text-white/90">{{ __('index.hero.badge', ['count' => $centers->count() ?? 0]) }}</span>
            </div>

            {{-- Title --}}
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black mb-6 leading-none text-white tracking-tight">
                {{ __('index.hero.greeting') }},<br>
                <span class="bg-gradient-to-r from-amber-300 via-orange-300 to-amber-400 bg-clip-text text-transparent">
                    Findora
                </span>
                {{ __('index.hero.welcome') }}
            </h1>

            {{-- Description --}}
            <p class="text-xl sm:text-2xl md:text-3xl mb-12 max-w-4xl mx-auto text-white/70 font-light">
                {{ __('index.hero.description') }}
            </p>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <x-button variant="secondary" size="lg" href="{{ route('centers') }}"
                    class="bg-white text-indigo-600 hover:bg-gray-50 shadow-2xl shadow-white/10 transition-all duration-300 hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    {{ __('index.hero.browse_courses') }}
                </x-button>

                <x-button variant="outline" size="lg" href="{{ route('centers') }}"
                    class="bg-white/10 backdrop-blur-md border-white/30 text-white hover:bg-white/20 transition-all duration-300 hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ __('index.hero.phone') }}
                </x-button>
            </div>

            {{-- Trust Indicators --}}
            <div class="flex flex-wrap justify-center gap-8 text-sm text-white/60">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('index.hero.verified_centers') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span>{{ __('index.hero.top_rated') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('index.hero.support_24_7') }}</span>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-8 h-14 rounded-full border-2 border-white/30 flex items-start justify-center p-2">
                <div class="w-1.5 h-3 bg-white/60 rounded-full animate-pulse"></div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-24 bg-gray-50 dark:bg-gray-900 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-indigo-200/40 to-purple-200/40 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-gradient-to-tl from-pink-200/40 to-rose-200/40 dark:from-pink-900/20 dark:to-rose-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-100 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.features.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.features.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto transition-colors">
                    {{ __('index.features.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl opacity-0 group-hover:opacity-30 blur-xl transition duration-500"></div>
                    <div class="relative p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-300 h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.features.teacher_selection.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.features.teacher_selection.description') }}
                        </p>
                    </div>
                </div>

                {{-- Feature 2 --}}
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl opacity-0 group-hover:opacity-30 blur-xl transition duration-500"></div>
                    <div class="relative p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-300 h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.features.nationwide.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.features.nationwide.description') }}
                        </p>
                    </div>
                </div>

                {{-- Feature 3 --}}
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl opacity-0 group-hover:opacity-30 blur-xl transition duration-500"></div>
                    <div class="relative p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-300 h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.features.ratings.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.features.ratings.description') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section class="py-24 bg-white dark:bg-gray-800 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-1/2 h-full bg-gradient-to-l from-indigo-100/70 to-transparent dark:from-indigo-900/10 rounded-l-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Image Gallery --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl blur-2xl opacity-20"></div>
                    <div class="relative">
                        <div class="relative z-0 transform hover:scale-[1.02] transition-transform duration-500">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur opacity-30"></div>
                            <x-optimized-image src="{{ asset('images/we1.webp') }}" alt="{{ __('index.about.image_alt') }}"
                                class="relative rounded-3xl shadow-2xl ring-1 ring-gray-200 dark:ring-gray-700" width="600" height="400" eager="true" fetchpriority="high" />
                        </div>
                        <div class="absolute -bottom-6 -right-6 z-10">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur opacity-40"></div>
                                <x-optimized-image src="{{ asset('images/we2.webp') }}" alt="{{ __('index.about.image_alt_2') }}"
                                    class="relative rounded-2xl shadow-xl w-36 h-36 object-cover ring-2 ring-white dark:ring-gray-700" width="144" height="144" eager="true" fetchpriority="high" />
                            </div>
                        </div>
                        <div class="absolute -top-6 -left-6 z-10">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-40"></div>
                                <x-optimized-image src="{{ asset('images/we3.webp') }}" alt="{{ __('index.about.image_alt_3') }}"
                                    class="relative rounded-2xl shadow-xl w-36 h-36 object-cover ring-2 ring-white dark:ring-gray-700" width="144" height="144" eager="true" fetchpriority="high" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-6 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('index.about.badge') }}
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight transition-colors">
                        {{ __('index.about.title') }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed transition-colors">
                        {{ __('index.about.description') }}
                    </p>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="text-center p-4 bg-gray-100 dark:bg-gray-700/50 rounded-2xl transition-colors">
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $centers->count() ?? '500+' }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 transition-colors">{{ __('index.about.centers') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-100 dark:bg-gray-700/50 rounded-2xl transition-colors">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">10k+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 transition-colors">{{ __('index.about.students') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-100 dark:bg-gray-700/50 rounded-2xl transition-colors">
                            <div class="text-3xl font-bold text-pink-600 dark:text-pink-400">50+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 transition-colors">{{ __('index.about.cities') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-900 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-bl from-indigo-200/60 to-transparent dark:from-indigo-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-800/50 dark:to-purple-800/50 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.services.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.services.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto transition-colors">
                    {{ __('index.services.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Service 1 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.startup_development.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.startup_development.description') }}
                        </p>
                    </div>
                </x-card>

                {{-- Service 2 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-purple-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.high_quality_design.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.high_quality_design.description') }}
                        </p>
                    </div>
                </x-card>

                {{-- Service 3 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.websites.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.websites.description') }}
                        </p>
                    </div>
                </x-card>

                {{-- Service 4 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-amber-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.optimal_speed.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.optimal_speed.description') }}
                        </p>
                    </div>
                </x-card>

                {{-- Service 5 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-rose-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.full_compatibility.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.full_compatibility.description') }}
                        </p>
                    </div>
                </x-card>

                {{-- Service 6 --}}
                <x-card hover class="group relative overflow-hidden bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative text-center p-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors">
                            {{ __('index.services.both_sides.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                            {{ __('index.services.both_sides.description') }}
                        </p>
                    </div>
                </x-card>
            </div>
        </div>
    </section>

    {{-- Featured Courses Section --}}
    <section class="py-24 bg-white dark:bg-gray-800 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-indigo-100/70 to-transparent dark:from-indigo-900/10"></div>
            <div class="absolute top-20 right-20 w-96 h-96 bg-gradient-to-bl from-purple-200/50 to-transparent dark:from-purple-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-amber-100 dark:bg-amber-800/50 text-amber-700 dark:text-amber-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.featured_courses.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.featured_courses.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto transition-colors">
                    {{ __('index.featured_courses.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @if (isset($centers) && $centers->count() > 0)
                    @foreach ($centers->take(8) as $center)
                        <div class="group relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-30 blur transition duration-500"></div>
                            <x-card hover class="relative h-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-1">
                                <div class="relative overflow-hidden">
                                    @if ($center->logo)
                                        @if(str_starts_with($center->logo, 'http://') || str_starts_with($center->logo, 'https://'))
                                            <x-optimized-image src="{{ $center->logo }}" alt="{{ $center->name }}"
                                                class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500" width="400" height="208" eager="true" fetchpriority="high" />
                                        @else
                                            <x-optimized-image src="{{ asset('storage/' . $center->logo) }}" alt="{{ $center->name }}"
                                                class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500" width="400" height="208" eager="true" fetchpriority="high" />
                                        @endif
                                    @else
                                        <div class="w-full h-52 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center relative overflow-hidden">
                                            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23ffffff" fill-opacity="0.05" fill-rule="evenodd"%3E%3Ccircle cx="3" cy="3" r="3"/%3E%3Ccircle cx="13" cy="13" r="3"/%3E%3C/g%3E%3C/svg%3E')]"></div>
                                            <div class="text-white text-center px-4 relative z-10">
                                                <div class="text-3xl font-bold mb-1 drop-shadow-lg">{{ $center->type }}</div>
                                                <div class="text-sm opacity-90">{{ Str::limit($center->name, 25) }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Rating Badge --}}
                                    <div class="absolute top-3 right-3 bg-white/95 dark:bg-gray-800/95 backdrop-blur-md px-3 py-1.5 rounded-full shadow-lg border border-gray-200 dark:border-gray-600">
                                        @php $average = $center->rating; @endphp
                                        <div class="flex items-center space-x-1">
                                            <span class="text-amber-500 text-sm">★</span>
                                            <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $average }}</span>
                                        </div>
                                    </div>

                                    {{-- Verified Badge --}}
                                    @if($center->checked)
                                        <div class="absolute top-3 left-3 bg-emerald-500/95 backdrop-blur-md p-1.5 rounded-full shadow-lg">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5">
                                    <div class="mb-3">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                            {{ Str::limit($center->name, 35) }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors">{{ $center->type }}</p>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3 transition-colors">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="truncate">{{ Str::limit($center->address, 28) }}</span>
                                    </div>

                                    @if ($center->subjects->count() > 0)
                                        <div class="flex flex-wrap gap-1.5 mb-4">
                                            @foreach ($center->subjects->take(2) as $subject)
                                                <span class="px-2.5 py-1 bg-indigo-100 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-300 text-xs font-medium rounded-full transition-colors">
                                                    {{ $subject->subject_name }}
                                                </span>
                                            @endforeach
                                            @if ($center->subjects->count() > 2)
                                                <span class="px-2.5 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium rounded-full transition-colors">
                                                    +{{ $center->subjects->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700 transition-colors">
                                        @if ($center->subjects->count() > 0)
                                            <div>
                                                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                                    {{ number_format($center->subjects->min('price') ?? 0, 0, '.', ' ') }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors">{{ __('index.featured_courses.per_month') }}</p>
                                            </div>
                                        @else
                                            <div></div>
                                        @endif

                                        <x-button variant="primary" size="sm" href="{{ route('center', $center->slug) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                                            {{ __('index.featured_courses.details') }}
                                        </x-button>
                                    </div>
                                </div>
                            </x-card>
                        </div>
                    @endforeach
                @else
                    {{-- Placeholder cards --}}
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 rounded-2xl opacity-20 blur"></div>
                            <x-card class="relative bg-white dark:bg-gray-800 h-full border-gray-200 dark:border-gray-700">
                                <div class="h-52 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 animate-pulse"></div>
                                <div class="p-5 space-y-3">
                                    <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded w-3/4 animate-pulse"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/2 animate-pulse"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full animate-pulse"></div>
                                </div>
                            </x-card>
                        </div>
                    @endfor
                @endif
            </div>

            <div class="text-center mt-16">
                <x-button variant="primary" size="lg" href="{{ route('centers') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 hover:-translate-y-0.5">
                    {{ __('index.featured_courses.view_all') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </x-button>
            </div>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-900 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-indigo-200/60 via-transparent to-transparent dark:from-indigo-900/20"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-pink-100 dark:bg-pink-800/50 text-pink-700 dark:text-pink-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.categories.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.categories.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto transition-colors">
                    {{ __('index.categories.description') }}
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-4">
                @php
                    $categories = [
                        __('index.categories.it'),
                        __('index.categories.languages'),
                        __('index.categories.mathematics'),
                        __('index.categories.science'),
                        __('index.categories.arts'),
                        __('index.categories.music'),
                        __('index.categories.sports'),
                        __('index.categories.business'),
                    ];
                @endphp

                @foreach ($categories as $category)
                    <button class="group relative px-6 py-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <span class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        <span class="relative text-gray-700 dark:text-gray-300 font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $category }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="py-24 bg-white dark:bg-gray-800 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-amber-100/50 to-transparent dark:from-amber-900/10"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-amber-100 dark:bg-amber-800/50 text-amber-700 dark:text-amber-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.testimonials.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.testimonials.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto transition-colors">
                    {{ __('index.testimonials.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Testimonial 1 --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-20 group-hover:opacity-40 blur transition duration-500"></div>
                    <x-card hover class="relative bg-white dark:bg-gray-800 p-8 h-full border-gray-200 dark:border-gray-700 transition-colors">
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <blockquote class="text-gray-700 dark:text-gray-300 mb-6 italic transition-colors">
                            "{{ __('index.testimonials.testimonial1.content') }}"
                        </blockquote>
                        <div class="flex items-center gap-4">
                            <x-optimized-image src="https://ui-avatars.com/api/?name=Ali+Valiyev&background=6366f1&color=fff&size=100" alt="{{ __('index.testimonials.testimonial1.name') }}" class="w-14 h-14 rounded-full ring-2 ring-indigo-100 dark:ring-indigo-800/50" width="56" height="56" />
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white transition-colors">{{ __('index.testimonials.testimonial1.name') }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors">{{ __('index.testimonials.testimonial1.role') }}</p>
                            </div>
                        </div>
                    </x-card>
                </div>

                {{-- Testimonial 2 --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl opacity-20 group-hover:opacity-40 blur transition duration-500"></div>
                    <x-card hover class="relative bg-white dark:bg-gray-800 p-8 h-full border-gray-200 dark:border-gray-700 transition-colors">
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <blockquote class="text-gray-700 dark:text-gray-300 mb-6 italic transition-colors">
                            "{{ __('index.testimonials.testimonial2.content') }}"
                        </blockquote>
                        <div class="flex items-center gap-4">
                            <x-optimized-image src="https://ui-avatars.com/api/?name=Malika+Karimova&background=ec4899&color=fff&size=100" alt="{{ __('index.testimonials.testimonial2.name') }}" class="w-14 h-14 rounded-full ring-2 ring-pink-100 dark:ring-pink-800/50" width="56" height="56" />
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white transition-colors">{{ __('index.testimonials.testimonial2.name') }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors">{{ __('index.testimonials.testimonial2.role') }}</p>
                            </div>
                        </div>
                    </x-card>
                </div>

                {{-- Testimonial 3 --}}
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl opacity-20 group-hover:opacity-40 blur transition duration-500"></div>
                    <x-card hover class="relative bg-white dark:bg-gray-800 p-8 h-full border-gray-200 dark:border-gray-700 transition-colors">
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 1; $i <= 4; $i++)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <blockquote class="text-gray-700 dark:text-gray-300 mb-6 italic transition-colors">
                            "{{ __('index.testimonials.testimonial3.content') }}"
                        </blockquote>
                        <div class="flex items-center gap-4">
                            <x-optimized-image src="https://ui-avatars.com/api/?name=Javohir+Toshmatov&background=10b981&color=fff&size=100" alt="{{ __('index.testimonials.testimonial3.name') }}" class="w-14 h-14 rounded-full ring-2 ring-emerald-100 dark:ring-emerald-800/50" width="56" height="56" />
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white transition-colors">{{ __('index.testimonials.testimonial3.name') }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors">{{ __('index.testimonials.testimonial3.role') }}</p>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-800 dark:to-pink-900 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            <div class="absolute top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-8">
                    <span class="text-amber-300 font-bold">{{ $centers->count() ?? 0 }}</span>
                    <span class="text-white/90">{{ __('index.cta.count_suffix') }}</span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    {{ __('index.cta.title') }}
                </h2>
                <p class="text-xl text-white/70 mb-10 leading-relaxed">
                    {{ __('index.cta.description') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-button variant="secondary" size="lg" href="{{ route('course.create') }}"
                        class="bg-white text-indigo-600 hover:bg-gray-50 shadow-2xl shadow-black/20 hover:shadow-black/30 transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('index.cta.button') }}
                    </x-button>
                    <x-button variant="outline" size="lg" href="{{ route('centers') }}"
                        class="bg-white/10 backdrop-blur-sm border-white/30 text-white hover:bg-white/20 transition-all duration-300 hover:-translate-y-0.5">
                        {{ __('index.cta.explore') }}
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="support" class="py-24 bg-gray-50 dark:bg-gray-900 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-pink-500/5 rounded-full blur-2xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-800/50 text-emerald-700 dark:text-emerald-300 text-sm font-semibold mb-4 transition-colors">
                    {{ __('index.contact.badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ __('index.contact.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed transition-colors">
                    {{ __('index.contact.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Contact Information --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl opacity-20 group-hover:opacity-40 blur transition duration-500"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 overflow-hidden h-full border border-gray-200 dark:border-gray-700 transition-colors">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 transition-colors">
                                {{ __('index.contact.contact_us') }}
                            </h3>

                            <div class="space-y-6">
                                {{-- Email --}}
                                <a href="mailto:husniddin13124041@gmail.com" class="flex items-start space-x-4 group/item hover:bg-gray-100 dark:hover:bg-gray-700/50 p-3 rounded-xl transition-colors">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/25">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1 transition-colors">{{ __('index.contact.email') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400 group-hover/item:text-blue-600 dark:group-hover/item:text-blue-400 transition-colors">husniddin13124041@gmail.com</p>
                                    </div>
                                </a>

                                {{-- Address --}}
                                <div class="flex items-start space-x-4 p-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/25">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1 transition-colors">{{ __('index.contact.address') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400 transition-colors">{{ __('index.contact.address_value') }}</p>
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <a href="tel:+998770252677" class="flex items-start space-x-4 group/item hover:bg-gray-100 dark:hover:bg-gray-700/50 p-3 rounded-xl transition-colors">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-purple-500/25">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1 transition-colors">{{ __('index.contact.phone') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400 group-hover/item:text-purple-600 dark:group-hover/item:text-purple-400 transition-colors">+998 77 025 26 77</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Social Media --}}
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 transition-colors">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4 transition-colors">{{ __('index.contact.social') }}</h4>
                                <div class="flex gap-3">
                                    <a href="https://t.me/matritsachi" target="_blank" class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg shadow-blue-500/25">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56c-.21 2.26-1.12 7.73-1.58 10.26-.2 1.08-.58 1.44-.96 1.47-.82.07-1.44-.54-2.23-1.06-1.24-.82-1.94-1.33-3.14-2.13-1.39-.91-.49-1.41.31-2.22.21-.22 3.86-3.54 3.93-3.84.01-.04.01-.18-.07-.26s-.2-.05-.29-.03c-.12.03-2.09 1.33-5.91 3.91-.56.38-1.06.57-1.52.56-.5-.01-1.46-.28-2.18-.51-.88-.28-1.57-.43-1.51-.91.03-.25.38-.51 1.05-.78 4.1-1.79 6.83-2.97 8.18-3.56 3.91-1.63 4.71-1.91 5.22-1.92.12 0 .37.03.54.16.14.11.18.26.2.41-.01.06 0 .19-.01.3z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl opacity-20 group-hover:opacity-40 blur transition duration-500"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 h-full border border-gray-200 dark:border-gray-700 transition-colors">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 transition-colors">
                            {{ __('index.contact.form.title') }}
                        </h3>

                        <form class="space-y-5" id="contactForm">
                            @csrf
                            <div id="successMessage" class="hidden mb-4 p-4 bg-emerald-100 dark:bg-emerald-800/50 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 rounded-xl transition-colors">
                                {{ __('index.contact.form.success') }}
                            </div>
                            <div id="errorMessage" class="hidden mb-4 p-4 bg-rose-100 dark:bg-rose-800/50 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-300 rounded-xl transition-colors">
                                {{ __('index.contact.form.error') }}
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors">{{ __('index.contact.form.fullname') }}</label>
                                    <input type="text" name="fullname" placeholder="{{ __('index.contact.form.fullname_placeholder') }}"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none text-gray-900 dark:text-white" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors">{{ __('index.contact.form.email') }}</label>
                                    <input type="email" name="email" placeholder="{{ __('index.contact.form.email_placeholder') }}"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none text-gray-900 dark:text-white" required />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors">{{ __('index.contact.form.message') }}</label>
                                <textarea name="message" rows="4" placeholder="{{ __('index.contact.form.message_placeholder') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none resize-none text-gray-900 dark:text-white" required></textarea>
                            </div>

                            <button type="submit" id="submitBtn"
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 hover:-translate-y-0.5">
                                {{ __('index.contact.form.submit') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Form JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', handleFormSubmit);
            }
        });

        function handleFormSubmit(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');

            submitBtn.disabled = true;
            submitBtn.textContent = '{{ __('index.contact.form.sending') }}';

            const formData = new FormData(form);

            fetch('/send-message', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successMessage.classList.remove('hidden');
                        form.reset();
                        setTimeout(() => { successMessage.classList.add('hidden'); }, 5000);
                    } else {
                        errorMessage.classList.remove('hidden');
                        form.reset();
                        setTimeout(() => { errorMessage.classList.add('hidden'); }, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.classList.remove('hidden');
                    setTimeout(() => { errorMessage.classList.add('hidden'); }, 5000);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = '{{ __('index.contact.form.submit') }}';
                });
        }
    </script>
</x-layout>
