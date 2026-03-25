<footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/2.png') }}" alt="FindCourse" class="w-10 h-10 rounded-full">
                    <span class="text-xl font-bold gradient-text">FindCourse</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                    {{ __('footer.description') }}
                </p>
                <div class="flex items-center space-x-4">
                    <a href="https://t.me/lcway_channel" target="_blank"
                        class="w-10 h-10 bg-blue-500 rounded-lg text-white hover:bg-blue-600 transition-colors flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56c-.21 2.24-1.12 7.65-1.58 10.15-.2 1.07-.58 1.42-.96 1.46-.81.07-1.43-.53-2.21-1.04-1.23-.81-1.92-1.31-3.11-2.1-1.38-.91-.49-1.41.3-2.23.21-.21 3.77-3.45 3.84-3.74.01-.04.01-.18-.07-.26s-.2-.05-.29-.03c-.12.03-2.09 1.33-5.91 3.91-.56.38-1.06.57-1.52.56-.5-.01-1.46-.28-2.18-.51-.88-.28-1.57-.43-1.51-.91.03-.25.38-.51 1.04-.78 4.08-1.78 6.8-2.95 8.16-3.52 3.89-1.62 4.69-1.9 5.2-1.91.12 0 .37.03.54.17.14.12.18.28.2.44-.01.06 0 .24-.02.36z" />
                        </svg>
                    </a>
                    <p class="text-xs">{{ __('footer.telegram') }}</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('footer.quick_links') }}</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('index') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index') }}#features"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.about') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog-grid') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.centers') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.create') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.add_center') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('footer.services') }}</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="#!"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.fullstack') }}
                        </a>
                    </li>
                    <li>
                        <a href="#!"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.frontend') }}
                        </a>
                    </li>
                    <li>
                        <a href="#!"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.backend') }}
                        </a>
                    </li>
                    <li>
                        <a href="#!"
                            class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm">
                            {{ __('footer.ui_ux') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('footer.contact') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ __('footer.phone') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ __('footer.email') }}</span>
                    </div>
                    <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ __('footer.location') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ str_replace(':year', date('Y'), __('footer.copyright')) }}
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#!"
                        class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        {{ __('footer.privacy_policy') }}
                    </a>
                    <a href="#!"
                        class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        {{ __('footer.terms_of_service') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
