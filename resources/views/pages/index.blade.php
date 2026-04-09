<x-layout>
    <x-slot:title>{{ __('index.title') }}</x-slot:title>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Gradient -->
        <div
            class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 dark:from-primary-600 dark:via-accent-600 dark:to-primary-800">
        </div>

        <!-- Abstract Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight text-gray-900 dark:text-white">
                    {{ __('index.hero.greeting') }},<br>
                    <span class="text-yellow-600 dark:text-yellow-300">
                        Findora
                    </span>
                    {{ __('index.hero.welcome') }}
                </h1>

                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed text-gray-700 dark:text-white/90">
                    {{ __('index.hero.description') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <x-button variant="secondary" size="lg" href="{{ route('centers') }}"
                        class="bg-white text-primary-600 hover:bg-gray-50 dark:hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('index.hero.browse_courses') }}
                    </x-button>

                    <x-button variant="outline" size="lg"
                        class="border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-primary-600 dark:border-white dark:text-white dark:hover:bg-white dark:hover:text-primary-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        (+998) 77 025 026 77
                    </x-button>
                </div>

                <p class="text-sm text-gray-600 dark:text-white/80">
                    {{ __('index.hero.contact_info') }}
                </p>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-400 dark:text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.features.teacher_selection.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.features.teacher_selection.description') }}
                </div>

                <!-- Feature 2 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-success-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.features.nationwide.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.features.nationwide.description') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-warning-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.features.ratings.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.features.ratings.description') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="relative z-0">
                        <x-optimized-image src="{{ asset('images/we1.webp') }}" alt="About"
                            class="rounded-2xl shadow-xl" width="600" height="400" eager="{{ true }}"
                            fetchpriority="high" />
                    </div>
                    <div class="absolute -bottom-4 -right-4 z-10">
                        <x-optimized-image src="{{ asset('images/we2.webp') }}" alt="About"
                            class="rounded-2xl shadow-xl opacity-80 w-32 h-32 object-cover" width="128" height="128"
                            eager="{{ true }}" fetchpriority="high" />
                    </div>
                    <div class="absolute -top-4 -left-4 z-10">
                        <x-optimized-image src="{{ asset('images/we3.webp') }}" alt="About"
                            class="rounded-2xl shadow-xl opacity-60 w-32 h-32 object-cover" width="128" height="128"
                            eager="{{ true }}" fetchpriority="high" />
                    </div>
                </div>

                <div>
                    <x-badge variant="primary" class="mb-4">{{ __('index.about.badge') }}</x-badge>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ __('index.about.title') }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        {{ __('index.about.description') }}
                    </p>

                    <div class="flex flex-col space-y-4">
                        <button onclick="openVideoModal()" class="relative group w-full">
                            <div class="relative w-full">
                                <video src="{{ asset('videos/aboutme.mp4') }}"
                                    class="w-full h-85 object-cover rounded-lg shadow-md group-hover:shadow-lg transition-shadow"
                                    muted preload="none" id="videoThumbnail">
                                </video>
                                <div
                                    class="absolute inset-0 bg-black/30 rounded-lg flex items-center justify-center group-hover:bg-black/20 transition-colors">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <div
                                    class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                    {{ __('index.about.video_question') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('index.about.watch_video') }}</div>
                            </div>
                        </button>
                    </div>

                    <!-- Video Modal -->
                    <div id="videoModal"
                        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
                        <div class="relative w-full max-w-4xl mx-4">

                            <!-- Close Button -->
                            <button onclick="closeVideoModal()"
                                class="absolute top-4 right-4 z-10 hover:bg-white/30 text-white p-3 rounded-full transition-all backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Video Player -->
                            <video id="videoPlayer" class="w-full rounded-lg shadow-2xl" controls preload="none">
                                <source src="{{ asset('videos/aboutme.mp4') }}" type="video/mp4">
                                {{ __('index.about.video_not_supported') }}.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('index.services.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('index.services.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.startup_development.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('index.services.startup_development.description') }}</p>
                </x-card>

                <!-- Service 2 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.high_quality_design.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('index.services.high_quality_design.description') }}</p>
                </x-card>

                <!-- Service 3 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-success-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.websites.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.services.websites.description') }}</p>
                </x-card>

                <!-- Service 4 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-warning-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.optimal_speed.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.services.optimal_speed.description') }}</p>
                </x-card>

                <!-- Service 5 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-danger-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.full_compatibility.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('index.services.full_compatibility.description') }}</p>
                </x-card>

                <!-- Service 6 -->
                <x-card hover class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-900 dark:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('index.services.both_sides.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('index.services.both_sides.description') }}</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('index.featured_courses.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('index.featured_courses.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @if (isset($centers) && $centers->count() > 0)
                    @foreach ($centers->take(8) as $center)
                        <x-card hover
                            class="group cursor-pointer bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl transition-all duration-300">
                            <div class="relative overflow-hidden rounded-t-2xl">
                                @if ($center->logo)
                                    @if(str_starts_with($center->logo, 'http://') || str_starts_with($center->logo, 'https://'))
                                        <x-optimized-image src="{{ $center->logo }}" alt="{{ $center->name }}"
                                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                            width="400" height="192" eager="{{ true }}" fetchpriority="high" />
                                    @else
                                        <x-optimized-image src="{{ asset('storage/' . $center->logo) }}" alt="{{ $center->name }}"
                                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                            width="400" height="192" eager="{{ true }}" fetchpriority="high" />
                                    @endif
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 dark:from-indigo-600 dark:to-purple-800 flex items-center justify-center">
                                        <div class="text-white text-center px-4">
                                            <div class="text-2xl font-bold mb-1">{{ $center->type }}</div>
                                            <div class="text-sm opacity-90">{{ $center->name }}</div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Rating Badge -->
                                <div
                                    class="absolute top-4 right-4 bg-white dark:bg-gray-800 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-lg border border-gray-200 dark:border-gray-600">
                                    @php
                                        $average = $center->rating;
                                    @endphp
                                    <div class="flex items-center space-x-1">
                                        <span class="text-amber-500 dark:text-yellow-400 text-sm font-semibold">★</span>
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $average }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="mb-4">
                                    <h3
                                        class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ Str::limit($center->name, 30) }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $center->type }}</p>
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ Str::limit($center->address, 25) }}
                                    </div>
                                </div>

                                @if ($center->subjects->count() > 0)
                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach ($center->subjects->take(2) as $subject)
                                            <span
                                                class="px-2 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-xs rounded-full">
                                                {{ $subject->subject_name }}
                                            </span>
                                        @endforeach
                                        @if ($center->subjects->count() > 2)
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">
                                                +{{ $center->subjects->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between">
                                    @if ($center->subjects->count() > 0)
                                        <div>
                                            <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                                {{ $center->subjects->min('price') ?? 0 }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ __('index.featured_courses.per_month') }}</p>
                                        </div>
                                    @endif

                                    <x-button variant="outline" size="sm" href="{{ route('center', $center->slug) }}">
                                        {{ __('index.featured_courses.details') }}
                                    </x-button>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                @else
                    <!-- Placeholder cards when no centers -->
                    @for ($i = 1; $i <= 4; $i++)
                        <x-card hover>
                            <div
                                class="h-48 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 rounded-t-2xl">
                            </div>
                            <div class="p-6">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded mb-4"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                            </div>
                        </x-card>
                    @endfor
                @endif
            </div>

            <div class="text-center mt-12">
                <x-button variant="primary" size="lg" href="{{ route('centers') }}"
                    class="dark:bg-primary-600 text-gray-900 dark:text-white dark:hover:bg-primary-700">
                    {{ __('index.featured_courses.view_all') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </x-button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('index.categories.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('index.categories.description') }}
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                @php
                    $categories = __('index.categories.items');
                @endphp

                @foreach ($categories as $category)
                    <x-badge variant="primary"
                        class="px-4 py-2 text-sm hover:scale-105 transition-transform cursor-pointer">
                        {{ $category }}
                    </x-badge>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('index.testimonials.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('index.testimonials.description') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <x-optimized-image src="https://ui-avatars.com/api/?name=Ali+Valiyev&background=random&size=100"
                            alt="Ali Valiyev" class="w-20 h-20 rounded-full mx-auto mb-4" width="80" height="80" />
                        <div class="flex justify-center mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('index.testimonials.testimonial1.name') }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('index.testimonials.testimonial1.role') }}</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "{{ __('index.testimonials.testimonial1.content') }}"
                    </blockquote>
                </x-card>

                <!-- Testimonial 2 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <x-optimized-image
                            src="https://ui-avatars.com/api/?name=Malika+Karimova&background=random&size=100"
                            alt="Malika Karimova" class="w-20 h-20 rounded-full mx-auto mb-4" width="80" height="80" />
                        <div class="flex justify-center mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('index.testimonials.testimonial2.name') }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('index.testimonials.testimonial2.role') }}</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "{{ __('index.testimonials.testimonial2.content') }}"
                    </blockquote>
                </x-card>

                <!-- Testimonial 3 -->
                <x-card hover class="text-center">
                    <div class="mb-6">
                        <x-optimized-image
                            src="https://ui-avatars.com/api/?name=Javohir+Toshmatov&background=random&size=100"
                            alt="Javohir Toshmatov" class="w-20 h-20 rounded-full mx-auto mb-4" width="80"
                            height="80" />
                        <div class="flex justify-center mb-2">
                            @for ($i = 1; $i <= 4; $i++)
                                <span class="text-yellow-400 text-lg">★</span>
                            @endfor
                            <span class="text-yellow-400 text-lg opacity-30">★</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('index.testimonials.testimonial3.name') }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('index.testimonials.testimonial3.role') }}</p>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 italic">
                        "{{ __('index.testimonials.testimonial3.content') }}"
                    </blockquote>
                </x-card>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-accent-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full bg-repeat"
                style="background-image: url('data:image/svg+xml,%3Csvg width=" 60" height="60" viewBox="0 0 60 60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none" fill-rule="evenodd" %3E%3Cg fill="%23ffffff"
                fill-opacity="0.4" %3E%3Cpath
                d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 text-gray-900 dark:text-white mb-4">
                    {{ __('index.cta.title') }}: <span class="text-yellow-300">{{ $centers->count() ?? 0 }}
                        {{ __('index.cta.count_suffix') }}</span>
                </h2>
                <p class="text-xl text-white/90 mb-8">
                    {{ __('index.cta.description') }}
                </p>
                <x-button variant="secondary" size="lg" href="{{ route('course.create') }}"
                    class="bg-white text-primary-600 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('index.cta.button') }}
                </x-button>
            </div>
        </div>
    </section>

    <!-- ===== Contact Start ===== -->
    <!-- ===== Contact Section ===== -->
    <section id="support" class="py-20 bg-white relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-500/5 rounded-full blur-2xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <!-- Section Title -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    {{ __('index.contact.title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                    {{ __('index.contact.description') }}
                </p>
            </div>

            <!-- Contact Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute top-4 right-4 w-32 h-32 bg-blue-500 rounded-full"></div>
                        <div class="absolute bottom-4 left-4 w-24 h-24 bg-purple-500 rounded-full"></div>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                            {{ __('index.contact.contact_us') }}</h3>

                        <!-- Contact Items -->
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4 group">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ __('index.contact.email') }}</h4>
                                    <a href="mailto:husniddin13124041@gmail.com"
                                        class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        husniddin13124041@gmail.com
                                    </a>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start space-x-4 group">
                                <div
                                    class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ __('index.contact.address') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        M254+HFP, улица Усто Умара Джуракулова, Samarqand, Samarqand viloyati,
                                        Uzbekistan
                                    </p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start space-x-4 group">
                                <div
                                    class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 dark:group-hover:bg-purple-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ __('index.contact.phone') }}</h4>
                                    <a href="tel:+998770252677"
                                        class="text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                        +998 77 025 26 77
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">
                                {{ __('index.contact.social') }}</h4>
                            <div class="flex space-x-3">
                                <a href="https://t.me/matritsachi" target="_blank"
                                    class="w-12 h-12 bg-blue-500 hover:bg-blue-600 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56c-.21 2.26-1.12 7.73-1.58 10.26-.2 1.08-.58 1.44-.96 1.47-.82.07-1.44-.54-2.23-1.06-1.24-.82-1.94-1.33-3.14-2.13-1.39-.91-.49-1.41.31-2.22.21-.22 3.86-3.54 3.93-3.84.01-.04.01-.18-.07-.26s-.2-.05-.29-.03c-.12.03-2.09 1.33-5.91 3.91-.56.38-1.06.57-1.52.56-.5-.01-1.46-.28-2.18-.51-.88-.28-1.57-.43-1.51-.91.03-.25.38-.51 1.05-.78 4.1-1.79 6.83-2.97 8.18-3.56 3.91-1.63 4.71-1.91 5.22-1.92.12 0 .37.03.54.16.14.11.18.26.2.41-.01.06 0 .19-.01.3z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                        {{ __('index.contact.form.title') }}</h3>

                    <form class="space-y-6" id="contactForm">
                        @csrf
                        <div id="successMessage"
                            class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                            {{ __('index.contact.form.success') }}
                        </div>
                        <div id="errorMessage"
                            class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                            {{ __('index.contact.form.error') }}
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('index.contact.form.fullname') }}
                                </label>
                                <input type="text" name="fullname" placeholder="Husniddin"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300" required />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('index.contact.form.email') }}
                                </label>
                                <input type="email" name="email" placeholder="husniddin@gmail.com"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300" required />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('index.contact.form.message') }}
                            </label>
                            <textarea name="message" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300"
                                required></textarea>
                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full bg-blue-600 text-white py-4 rounded-xl cursor-pointer">
                            {{ __('index.contact.form.submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->

    <!-- Video Modal JavaScript -->
    <script>
        // Set video thumbnail to show frame at 17 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const videoThumbnail = document.getElementById('videoThumbnail');
            if (videoThumbnail) {
                videoThumbnail.currentTime = 17;
                videoThumbnail.pause();
            }

            // Handle contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', handleFormSubmit);
            }
        });

        // Handle form submission with AJAX
        function handleFormSubmit(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            // Hide messages
            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Yuborilmoqda...';

            // Get form data
            const formData = new FormData(form);

            // Send AJAX request
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
                        // Show success message
                        successMessage.classList.remove('hidden');
                        // Reset form
                        form.reset();
                        // Hide success message after 5 seconds
                        setTimeout(() => {
                            successMessage.classList.add('hidden');
                        }, 5000);
                    } else {
                        // Show error message
                        errorMessage.classList.remove('hidden');
                        // Reset form
                        form.reset();
                        // Hide error message after 5 seconds
                        setTimeout(() => {
                            errorMessage.classList.add('hidden');
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.classList.remove('hidden');
                    // Hide error message after 5 seconds
                    setTimeout(() => {
                        errorMessage.classList.add('hidden');
                    }, 5000);
                })
                .finally(() => {
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Xabarni yuborish';
                });
        }

        function openVideoModal() {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('videoPlayer');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            video.play();
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('videoPlayer');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            video.pause();
            video.currentTime = 0;
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the video
        document.getElementById('videoModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('videoModal');
                if (!modal.classList.contains('hidden')) {
                    closeVideoModal();
                }
            }
        });
    </script>
</x-layout>