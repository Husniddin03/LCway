<x-layout>
    <x-slot:title>Kirish sahifasi</x-slot:title>
    
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-blue-800 dark:from-primary-600 dark:via-accent-600 dark:to-primary-800">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>
        
        <!-- Sign In Card -->
        <div class="relative z-10 w-full max-w-md px-4">
            <div class="border border-white/20 backdrop-blur-xl bg-white/95 dark:bg-gray-900/95 border-gray-200 dark:border-white/20">
                <div class="p-8">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl mb-4">
                            <img src="{{ asset('images/lcwayfavicon.png') }}" alt="FindCourse" class="w-10 h-10 rounded-full">
                        </div>
                        <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-white">Hisobingizga kirish</h2>
                        <p class="mb-2 text-gray-600 dark:text-white/80">FindCourse platformasiga xush kelibsiz</p>
                    </div>
                    
                    <!-- Social Login -->
                    <div class="mb-6">
                        <a href="{{ route('google.redirect') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 transition-all duration-300 group bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="font-medium">Google bilan kirish</span>
                        </a>
                    </div>
                    
                    <!-- Divider -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-white/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-transparent text-gray-600 dark:text-white/80">Yoki email bilan</span>
                        </div>
                    </div>
                    
                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Error Messages -->
                        @error('email')
                            <div class="px-4 py-3 rounded-xl text-sm bg-red-50 dark:bg-danger-500/20 border-red-200 dark:border-danger-500/50 text-red-800 dark:text-danger-200">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @error('password')
                            <div class="px-4 py-3 rounded-xl text-sm bg-red-50 dark:bg-danger-500/20 border-red-200 dark:border-danger-500/50 text-red-800 dark:text-danger-200">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 text-gray-700 dark:text-white/90">
                                Email manzil
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="example@gmail.com"
                                class="border rounded-lg px-4 py-3 w-full transition-colors duration-200 bg-white dark:bg-white/10 border-gray-300 dark:border-white/20 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/50 focus:border-primary-500 focus:ring-primary-500 dark:focus:border-white/40 dark:focus:ring-white/20"
                                required
                            />
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 text-gray-700 dark:text-white/90">
                                Parol
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="•••••••••"
                                class="border rounded-lg px-4 py-3 w-full transition-colors duration-200 bg-white dark:bg-white/10 border-gray-300 dark:border-white/20 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/50 focus:border-primary-500 focus:ring-primary-500 dark:focus:border-white/40 dark:focus:ring-white/20"
                                required
                            />
                        </div>
                        
                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded transition-colors duration-200 border-gray-300 dark:border-white/20 bg-white dark:bg-white/10 text-primary-600 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-0">
                                <span class="ml-2 text-sm text-gray-600 dark:text-white/80">Eslab qolish</span>
                            </label>
                            
                            <a href="#" class="text-sm transition-colors text-primary-600 hover:text-primary-700 dark:text-white/80 dark:hover:text-white">
                                Parolni unutdingizmi?
                            </a>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 dark:bg-white dark:text-primary-600 dark:hover:bg-gray-100 dark:focus:ring-white/50"
                            Kirish
                        </button>
                    </form>
                    
                    <!-- Sign Up Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 dark:text-white/80">
                            Hisobingiz yo'qmi? 
                            <a href="{{ route('signup') }}" class="font-medium transition-colors text-primary-600 hover:text-primary-700 dark:text-white dark:hover:text-white/90">
                                Ro'yxatdan o'ting
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
