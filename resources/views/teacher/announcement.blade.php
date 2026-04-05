<x-layout>
    <x-slot:title>{{ __('teacher-announcement.title') }}</x-slot:title>
    
    <!-- Modern Teacher Announcement Section -->
    <section class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-amber-400 to-orange-400 dark:from-amber-600 dark:to-orange-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-blue-400 to-cyan-400 dark:from-blue-600 dark:to-cyan-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-gradient-to-r from-purple-400 to-pink-400 dark:from-purple-600 dark:to-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Section Title -->
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 rounded-full mb-6">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('teacher-announcement.header.badge') }}</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 dark:from-amber-400 dark:via-orange-400 dark:to-red-400 mb-6 leading-tight">
                    {{ $LearningCenter->name }}{{ __('teacher-announcement.header.title_suffix') }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ __('teacher-announcement.header.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50 relative overflow-hidden group">
                        <!-- Glassmorphism effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-400/10 via-orange-400/10 to-red-400/10 dark:from-amber-600/10 dark:via-orange-600/10 dark:to-red-600/10 rounded-3xl"></div>
                        
                        <!-- Floating icon -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-2xl"></div>
                        
                        <div class="relative">
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-xs font-semibold text-green-700 dark:text-green-300">{{ __('teacher-announcement.info.status') }}</span>
                            </div>
                            
                            <!-- Learning Center Info -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $LearningCenter->name }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $LearningCenter->type }}
                                    </p>
                                </div>
                                
                                <!-- Subjects List -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        {{ __('teacher-announcement.info.subjects_title') }}
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach ($LearningCenter->subjects as $subject)
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <div class="w-2 h-2 bg-amber-500 rounded-full mr-3"></div>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $subject->subject_name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Contact Info -->
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
                                            $firstLetter = mb_substr($connection->connection_name, 0, 1);
                                        @endphp
                                        
                                        <a href="{{ in_array($connection->connection_name, ['Phone', 'Email']) ? ($connection->connection_name == 'Phone' ? 'tel:' : 'mailto:') . $connection->url : $connection->url }}" 
                                        target="_blank"
                                        class="flex items-center p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-white dark:hover:bg-gray-800 hover:shadow-md transition-all duration-200 group">
                                            
                                            <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-white dark:bg-gray-700 rounded-lg shadow-sm group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 transition-colors border border-gray-100 dark:border-gray-600">
                                                @if ($connection->connection_icon)
                                                    <i class="{{ $connection->connection_icon }} text-blue-500 group-hover:scale-110 transition-transform"></i>
                                                @else
                                                    <span class="text-blue-600 dark:text-blue-400 font-black text-lg uppercase group-hover:scale-110 transition-transform">
                                                        {{ $firstLetter }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="ml-3 min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-none mb-1">
                                                    {{ $connection->connection_name }}
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
                </div>

                <!-- Form Section -->
                <div class="lg:col-span-2 animate-slide-in-right">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50">
                        <form action="{{ route('teacher.add_announcement', ['id' => $LearningCenter->id]) }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Form Header -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('teacher-announcement.form.title') }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ __('teacher-announcement.form.subtitle') }}</p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 00-1 1v4a1 1 0 102 2v-4a1 1 0 00-1-1zm-2 0a2 2 0 00-2 2v4a2 2 0 002 2h1a2 2 0 002-2v-4a2 2 0 00-2-2h-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h4 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('teacher-announcement.errors.title') }}</h4>
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
                                <!-- Subject Name Input -->
                                <div class="space-y-2">
                                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        {{ __('teacher-announcement.form.subject_name_label') }} <span class="text-red-500">{{ __('teacher-announcement.form.subject_required') }}</span>
                                    </label>
                                    <input type="text" name="subject_name" id="subject" placeholder="Matematika, Ingliz tili..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200" required>
                                    @error('subject_name')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Subject Type Input -->
                                <div class="space-y-2">
                                    <label for="subject_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ __('teacher-announcement.form.subject_type_label') }}
                                    </label>
                                    <input type="text" name="subject_type" id="subject_type" placeholder="Asosiy, Qo'shimcha..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200">
                                    @error('subject_type')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="space-y-2">
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ __('teacher-announcement.form.description_label') }}
                                    </label>
                                    <textarea name="description" id="message" rows="6" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="{{ __('teacher-announcement.form.description_placeholder') }}" required></textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}" 
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ __('teacher-announcement.buttons.back') }}
                                </a>
                                <button type="submit"
                                        class="flex-1 px-8 py-4 bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 hover:from-amber-700 hover:via-orange-700 hover:to-red-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                    {{ __('teacher-announcement.buttons.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
