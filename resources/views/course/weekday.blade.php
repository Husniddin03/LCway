<x-layout>
    <x-slot:title>
        {{ __('course-weekday.title') }}
    </x-slot>
    
    <!-- Modern Weekday Editor Section -->
    <section class="min-h-screen  bg-white dark:bg-gray-800 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-purple-400 to-pink-400 dark:from-purple-600 dark:to-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-blue-400 to-cyan-400 dark:from-blue-600 dark:to-cyan-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-yellow-600 dark:to-orange-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute top-1/2 right-1/4 w-60 h-60 bg-gradient-to-r from-green-400 to-teal-400 dark:from-green-600 dark:to-teal-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-6000"></div>
        </div>

        <!-- Section Title -->
        <div x-data="{ sectionTitle: `{{ $LearningCenter->name }}`, sectionTitleText: `{{ $LearningCenter->name }}{{ __('course-weekday.header.title_suffix') }}` }" class="relative text-gray-900 dark:text-white">
            <div class="text-center max-w-4xl mx-auto mb-16 animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full mb-6">
                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ __('course-weekday.header.badge') }}</span>
                </div>
                
                <h2 x-text="sectionTitle" class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 mb-6 leading-tight">
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto" x-text="sectionTitleText"></p>
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-gray-800 backdrop-blur-xl rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50 relative overflow-hidden group">
                        <!-- Glassmorphism effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 via-purple-400/10 to-pink-400/10 dark:from-blue-600/10 dark:via-purple-600/10 dark:to-pink-600/10 rounded-3xl"></div>
                        
                        <!-- Floating icon -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-2xl"></div>
                        
                        <div class="relative">
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ __('course-weekday.status.active') }}</span>
                            </div>
                            
                            <div class="mb-8">
                                <h4 class="text-3xl font-black text-gray-900 dark:text-white mb-3 bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">{{ $LearningCenter->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-lg">
                                    <a href="#!" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors font-medium">{{ $LearningCenter->type }}</a>
                                </p>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 sm:pt-8 mt-6">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-5 flex items-center group">
                                    <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    {{ __('course-edit-image.header.contact') }}
                                </h4>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @forelse ($LearningCenter->connections as $connection)
                                        @php
                                            // Birinchi harfni olish (UTF-8 qo'llab-quvvatlaydi)
                                            $firstLetter = mb_substr($connection->connection->name, 0, 1);
                                        @endphp
                                        
                                        <a href="{{ in_array($connection->connection->name, ['Phone', 'Email']) ? ($connection->connection->name == 'Phone' ? 'tel:' : 'mailto:') . $connection->url : $connection->url }}" 
                                        target="_blank"
                                        class="flex items-center p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-white dark:hover:bg-gray-800 hover:shadow-md transition-all duration-200 group">
                                            
                                            <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-white dark:bg-gray-700 rounded-lg shadow-sm group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors border border-gray-100 dark:border-gray-600">
                                                @if ($connection->connection->icon)
                                                    <i class="{{ $connection->connection->icon }} text-blue-500 group-hover:scale-110 transition-transform"></i>
                                                @else
                                                    <span class="text-blue-600 dark:text-blue-400 font-black text-lg uppercase group-hover:scale-110 transition-transform">
                                                        {{ $firstLetter }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="ml-3 min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-none mb-1">
                                                    {{ $connection->connection->name }}
                                                </p>
                                                <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 truncate max-w-full italic">
                                                    {{ $connection->url }}
                                                </p>
                                            </div>

                                            <div class="ml-2 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="col-span-full py-6 text-center bg-gray-50 dark:bg-gray-800/30 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ __('connect-edit.current.no_connections') }}
                                            </p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekday Editor Form -->
                <div class="lg:col-span-2 animate-slide-in-right">
                    <form action="{{ route('course.weekdayUpdate', ['id' => $LearningCenter->id]) }}" method="POST" 
                          class="bg-white dark:bg-gray-800 backdrop-blur-xl rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/20 dark:border-gray-700/50 relative overflow-hidden">
                        @csrf
                        
                        <!-- Form Header -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('course-weekday.form.title') }}</h3>
                                    <p class="text-gray-600 dark:text-gray-300">{{ __('course-weekday.header.subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Add New Weekday Button -->
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('course-weekday.form.title') }}
                                </h3>
                                <button type="button" 
                                        onclick="showAddWeekdayModal()"
                                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('course-weekday.form.add_weekday') }}
                                </button>
                            </div>

                            @foreach ($weedays->filter(function($day) { return $day->schedule_id; }) as $day)
                                <div class="group relative" data-schedule-id="{{ $day->schedule_id ?? '' }}">
                                    <!-- Day Card -->
                                    <div class="rounded-2xl p-6 border border-gray-200/50 dark:border-gray-600/50 hover:border-blue-300/50 dark:hover:border-blue-600/50 transition-all duration-300 hover:shadow-lg group/item">
                                        <!-- Day Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                    {{ substr($day->weekdays, 0, 3) }}
                                                </div>
                                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $day->weekdays }}</h4>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ __('course-weekday.form.opening_time') }}
                                            </div>
                                            <!-- Delete Button -->
                                            @if($day->schedule_id)
                                                <button type="button" 
                                                        onclick="deleteWeekday({{ $day->schedule_id }})"
                                                        class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- Opening Time -->
                                            <div class="space-y-2">
                                                <label for="open_time_{{ $day->id }}" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ __('course-weekday.form.opening_time') }}
                                                </label>
                                                <div class="relative">
                                                    <input type="time" 
                                                           name="days[{{ $day->id }}][open_time]" 
                                                           id="open_time_{{ $day->id }}"
                                                           value="{{ $day->existing_open_time ?? '' }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm" />
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                @error('days[{{ $day->id }}][open_time]')
                                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            
                                            <!-- Closing Time -->
                                            <div class="space-y-2">
                                                <label for="close_time_{{ $day->id }}" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    {{ __('course-weekday.form.closing_time') }}
                                                </label>
                                                <div class="relative">
                                                    <input type="time" 
                                                           name="days[{{ $day->id }}][close_time]" 
                                                           id="close_time_{{ $day->id }}"
                                                           value="{{ $day->existing_close_time ?? '' }}"
                                                           class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm" />
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                @error('days[{{ $day->id }}][close_time]')
                                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input -->
                                        <input hidden type="text" name="days[{{ $day->id }}][calendar_id]" 
                                               value="{{ $day->id }}" />
                                        @error('days[{{ $day->id }}][calendar_id]')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                            <a href="{{ route('blog-single', $LearningCenter->id) }}" 
                               class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('course-weekday.buttons.back') }}
                            </a>
                            <button type="submit" 
                                    class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('course-weekday.buttons.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Weekday Modal -->
    <div id="addWeekdayModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('course-weekday.form.add_weekday_title') }}
                </h3>
                <button type="button" onclick="hideAddWeekdayModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="addWeekdayForm" onsubmit="addWeekday(event)">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="new_calendar_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('course-weekday.form.select_day') }}
                        </label>
                        <select id="new_calendar_id" name="calendar_id" required
                                onchange="updateWeekdayForm()"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white">
                            @foreach ($weedays as $day)
                                <option value="{{ $day->id }}" 
                                        data-open-time="{{ $day->existing_open_time ?? '' }}" 
                                        data-close-time="{{ $day->existing_close_time ?? '' }}"
                                        data-schedule-id="{{ $day->schedule_id ?? '' }}">
                                    {{ $day->weekdays }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_open_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('course-weekday.form.opening_time') }}
                            </label>
                            <input type="time" id="new_open_time" name="open_time" required
                                   class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label for="new_close_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('course-weekday.form.closing_time') }}
                            </label>
                            <input type="time" id="new_close_time" name="close_time" required
                                   class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" onclick="hideAddWeekdayModal()" 
                                class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-colors">
                            {{ __('course-weekday.buttons.cancel') }}
                        </button>
                        <button type="submit" id="submitBtn"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all">
                            {{ __('course-weekday.buttons.add') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddWeekdayModal() {
            document.getElementById('addWeekdayModal').classList.remove('hidden');
            updateWeekdayForm(); // Modal ochilganda formani yangilash
        }
        
        function hideAddWeekdayModal() {
            document.getElementById('addWeekdayModal').classList.add('hidden');
            // Formani tozalash
            document.getElementById('addWeekdayForm').reset();
            updateWeekdayForm();
        }
        
        function updateWeekdayForm() {
            const select = document.getElementById('new_calendar_id');
            const selectedOption = select.options[select.selectedIndex];
            const openTimeInput = document.getElementById('new_open_time');
            const closeTimeInput = document.getElementById('new_close_time');
            const submitBtn = document.getElementById('submitBtn');
            
            const existingOpenTime = selectedOption.getAttribute('data-open-time');
            const existingCloseTime = selectedOption.getAttribute('data-close-time');
            const scheduleId = selectedOption.getAttribute('data-schedule-id');
            
            // Agar mavjud ma'lumot bo'lsa, ularni ko'rsatish
            if (existingOpenTime) {
                openTimeInput.value = existingOpenTime;
            } else {
                openTimeInput.value = '';
            }
            
            if (existingCloseTime) {
                closeTimeInput.value = existingCloseTime;
            } else {
                closeTimeInput.value = '';
            }
            
            // Tugma matnini yangilash
            if (scheduleId) {
                submitBtn.textContent = '{{ __('course-weekday.buttons.update') }}';
                submitBtn.classList.remove('from-blue-600', 'to-purple-600');
                submitBtn.classList.add('from-orange-500', 'to-orange-600');
            } else {
                submitBtn.textContent = '{{ __('course-weekday.buttons.add') }}';
                submitBtn.classList.remove('from-orange-500', 'to-orange-600');
                submitBtn.classList.add('from-blue-600', 'to-purple-600');
            }
        }
        
        function addWeekday(event) {
            event.preventDefault();
            
            const formData = new FormData(document.getElementById('addWeekdayForm'));
            const learningCenterId = '{{ $LearningCenter->id }}';
            
            fetch(`/course/weekdayAdd/${learningCenterId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideAddWeekdayModal();
                    location.reload();
                } else {
                    alert('Xatolik yuz berdi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Xatolik yuz berdi');
            });
        }
        
        function deleteWeekday(scheduleId) {
            if (!confirm('Hafta kunini o\'chirishni tasdiqlaysizmi?')) {
                return;
            }
            
            fetch(`/course/weekdayDelete/${scheduleId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Xatolik yuz berdi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Xatolik yuz berdi');
            });
        }
    </script>
</x-layout>
