<x-layout>
    <x-slot:title>Ijtimoiy tarmoqlar - {{ $LearningCenter->name }}</x-slot:title>
    
    <!-- Modern Social Networks Section -->
    <section class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gradient-to-r from-blue-400 to-cyan-400 dark:from-blue-600 dark:to-cyan-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-gradient-to-r from-purple-400 to-pink-400 dark:from-purple-600 dark:to-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-20 left-20 w-80 h-80 bg-gradient-to-r from-green-400 to-teal-400 dark:from-green-600 dark:to-teal-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Section Title -->
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-full mb-6">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ijtimoiy tarmoqlar</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 dark:from-blue-400 dark:via-cyan-400 dark:to-teal-400 mb-6 leading-tight">
                    {{ $LearningCenter->name }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Ijtimoiy tarmoqlar orqali bog'lanish yo'llarini boshqaring
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Current Connections -->
                <div class="animate-slide-in-left">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50 relative overflow-hidden group">
                        <!-- Glassmorphism effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 via-cyan-400/10 to-teal-400/10 dark:from-blue-600/10 dark:via-cyan-600/10 dark:to-teal-600/10 rounded-3xl"></div>
                        
                        <!-- Floating icon -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-2xl"></div>
                        
                        <div class="relative">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    Joriy bog'lanishlar
                                </h2>
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                                    <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">{{ $LearningCenter->connections->count() }}</span>
                                </span>
                            </div>
                            
                            <!-- Learning Center Info -->
                            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-800/50">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $LearningCenter->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $LearningCenter->type }}
                                </p>
                            </div>
                            
                            <!-- Connections List -->
                            <div class="space-y-3">
                                @if ($LearningCenter->connections->count() > 0)
                                    @foreach ($LearningCenter->connections as $connection)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600/50 transition-all duration-200 group/item">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 text-white-100 bg-white-100 dark:bg-gray-50 rounded-lg flex items-center justify-center shadow-sm">
                                                    @if ($connection->connection->name == 'Phone')
                                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                        </svg>
                                                    @elseif($connection->connection->name == 'Email')
                                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                        </svg>
                                                    @elseif($connection->connection->name == 'Website')
                                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zM9.954 4.569c-.768 1.135-1.063 2.643-1.153 4.431h2.988c-.09-1.788-.385-3.296-1.153-4.431a6.016 6.016 0 00-.682 0zM14.917 9h-1.946c-.089 1.546-.383 2.97-.837 4.118A6.004 6.004 0 0014.917 9zM9.954 15.431c.768-1.135 1.063-2.643 1.153-4.431H8.119c.09 1.788.385 3.296 1.153 4.431a6.016 6.016 0 00.682 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @else
                                                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg" width="20" height="20" alt="{{ $connection->connection->name }}" />
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $connection->connection->name }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $connection->url }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="flex items-center space-x-2 opacity-0 group-hover/item:opacity-100 transition-opacity">
                                                <a href="{{ $connection->connection->name == 'Phone' ? 'tel:' . $connection->url : ($connection->connection->name == 'Email' ? 'mailto:' . $connection->url : $connection->url) }}" 
                                                    target="{{ $connection->connection->name == 'Phone' || $connection->connection->name == 'Email' ? '_self' : '_blank' }}"
                                                    class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Ochish">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('connect.delete', $connection->id) }}" method="POST" onsubmit="return confirm('Rostdan ham {{ $connection->connection->name }}ni o‘chirilsinmi?');">
                                                    @csrf
                                                    <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="O'chirish">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-8">
                                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300">Hozircha bog'lanishlar yo'q</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Connection Form -->
                <div class="animate-slide-in-right">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50">
                        <form action="{{ route('connect.store', ['id' => $LearningCenter->id]) }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Form Header -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Yangi bog'lanish qo'shish</h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">Ijtimoiy tarmoq yoki bog'lanish usulini tanlang</p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 00-1 1v4a1 1 0 102 2v-4a1 1 0 00-1-1zm-2 0a2 2 0 00-2 2v4a2 2 0 002 2h1a2 2 0 002-2v-4a2 2 0 00-2-2h-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-red-800 dark:text-red-200">Iltimos, xatolarni to'g'irlang:</h4>
                                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>• {{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form Fields -->
                            <div class="space-y-6">
                                <!-- Connection Type -->
                                <div class="space-y-2">
                                    <label for="connection_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        Bog'lanish turi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="connection_id" id="connection_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                        <option value="" disabled>Bog'lanish turini tanlang...</option>
                                        @foreach ($connections as $connection)
                                            <option value="{{ $connection->id }}">{{ $connection->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('connection_id')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- URL -->
                                <div class="space-y-2">
                                    <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        Manzil <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="url" id="url" placeholder="https://t.me/username yoki +998901234567" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                    @error('url')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Telegram, Instagram, Facebook, telefon raqam yoki email manzilini kiriting</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}" 
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Orqaga
                                </a>
                                <button type="submit"
                                        class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 hover:from-blue-700 hover:via-cyan-700 hover:to-teal-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
