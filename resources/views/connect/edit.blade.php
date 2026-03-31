<x-layout>
    <x-slot:title>{{ __('connect-edit.title') }} - {{ $LearningCenter->name }}</x-slot:title>
    
    <section class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 dark:opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-400/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto">
            <div class="text-center mb-10 sm:mb-16 animate-fade-in">
                <div class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-4">
                    <span class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('connect-edit.header.badge') }}</span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 dark:from-blue-400 dark:via-cyan-400 dark:to-teal-400 mb-4 leading-tight">
                    {{ $LearningCenter->name }}
                </h1>
                <p class="text-base sm:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto px-4">
                    {{ __('connect-edit.header.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-12">
                <div class="order-2 lg:order-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl p-5 sm:p-8 border border-white/20 dark:border-gray-700/50">
                        <div class="relative">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    {{ __('connect-edit.current.title') }}
                                </h2>
                                <span class="px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-bold">
                                    {{ $LearningCenter->connections->count() }}
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                @forelse ($LearningCenter->connections as $connection)
                                    <div class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-transparent hover:border-blue-300 transition-all">
                                        <div class="flex items-center space-x-3 min-w-0">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white dark:bg-gray-600 rounded-lg flex items-center justify-center shadow-sm">
                                                @if ($connection->connection->icon)
                                                    <i class="{{ $connection->connection->icon }} text-blue-500"></i>
                                                @else
                                                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg" class="w-5 h-5 opacity-80" width="20" height="20" alt="{{ $connection->connection->name }}" />
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">{{ $connection->connection->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px] sm:max-w-xs">{{ $connection->url }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-1 sm:space-x-2">
                                            <a href="{{ in_array($connection->connection->name, ['Phone', 'Email']) ? ($connection->connection->name == 'Phone' ? 'tel:' : 'mailto:') . $connection->url : $connection->url }}" 
                                               target="_blank"
                                               class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                            <form action="{{ route('connect.delete', $connection->id) }}" method="POST" onsubmit="return confirm('O'chirishni xohlaysizmi?');">
                                                @csrf
                                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('connect-edit.current.no_connections') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 animate-slide-in-right">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl p-5 sm:p-8 border border-white/20 dark:border-gray-700/50">
                        <form action="{{ route('connect.store', ['id' => $LearningCenter->id]) }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full mb-3 shadow-lg shadow-blue-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ __('connect-edit.form.title') }}</h2>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('connect-edit.form.connection_type') }}</label>
                                    <select name="connection_id" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-blue-500" required>
                                        <option value="" disabled selected>{{ __('connect-edit.form.select_type') }}</option>
                                        @foreach ($connections as $connection)
                                            <option value="{{ $connection->id }}">{{ $connection->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('connect-edit.form.url') }}</label>
                                    <input type="text" name="url" placeholder="https://..." class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:ring-2 focus:ring-blue-500" required>
                                    <p class="text-[10px] sm:text-xs text-gray-500 mt-1.5 px-1">{{ __('connect-edit.form.url_hint') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" class="w-full order-1 sm:order-2 py-3.5 px-6 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                                    <span>{{ __('connect-edit.buttons.save') }}</span>
                                </button>
                                <a href="{{ route('blog-single', $LearningCenter->id) }}" class="w-full order-2 sm:order-1 py-3.5 px-6 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                    {{ __('connect-edit.buttons.back') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>