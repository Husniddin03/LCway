<x-layout>
    <x-slot:title>Profil</x-slot:title>
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-purple-900/20">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-blue-200/20 to-blue-300/20 dark:bg-blue-400/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-br from-purple-200/20 to-purple-300/20 dark:bg-purple-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-br from-indigo-200/15 to-indigo-300/15 dark:bg-indigo-400/8 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s"></div>
        </div>
        
        <!-- Profile Container -->
        <div class="relative z-10 container mx-auto px-4 py-12">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Card -->
                <div class="border rounded-2xl border-gray-200/60 backdrop-blur-xl bg-white/90 dark:bg-gray-800/95 shadow-2xl dark:shadow-black/20 border-gray-200 dark:border-gray-700">
                    <!-- Profile Header -->
                    <div class="relative h-32 bg-gradient-to-r from-primary-600 to-accent-600 rounded-t-2xl">
                        <div class="absolute -bottom-16 left-8">
                            <div class="relative">
                                @isset(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-32 h-32 rounded-full ring-4 ring-white dark:ring-gray-800 shadow-xl">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&size=128" alt="{{ Auth::user()->name }}" class="w-32 h-32 rounded-full ring-4 ring-white dark:ring-gray-800 shadow-xl">
                                @endisset
                                <div class="absolute bottom-2 right-2 w-8 h-8 bg-green-500 rounded-full ring-2 ring-white dark:ring-gray-800"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="pt-20 px-8 pb-8">
                        <div class="flex items-start justify-between mb-8">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ Auth::user()->name }}</h1>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Auth::user()->email }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ Auth::user()->created_at->format('d.m.Y') }} dan beri a'zo
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gradient-to-r from-primary-600 to-accent-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                Profilni tahrirlash
                            </a>
                        </div>
                        
                        <!-- Personal Information -->
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 mb-8">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Shaxsiy ma'lumotlar</h2>
                            @if($userData)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Ism</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userData->first_name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Familiya</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userData->last_name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Telefon raqami</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userData->phone }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jins</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userData->gender_uzbek }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tug'ilgan kun</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userData->formatted_birthday }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">Shaxsiy ma'lumotlar hali to'ldirilmagan</p>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-accent-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Ma'lumotlarni to'ldirish
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 border border-blue-200/50 dark:border-blue-700/50">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">0</span>
                                </div>
                                <h3 class="text-gray-700 dark:text-gray-300 font-medium">Qo'shilgan markazlar</h3>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 border border-green-200/50 dark:border-green-700/50">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">0</span>
                                </div>
                                <h3 class="text-gray-700 dark:text-gray-300 font-medium">Faol kurslar</h3>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-6 border border-purple-200/50 dark:border-purple-700/50">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">0</span>
                                </div>
                                <h3 class="text-gray-700 dark:text-gray-300 font-medium">Soatlar</h3>
                            </div>
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">So'nggi faoliyat</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Yangi markaz qo'shildi</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">2 kun oldin</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Profil yangilandi</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">5 kun oldin</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
