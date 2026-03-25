<x-layout>
    <x-slot:title>{{ __('signup.title') }}</x-slot:title>

    <div
        class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-purple-900/20">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-blue-200/20 to-blue-300/20 dark:bg-blue-400/10 rounded-full blur-3xl animate-pulse">
            </div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-br from-purple-200/20 to-purple-300/20 dark:bg-purple-400/10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-br from-indigo-200/15 to-indigo-300/15 dark:bg-indigo-400/8 rounded-full blur-2xl animate-pulse"
                style="animation-delay: 2s"></div>
        </div>

        <!-- Sign Up Card -->
        <div class="relative z-10 w-full max-w-md px-4">
            <div
                class="border rounded-2xl border-gray-200/60 backdrop-blur-xl bg-white dark:bg-gray-800/95 shadow-2xl dark:shadow-black/20 border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg">
                            <img src="{{ asset('images/2.png') }}" alt="FindCourse"
                                class="w-16 h-16 rounded-full">
                        </div>
                        <h2
                            class="text-gray-900 dark:text-white text-2xl font-bold mb-2 bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            {{ __('signup.header.title') }}</h2>
                        <p class="mb-2 text-gray-600 dark:text-gray-300">{{ __('signup.header.subtitle') }}</p>
                    </div>

                    <!-- Social Login -->
                    <div class="mb-6">
                        <a href="{{ route('google.redirect') }}"
                            class="w-full flex items-center justify-center px-4 py-3 transition-all duration-300 group bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl shadow-md hover:shadow-lg hover:bg-gray-50 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span class="font-medium">{{ __('signup.social_login.google') }}</span>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span
                                class="px-4 bg-white/80 dark:bg-transparent text-gray-500 dark:text-gray-400 font-medium">{{ __('signup.divider') }}</span>
                        </div>
                    </div>

                    <!-- Sign Up Form -->
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Error Messages -->
                        @error('name')
                            <div
                                class="px-4 py-3 rounded-xl text-sm bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('email')
                            <div
                                class="px-4 py-3 rounded-xl text-sm bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('password')
                            <div
                                class="px-4 py-3 rounded-xl text-sm bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Full Name Field -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                                {{ __('signup.form.name_label') }}
                            </label>
                            <input type="text" name="name" id="name" placeholder="{{ __('signup.form.name_placeholder') }}"
                                class="border rounded-lg px-4 py-3 w-full transition-all duration-200 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:focus:border-blue-400 dark:focus:ring-blue-400/20 shadow-sm hover:shadow-md hover:border-gray-400 dark:hover:border-gray-500"
                                required />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                                {{ __('signup.form.email_label') }}
                            </label>
                            <input type="email" name="email" id="email" placeholder="{{ __('signup.form.email_placeholder') }}"
                                class="border rounded-lg px-4 py-3 w-full transition-all duration-200 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:focus:border-blue-400 dark:focus:ring-blue-400/20 shadow-sm hover:shadow-md hover:border-gray-400 dark:hover:border-gray-500"
                                required />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                                {{ __('signup.form.password_label') }}
                            </label>
                            <input type="password" name="password" id="password" placeholder="{{ __('signup.form.password_placeholder') }}"
                                class="border rounded-lg px-4 py-3 w-full transition-all duration-200 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:focus:border-blue-400 dark:focus:ring-blue-400/20 shadow-sm hover:shadow-md hover:border-gray-400 dark:hover:border-gray-500"
                                required />
                        </div>

                        <!-- Terms & Privacy -->
                        <div class="flex items-start">
                            <input type="checkbox" name="terms"
                                class="mt-1 rounded transition-colors duration-200 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-blue-600 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 focus:ring-offset-2 dark:focus:ring-offset-0 hover:border-blue-400 dark:hover:border-blue-500"
                                required>
                            <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('signup.terms.text') }} <a href="#"
                                    class="transition-colors text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline">{{ __('signup.terms.terms_link') }}</a> va
                                <a href="#"
                                    class="transition-colors text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline">{{ __('signup.terms.privacy_link') }}</a> {{ __('signup.terms.agreement') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white shadow-lg hover:shadow-xl focus:ring-blue-500/50 dark:focus:ring-offset-gray-800 dark:from-blue-500 dark:to-blue-600 dark:hover:from-blue-600 dark:hover:to-blue-700 hover:shadow-blue-500/25">{{ __('signup.form.submit') }}</button>
                    </form>

                    <!-- Sign In Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('signup.signin.text') }}
                            <a href="{{ route('signin') }}"
                                class="font-medium transition-colors text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                                {{ __('signup.signin.link') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
