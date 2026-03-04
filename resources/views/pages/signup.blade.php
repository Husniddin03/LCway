<x-layout>
    <x-slot:title>Ro'yxatdan o'tish</x-slot:title>
    
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800 relative overflow-hidden">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>
        
        <!-- Sign Up Card -->
        <div class="relative z-10 w-full max-w-md px-4">
            <x-card class="glass-dark border border-white/20 backdrop-blur-xl">
                <div class="p-8">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl mb-4">
                            <img src="{{ asset('images/lcwayfavicon.png') }}" alt="FindCourse" class="w-10 h-10 rounded-full">
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2">Ro'yxatdan o'tish</h2>
                        <p class="text-white/80">FindCourse platformasiga qo'shiling</p>
                    </div>
                    
                    <!-- Social Login -->
                    <div class="mb-6">
                        <a href="{{ route('google.redirect') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="font-medium">Google bilan ro'yxatdan o'tish</span>
                        </a>
                    </div>
                    
                    <!-- Divider -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-transparent text-white/80">Yoki email bilan</span>
                        </div>
                    </div>
                    
                    <!-- Sign Up Form -->
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Error Messages -->
                        @error('name')
                            <div class="bg-danger-500/20 border border-danger-500/50 text-danger-200 px-4 py-3 rounded-xl text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @error('email')
                            <div class="bg-danger-500/20 border border-danger-500/50 text-danger-200 px-4 py-3 rounded-xl text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @error('password')
                            <div class="bg-danger-500/20 border border-danger-500/50 text-danger-200 px-4 py-3 rounded-xl text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Full Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-white/90 mb-2">
                                To'liq ism
                            </label>
                            <x-input 
                                type="text" 
                                name="name" 
                                id="name" 
                                placeholder="John Doe"
                                class="bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-white/40 focus:ring-white/20"
                                required
                            />
                        </div>
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-white/90 mb-2">
                                Email manzil
                            </label>
                            <x-input 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="example@gmail.com"
                                class="bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-white/40 focus:ring-white/20"
                                required
                            />
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-white/90 mb-2">
                                Parol
                            </label>
                            <x-input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="••••••••"
                                class="bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-white/40 focus:ring-white/20"
                                required
                            />
                        </div>
                        
                        <!-- Terms & Privacy -->
                        <div class="flex items-start">
                            <input type="checkbox" name="terms" class="mt-1 rounded border-white/20 bg-white/10 text-primary-600 focus:ring-primary-500 focus:ring-offset-0" required>
                            <label for="terms" class="ml-2 text-sm text-white/80">
                                Men <a href="#" class="text-white hover:text-white/90 underline">Foydalanish shartlari</a> va 
                                <a href="#" class="text-white hover:text-white/90 underline">Maxfiylik siyosati</a> bilan tanishdim
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-white text-primary-600 py-3 px-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                            Ro'yxatdan o'tish
                        </button>
                    </form>
                    
                    <!-- Sign In Link -->
                    <div class="mt-6 text-center">
                        <p class="text-white/80">
                            Hisobingiz bormi? 
                            <a href="{{ route('signin') }}" class="text-white font-medium hover:text-white/90 transition-colors">
                                Kirish
                            </a>
                        </p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-layout>
