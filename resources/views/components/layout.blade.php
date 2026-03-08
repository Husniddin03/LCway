<!DOCTYPE html>
<html lang="uz" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FindCourse - Eng yaxshi o\'quv markazlari' }}</title>
    <meta name="description"
        content="{{ $description ?? 'O\'zbekiston bo\'ylab eng yaxshi o\'quv markazlarini toping. Kurslar, ustozlar va baholash tizimi.' }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/lcwayfavicon.png') }}">

    <!-- TailwindCSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for reactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom animations for weekday editor */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slide-in-right 0.6s ease-out;
        }

        /* Dark mode text fixes */
        html.dark .text-gray-900 {
            color: rgb(243 244 246) !important;
        }

        html.dark .text-gray-800 {
            color: rgb(229 231 235) !important;
        }

        html.dark .text-gray-700 {
            color: rgb(209 213 219) !important;
        }

        html.dark .text-gray-600 {
            color: rgb(156 163 175) !important;
        }

        /* Light mode text fixes - only apply when not dark */
        html:not(.dark) .text-gray-900 {
            color: rgb(17 24 39) !important;
        }

        html:not(.dark) .text-gray-800 {
            color: rgb(31 41 55) !important;
        }

        html:not(.dark) .text-gray-700 {
            color: rgb(55 65 81) !important;
        }

        html:not(.dark) .text-gray-600 {
            color: rgb(75 85 99) !important;
        }

        /* Dark mode background fixes */
        html.dark .bg-white {
            background-color: rgb(31 41 55) !important;
        }

        html.dark .bg-gray-50 {
            background-color: rgb(17 24 39) !important;
        }

        html.dark .bg-gray-100 {
            background-color: rgb(31 41 55) !important;
        }

        /* Light mode background fixes - only apply when not dark */
        html:not(.dark) .bg-white {
            background-color: rgb(255 255 255) !important;
        }

        html:not(.dark) .bg-gray-50 {
            background-color: rgb(249 250 251) !important;
        }

        html:not(.dark) .bg-gray-100 {
            background-color: rgb(243 244 246) !important;
        }

        /* Border fixes */
        html.dark .border-gray-200 {
            border-color: rgb(55 65 81) !important;
        }

        html.dark .border-gray-300 {
            border-color: rgb(75 85 99) !important;
        }

        /* Light mode border fixes - only apply when not dark */
        html:not(.dark) .border-gray-200 {
            border-color: rgb(229 231 235) !important;
        }

        html:not(.dark) .border-gray-300 {
            border-color: rgb(209 213 219) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .animate-slide-in-left,
            .animate-slide-in-right {
                animation: fade-in 0.6s ease-out;
            }
        }

        /* Dark mode specific styles */
        @media (prefers-color-scheme: dark) {
            .filter.dark\:invert {
                filter: invert(1);
            }
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <!-- Navigation -->
    <x-navbar :transparent="$transparent ?? false" />

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Floating Action Buttons -->
    <div class="fixed bottom-6 right-6 flex flex-col space-y-3 z-40">
        <!-- Back to Top -->
        <button x-data="{ scrollTop: false }" x-init="window.addEventListener('scroll', () => scrollTop = window.pageYOffset > 300)" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-show="scrollTop" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>

        <!-- Chat Quiz -->
        <a href="{{ route('chat.quiz') }}"
            class="bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>

        <!-- Chat -->
        <a href="{{ route('chat.chat') }}"
            class="bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 bg-gradient-to-r from-primary-600 to-accent-600 p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div x-data="{
            show: true,
            init() {
                setTimeout(() => {
                    this.show = false;
                }, 5000);
            }
        }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed top-20 right-6 z-50 max-w-sm">
            <div
                class="bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-success-600 dark:text-success-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-success-800 dark:text-success-200">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button @click="show = false"
                        class="ml-4 text-success-600 dark:text-success-400 hover:text-success-800 dark:hover:text-success-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{
            show: true,
            init() {
                setTimeout(() => {
                    this.show = false;
                }, 5000);
            }
        }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed top-20 right-6 z-50 max-w-sm">
            <div
                class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-danger-600 dark:text-danger-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-danger-800 dark:text-danger-200">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button @click="show = false"
                        class="ml-4 text-danger-600 dark:text-danger-400 hover:text-danger-800 dark:hover:text-danger-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Theme initialization script -->
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
    </script>

    <!-- Scripts Stack -->
    @stack('scripts')

</body>

</html>
