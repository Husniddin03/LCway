<x-layout>
    <x-slot:title>{{ __('subject-create.title') }}</x-slot:title>
    
    <!-- Modern Subject Creation Section -->
    <section class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-purple-400 to-pink-400 dark:from-purple-600 dark:to-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-blue-400 to-cyan-400 dark:from-blue-600 dark:to-cyan-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-gradient-to-r from-yellow-400 to-orange-400 dark:from-yellow-600 dark:to-orange-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Section Title -->
        <div class="relative max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full mb-6">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('subject-create.header.badge') }}</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 mb-6 leading-tight">
                    {{ $LearningCenter->name }}{{ __('subject-create.header.title_suffix') }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ __('subject-create.header.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50 relative overflow-hidden group">
                        <!-- Glassmorphism effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 via-purple-400/10 to-pink-400/10 dark:from-blue-600/10 dark:via-purple-600/10 dark:to-pink-600/10 rounded-3xl"></div>
                        
                        <!-- Floating icon -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-2xl"></div>
                        
                        <div class="relative">
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-xs font-semibold text-green-700 dark:text-green-300">{{ __('subject-create.info.status') }}</span>
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
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        {{ __('subject-create.info.subjects_title') }}
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach ($LearningCenter->subjects as $subject)
                                            <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
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
                        <form action="{{ route('subject.storeid', $LearningCenter->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Form Header -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('subject-create.form.title') }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ __('subject-create.form.subtitle') }}</p>
                            </div>

                            <!-- Form Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Subject Name Input -->
                                <div class="space-y-2">
                                    <label for="subject_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        {{ __('subject-create.form.subject_name_label') }}
                                    </label>
                                    <input type="text" id="subject_name" name="subject_name" list="existing-subjects" placeholder="{{ __('subject-create.form.subject_name_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <datalist id="existing-subjects">
                                        @foreach($existingSubjects as $subject)
                                            <option value="{{ $subject }}">{{ $subject }}</option>
                                        @endforeach
                                    </datalist>
                                    @error('subject_name')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Subject Type Input (now in teacher_subjects) -->
                                <div class="space-y-2">
                                    <label for="subject_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('subject-create.form.subject_type_label') }}
                                    </label>
                                    <input type="text" id="subject_type" name="subject_type" placeholder="Asosiy, Qo'shimcha..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">* Fan turini o'qituvchiga biriktirganda saqlanadi</p>
                                    @error('subject_type')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Teacher Selection -->
                                <div class="space-y-2">
                                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                        </svg>
                                        O'qituvchini tanlang
                                    </label>
                                    <select id="teacher_id" name="teacher_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="">O'qituvchi tanlanmagan</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Description Input (now in teacher_subjects) -->
                                <div class="space-y-2 md:col-span-2">
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Tavsif
                                    </label>
                                    <textarea name="description" id="message" rows="4" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Fan tavsifi..."></textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">* Tavsif o'qituvchiga biriktirganda saqlanadi</p>
                                </div>

                                <!-- Price Input (now in teacher_subjects) -->
                                <div class="space-y-2">
                                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('subject-create.form.price_label') }}
                                    </label>
                                    <input type="number" name="price" id="price" placeholder="500000" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">* Narx o'qituvchiga biriktirganda saqlanadi</p>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Subject Icon Input (now in teacher_subjects) -->
                                <div class="space-y-2">
                                    <label for="subject_icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                        Fan ikoni
                                    </label>
                                    <input type="text" name="subject_icon" id="subject_icon" placeholder="Icon class..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">* Icon o'qituvchiga biriktirganda saqlanadi</p>
                                    @error('subject_icon')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                                <a href="{{ route('center', $LearningCenter->slug) }}" 
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('subject-create.buttons.back') }}
                                </a>
                                <button type="submit"
                                        class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('subject-create.buttons.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
