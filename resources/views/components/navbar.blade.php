@props([
    'transparent' => false,
    'sticky' => true
])

@php
    $navClasses = $transparent 
        ? 'nav-transparent' 
        : 'nav-sticky bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700/50';
@endphp

<nav class="{{ $navClasses }} transition-all duration-300" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('index') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-600 to-accent-600 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/lcwayfavicon.png') }}" alt="FindCourse" class="w-8 h-8 rounded-full">
                    </div>
                    <span class="text-xl font-bold gradient-text sm:block">FindCourse</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="{{ route('index') }}" class="text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 relative group">
                        Asosiy
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                    </a>
                    <a href="{{ route('blog-grid') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 relative group">
                        O'quv markazlar
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                    </a>
                    <a href="{{ route('course.create') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 relative group">
                        Markaz qo'shish
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                    </a>
                    
                    <!-- Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 inline-flex items-center relative group">
                            Sahifalar
                            <svg class="ml-2 h-4 w-4 transition-transform" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </button>
                        
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-xl shadow-floating bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none border border-gray-200 dark:border-gray-700">
                            <div class="py-2">
                                <a href="{{ route('index') }}#features" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    Biz haqimizda
                                </a>
                                <a href="{{ route('index') }}#support" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    Qo'llab-quvvatlash
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side items -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Theme toggle button -->
                <button onclick="toggleTheme()" class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200" title="Rejimni o'zgartirish">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg id="theme-icon-sun" class="h-5 w-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg id="theme-icon-moon" class="h-5 w-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Auth buttons -->
                @auth
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                            @isset(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full ring-2 ring-primary-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-900">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&size=32" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full ring-2 ring-primary-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-900">
                            @endisset
                        </button>
                        
                        <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-xl shadow-floating bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none border border-gray-200 dark:border-gray-700">
                            <div class="py-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        Chiqish
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('signin') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200">
                        Kirish
                    </a>
                    <x-button variant="primary" href="{{ route('signup') }}">
                        Ro'yxatdan o'tish
                    </x-button>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                    <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-gray-800 rounded-xl shadow-floating mt-2 border border-gray-200 dark:border-gray-700">
                <!-- Theme toggle for mobile -->
                <div class="px-3 py-2">
                    <button 
                        onclick="toggleTheme()"
                        class="flex items-center space-x-2 w-full p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200"
                    >
                        <!-- Sun icon (shown in dark mode) -->
                        <svg class="h-5 w-5 hidden dark:block text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        
                        <!-- Moon icon (shown in light mode) -->
                        <svg class="h-5 w-5 block dark:hidden text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            Rejimni o'zgartirish
                        </span>
                    </button>
                </div>
                
                <a href="{{ route('index') }}" class="text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    Asosiy
                </a>
                <a href="{{ route('blog-grid') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    O'quv markazlar
                </a>
                <a href="{{ route('course.create') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    Markaz qo'shish
                </a>
                
                @guest
                    <a href="{{ route('signin') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                        Kirish
                    </a>
                    <a href="{{ route('signup') }}" class="bg-gradient-to-r from-primary-600 to-accent-600 text-white block px-3 py-2 rounded-md text-base font-medium">
                        Ro'yxatdan o'tish
                    </a>
                @endguest
                
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 block w-full text-left px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                            Chiqish
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
