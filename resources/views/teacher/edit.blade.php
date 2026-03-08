<x-layout>
    <x-slot:title>Mavjud o'qituvchini tahrirlash</x-slot:title>
    
    <!-- Modern Teacher Creation Section -->
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
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">O'qituvchi malumotini tahrirlash</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 mb-6 leading-tight">
                    {{ $LearningCenter->name }}dagi o'qituvchi malumotini tahrirlash
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Bu orqali talabalar o'qituvchilarni ham topa oladi
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Learning Center Info Card -->
                <div class="lg:col-span-1 animate-slide-in-left">
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition-all duration-500 border border-white/20 dark:border-gray-700/50 relative overflow-hidden group">
                        <!-- Glassmorphism effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 via-purple-400/10 to-pink-400/10 dark:from-blue-600/10 dark:via-purple-600/10 dark:to-pink-600/10 rounded-3xl"></div>
                        
                        <!-- Floating icon -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-2xl"></div>
                        
                        <div class="relative">
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-xs font-semibold text-green-700 dark:text-green-300">Faol</span>
                            </div>
                            
                            <div class="text-center mb-8">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3 bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                                    {{ $LearningCenter->name }}
                                </h3>
                                <div class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $LearningCenter->type }}</span>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.244 4.243a8 8 0 01-2.828 5.828z"></path>
                                        </svg>
                                        Manzil
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $LearningCenter->address }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                        </svg>
                                        Bog'lanish
                                    </h4>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach ($LearningCenter->connections as $connection)
                                            @if ($connection->connection->name == 'Phone')
                                                <a href="tel:{{ $connection->url }}" 
                                                   class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/30 dark:hover:to-blue-800/30 transition-all duration-300 group/item">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-md">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @elseif($connection->connection->name == 'Email')
                                                <a href="mailto:{{ $connection->url }}" 
                                                   class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 hover:from-red-50 hover:to-red-100 dark:hover:from-red-900/30 dark:hover:to-red-800/30 transition-all duration-300 group/item">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-md">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @else
                                                <a href="{{ $connection->url }}" target="_blank"
                                                   class="flex items-center gap-3 p-3 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 hover:from-purple-50 hover:to-purple-100 dark:hover:from-purple-900/30 dark:hover:to-purple-800/30 transition-all duration-300 group/item">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300 shadow-md">
                                                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/{{ strtolower($connection->connection->name) }}.svg"
                                                            width="20" height="20"
                                                            alt="{{ $connection->connection->name }}"
                                                            class="filter brightness-0 invert" />
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="lg:col-span-2 animate-slide-in-right">
                    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST"
                        enctype="multipart/form-data" 
                        class="bg-gray-50 dark:bg-gray-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/20 dark:border-gray-700/50 relative overflow-hidden">
                        @csrf
                        @method('PUT')
                        
                        <!-- Form Header -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">O'qituvchi ma'lumotlari</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Mavjud o'qituvchi ma'lumotlarini tahrirlang</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mb-8">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h4 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                                            Iltimos, xatolarni to'g'irlang:
                                        </h4>
                                        <ul class="text-sm text-red-700 dark:text-red-300 space-y-2">
                                            @foreach ($errors->all() as $error)
                                                <li class="flex items-start gap-2">
                                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span>{{ $error }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-8">
                            <!-- Photo Upload -->
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Ustoz rasmi (ixtiyoriy)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-8 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-300 cursor-pointer group-hover:border-blue-400 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20"
                                    onclick="document.getElementById('photo').click()">
                                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                                        onchange="previewImage(event)">
                                    <div id="photo-preview"
                                        class="w-24 h-24 mx-auto mb-6 bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        @isset($teacher->photo)
                                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Current photo"
                                                class="w-full h-full object-cover rounded-full">
                                        @else
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endisset
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">
                                        Rasm yuklash uchun bosing
                                    </p>
                                </div>
                                @error('photo')
                                    <p class="mt-3 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Name and Phone -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fullname" class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        To'liq ismi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="fullname" placeholder="Devid Wonder" value="{{ $teacher->name }}" required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm" />
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.62 2.48a2 2 0 01-.45 1.885l-1.516 1.516a16 16 0 006.586 6.586l1.516-1.516a2 2 0 011.885-.45l2.48.62A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1c-9.94 0-18-8.06-18-18V5z" />
                                        </svg>
                                        Telefon (ixtiyoriy)
                                    </label>
                                    <input type="tel" name="phone" id="phone" placeholder="+998 90 123 45 67" value="{{ $teacher->phone ?? '' }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm" />
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Mutaxasisligi <span class="text-red-500">*</span>
                                </label>
                                <select name="subject_id" id="subject" required
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm">
                                    <option value="" disabled>Fanni tanlang...</option>
                                    @foreach ($LearningCenter->subjects as $subject)
                                        <option value="{{ $subject->subject->id }}" {{ $subject->subject->id == $teacher->subject_id ? 'selected' : '' }}>{{ $subject->subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- About -->
                            <div>
                                <label for="message" class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Ustoz haqida (ixtiyoriy)
                                </label>
                                <textarea name="about" id="message" rows="4" placeholder="Ustoz haqida qisqacha ma'lumot..."
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm resize-none">{{ $teacher->about ?? '' }}</textarea>
                                @error('about')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-8 border-t border-gray-200/50 dark:border-gray-700/50">
                            <a href="{{ route('blog-single', $LearningCenter->id) }}" 
                               class="flex-1 px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Bekor qilish
                            </a>
                            <button type="submit"
                                    class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold rounded-2xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Saqlash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Eski rasmni saqlab qo'yish
        const existingPhoto = "{{ $teacher->photo ? asset('storage/'.$teacher->photo) : '' }}";
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photo-preview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-full" />`;
                    preview.classList.remove('bg-gray-50', 'dark:bg-gray-900', 'border-2', 'border-dashed', 'border-gray-300', 'dark:border-gray-600');
                    preview.classList.add('ring-4', 'ring-blue-500/20', 'dark:ring-blue-400/20');
                }
                
                reader.readAsDataURL(file);
            } else {
                // Agar rasm tanlanmagan bo'lsa, eski rasmni qaytarish
                if (existingPhoto) {
                    preview.innerHTML = `<img src="${existingPhoto}" alt="Current photo" class="w-full h-full object-cover rounded-full" />`;
                    preview.classList.remove('bg-gray-50', 'dark:bg-gray-900', 'border-2', 'border-dashed', 'border-gray-300', 'dark:border-gray-600');
                    preview.classList.add('ring-4', 'ring-blue-500/20', 'dark:ring-blue-400/20');
                } else {
                    preview.innerHTML = `
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    `;
                    preview.classList.add('bg-gray-50', 'dark:bg-gray-900', 'border-2', 'border-dashed', 'border-gray-300', 'dark:border-gray-600');
                    preview.classList.remove('ring-4', 'ring-blue-500/20', 'dark:ring-blue-400/20');
                }
            }
        }
    </script>
</x-layout>
