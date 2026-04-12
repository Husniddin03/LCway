<x-layout>
@push('styles')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4f46e5; }
        
        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(31, 41, 55, 0.9);
            border: 1px solid rgba(75, 85, 99, 0.4);
        }
        
        /* Hover Effects */
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Image Zoom */
        .img-zoom {
            overflow: hidden;
        }
        .img-zoom img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .img-zoom:hover img {
            transform: scale(1.1);
        }
        
        /* Pulse Animation */
        @keyframes softPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .animate-soft-pulse {
            animation: softPulse 2s ease-in-out infinite;
        }
        
        /* GLightbox Custom Styles */
        .glightbox-container {
            z-index: 999999 !important;
        }
        .gslide {
            backdrop-filter: blur(20px);
        }
        .pswp__img {
            border-radius: 12px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }
        .pswp__button--arrow--prev,
        .pswp__button--arrow--next {
            width: 60px !important;
            height: 60px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 50% !important;
            margin: 0 20px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        }
        .pswp__button--close {
            width: 50px !important;
            height: 50px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 50% !important;
            top: 20px !important;
            right: 20px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        }
        .pswp__top-bar {
            background: transparent !important;
        }
        
        /* Comment Animation */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .comment-enter {
            animation: slideInUp 0.4s ease-out;
        }
        
        /* Shimmer */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
    </style>
@endpush

<x-slot:title>{{ $LearningCenter->name }} - {{ __('center.title') }}</x-slot:title>

    <!-- 🎨 MODERN HERO -->
    <section class="relative min-h-[65vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600 dark:from-violet-900 dark:via-purple-900 dark:to-fuchsia-900">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute top-1/3 right-0 w-80 h-80 bg-pink-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 text-center" data-aos="fade-up">
            @if ($LearningCenter->checked)
                <div class="inline-flex items-center gap-2 px-5 py-2.5 mb-6 bg-emerald-500/20 backdrop-blur-md border border-emerald-400/40 rounded-full animate-soft-pulse">
                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-emerald-100">{{ __('center.verified') }}</span>
                </div>
            @endif

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 text-white leading-tight drop-shadow-2xl">
                {{ $LearningCenter->name }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-3">
                @if($LearningCenter->type)
                    <span class="px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/30 rounded-full text-sm font-medium text-white/90">
                        {{ $LearningCenter->type->name ?? $LearningCenter->type }}
                    </span>
                @endif
                <span class="px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/30 rounded-full text-sm font-medium text-white/90 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    {{ $LearningCenter->region }}, {{ $LearningCenter->province }}
                </span>
                @php
                    $avgRating = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                @endphp
                @if($avgRating > 0)
                    <span class="px-5 py-2.5 bg-amber-500/20 backdrop-blur-md border border-amber-400/40 rounded-full text-sm font-semibold text-amber-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        {{ $avgRating }} ({{ $LearningCenter->favorites()->count() }} baho)
                    </span>
                @endif
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                <a href="#contact" class="px-8 py-4 bg-white text-purple-700 font-bold rounded-full hover:scale-105 transition-all shadow-xl shadow-purple-500/30 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Bog'lanish
                </a>
                <a href="#gallery" class="px-8 py-4 bg-white/10 backdrop-blur-md border-2 border-white/50 text-white font-bold rounded-full hover:bg-white/20 hover:scale-105 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                    </svg>
                    Rasmlar
                </a>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- 📍 STICKY NAVIGATION -->
    <div class="sticky top-[70px] z-40 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 py-3" data-aos="fade-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1 overflow-x-auto scrollbar-hide">
                <a href="#about" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">Biz haqimizda</a>
                @if($LearningCenter->images->count() > 0)
                    <a href="#gallery" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">Rasmlar</a>
                @endif
                @if($LearningCenter->teachers->count() > 0)
                    <a href="#teachers" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">O'qituvchilar</a>
                @endif
                <a href="#comments" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">Izohlar</a>
                <a href="#contact" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">Aloqa</a>
            </nav>
        </div>
    </div>

    <!-- 📸 MAIN IMAGE -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative group rounded-3xl overflow-hidden shadow-2xl" data-aos="zoom-in">
                @if($LearningCenter->logo)
                    <img src="{{ asset('storage/' . $LearningCenter->logo) }}" alt="{{ $LearningCenter->name }}" class="w-full h-[400px] md:h-[500px] object-cover">
                @else
                    <div class="w-full h-[400px] md:h-[500px] bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl font-bold mb-2">{{ $LearningCenter->type }}</div>
                            <div class="text-2xl opacity-90">{{ $LearningCenter->name }}</div>
                        </div>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
        </div>
    </section>

    <!-- 📝 ABOUT & SIDEBAR GRID -->
    <section id="about" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- About Card -->
                    <div class="glass-card rounded-3xl p-8 hover-lift" data-aos="fade-up">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Biz haqimizda</h2>
                            </div>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                            <p class="text-lg">{{ $LearningCenter->about ?? 'Ma\'lumot mavjud emas' }}</p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="glass-card rounded-2xl p-6 text-center hover-lift">
                            <div class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ $LearningCenter->student_count ?? 0 }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">O'quvchilar</div>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center hover-lift">
                            <div class="text-3xl font-black text-violet-600 dark:text-violet-400">{{ $LearningCenter->teachers->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">O'qituvchilar</div>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center hover-lift">
                            <div class="text-3xl font-black text-fuchsia-600 dark:text-fuchsia-400">{{ $LearningCenter->subjects->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Fanlar</div>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center hover-lift">
                            <div class="text-3xl font-black text-pink-600 dark:text-pink-400">{{ $LearningCenter->favorites()->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Baholar</div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Contact Card -->
                    <div id="contact" class="glass-card rounded-3xl p-6 hover-lift" data-aos="fade-left">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Aloqa
                            </h3>
                        </div>
                        <div class="space-y-4">
                            @if($LearningCenter->phone_number)
                                <a href="tel:{{ $LearningCenter->phone_number }}" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Telefon</div>
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $LearningCenter->phone_number }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($LearningCenter->email)
                                <a href="mailto:{{ $LearningCenter->email }}" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Email</div>
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $LearningCenter->email }}</div>
                                    </div>
                                </a>
                            @endif
                            <a href="https://www.openstreetmap.org/search?query={{ urlencode($LearningCenter->address) }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Manzil</div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $LearningCenter->address }}</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @if($LearningCenter->connections && $LearningCenter->connections->count() > 0)
                        <div class="glass-card rounded-3xl p-6 hover-lift" data-aos="fade-left" data-aos-delay="100">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Ijtimoiy tarmoqlar</h3>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($LearningCenter->connections as $connection)
                                    <a href="{{ $connection->url }}" target="_blank" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                                        <x-social-icon :icon="$connection->connection_icon" size="w-5 h-5" />
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $connection->connection_name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 🖼️ GALLERY SECTION -->
    @if($LearningCenter->images->count() > 0)
        <section id="gallery" class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-gray-100 mb-4">Rasmlar galereyasi</h2>
                    <p class="text-gray-500 dark:text-gray-400">Rasmlarni bosib, kattalashtirib ko'rish</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="center-gallery">
                    @foreach ($LearningCenter->images as $index => $image)
                        <a href="{{ asset('storage/' . $image->image) }}" 
                           class="glightbox img-zoom group relative rounded-2xl overflow-hidden shadow-lg aspect-square"
                           data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                            <img src="{{ asset('storage/' . $image->image) }}" 
                                 alt="{{ $LearningCenter->name }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-4">
                                <span class="text-white text-sm font-medium">Kattalashtirish</span>
                            </div>
                            <div class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                        ← → tugmalari bilan navigatsiya • ESC yoki click bilan yopish
                    </p>
                </div>
            </div>
        </section>
    @endif

    <!-- 👨‍🏫 TEACHERS SECTION -->
    @if($LearningCenter->teachers->count() > 0)
        <section id="teachers" class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-gray-100 mb-4">O'qituvchilarimiz</h2>
                    <p class="text-gray-500 dark:text-gray-400">Tajribali va malakali o'qituvchilar jamoasi</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($LearningCenter->teachers as $index => $teacher)
                        <div class="glass-card rounded-3xl p-6 hover-lift" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="flex items-start gap-4">
                                <div class="relative">
                                    @if(isset($teacher->photo))
                                        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-purple-100 dark:ring-purple-900/30">
                                    @else
                                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold ring-4 ring-purple-100 dark:ring-purple-900/30">
                                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $teacher->name }}</h3>
                                            @if($teacher->teacherSubjects->count() > 0)
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    @foreach($teacher->teacherSubjects as $ts)
                                                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-medium rounded-full">
                                                            {{ $ts->subject->subject_name ?? '' }}
                                                            @if($ts->price)
                                                                <span class="text-green-600 dark:text-green-400">({{ number_format($ts->price) }})</span>
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 line-clamp-2">{{ $teacher->about }}</p>
                                    @if($teacher->phone)
                                        <a href="tel:{{ $teacher->phone }}" class="inline-flex items-center gap-1 mt-3 text-sm text-purple-600 dark:text-purple-400 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $teacher->phone }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- YURIDIK MALUMOTLAR SECTION -->
    @if($LearningCenter->tin || $LearningCenter->legal_address || $LearningCenter->license_number || $LearningCenter->manager_name || $LearningCenter->phone_number || $LearningCenter->email || $LearningCenter->territory)
        <section id="yuridik" class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-gray-100 mb-4">Yuridik ma'lumotlar</h2>
                    <p class="text-gray-500 dark:text-gray-400">Markazning rasmiy ma'lumotlari va litsenziyalari</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Yuridik ma'lumotlar -->
                    @if($LearningCenter->tin || $LearningCenter->legal_address)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6" data-aos="fade-up">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Yuridik ma'lumotlar</h3>
                            </div>
                            @if($LearningCenter->tin)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">INN raqami</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->tin }}</p>
                                </div>
                            @endif
                            @if($LearningCenter->legal_address)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Yuridik manzili</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->legal_address }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Litsenziya ma'lumotlari -->
                    @if($LearningCenter->license_number || $LearningCenter->license_registration_date || $LearningCenter->license_validity_period)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Litsenziya</h3>
                            </div>
                            @if($LearningCenter->license_number)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Litsenziya raqami</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->license_number }}</p>
                                </div>
                            @endif
                            @if($LearningCenter->license_registration_date)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Ro'yxatdan o'tkazilgan sana</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($LearningCenter->license_registration_date)->locale('uz')->format('d F Y') }}</p>
                                </div>
                            @endif
                            @if($LearningCenter->license_validity_period)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Amal qilish muddati</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($LearningCenter->license_validity_period)->locale('uz')->format('d F Y') }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Menejer ma'lumotlari -->
                    @if($LearningCenter->manager_name || $LearningCenter->phone_number || $LearningCenter->email || $LearningCenter->ifut_code)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Menejer ma'lumotlari</h3>
                            </div>
                            @if($LearningCenter->manager_name)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Menejer ismi</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->manager_name }}</p>
                                </div>
                            @endif
                            @if($LearningCenter->phone_number)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Telefon raqami</p>
                                    <a href="tel:{{ $LearningCenter->phone_number }}" class="font-medium text-purple-600 dark:text-purple-400 hover:underline">{{ $LearningCenter->phone_number }}</a>
                                </div>
                            @endif
                            @if($LearningCenter->email)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                    <a href="mailto:{{ $LearningCenter->email }}" class="font-medium text-purple-600 dark:text-purple-400 hover:underline">{{ $LearningCenter->email }}</a>
                                </div>
                            @endif
                            @if($LearningCenter->ifut_code)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">IFUT kodi</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->ifut_code }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Hudud ma'lumotlari -->
                    @if($LearningCenter->territory)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hudud</h3>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Xizmat ko'rsatish hududi</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->territory }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- FANLAR VA O'QITUVCHILAR SECTION -->
    @if($LearningCenter->subjects->count() > 0)
        <section id="subjects-teachers" class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl font-black text-gray-900 dark:text-gray-100 mb-4">Fanlar va o'qituvchilar</h2>
                    <p class="text-gray-500 dark:text-gray-400">Markazimizda o'qitiladigan fanlar va ularning malakali o'qituvchilari</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($LearningCenter->subjects as $index => $subject)
                        <div class="glass-card rounded-3xl p-6 hover-lift" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <!-- Fan nomi -->
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $subject->subject_name }}</h3>
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Narx ma'lumotlari -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Narxlar</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($subject->teacherSubjects->isNotEmpty())
                                        @foreach($subject->teacherSubjects->unique('price') as $ts)
                                            @if($ts->price)
                                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-medium rounded-full">
                                                    {{ number_format($ts->price) }} {{ $ts->currency ?? 'UZS' }}
                                                    @if($ts->period)
                                                        <span class="text-xs">({{ $ts->period }})</span>
                                                    @endif
                                                </span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm font-medium rounded-full">
                                            Narx belgilanmagan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- O'qituvchilar ro'yxati -->
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">O'qituvchilar ({{ $subject->teacherSubjects->count() }})</p>
                                <div class="space-y-3">
                                    @if($subject->teacherSubjects->isNotEmpty())
                                        @foreach($subject->teacherSubjects as $ts)
                                            @if($ts->teacher)
                                                <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 rounded-xl">
                                                    <!-- O'qituvchi rasmi -->
                                                    <div class="relative">
                                                        @if($ts->teacher->photo)
                                                            <img src="{{ asset('storage/' . $ts->teacher->photo) }}" alt="{{ $ts->teacher->name }}" class="w-12 h-12 rounded-full object-cover">
                                                        @else
                                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                                                <span class="text-white font-bold">{{ substr($ts->teacher->name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                        <!-- Status indicator -->
                                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                                                    </div>

                                                    <!-- O'qituvchi ma'lumotlari -->
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $ts->teacher->name }}</h4>
                                                        <div class="flex items-center gap-3 mt-1">
                                                            @if($ts->subject_type)
                                                                <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                                                                    {{ $ts->subject_type }}
                                                                </span>
                                                            @endif
                                                            @if($ts->teacher->phone)
                                                                <a href="tel:{{ $ts->teacher->phone }}" class="text-xs text-purple-600 dark:text-purple-400 hover:underline">
                                                                    {{ $ts->teacher->phone }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                        @if($ts->description)
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $ts->description }}</p>
                                                        @endif
                                                    </div>

                                                    <!-- Contact button -->
                                                    <div class="flex gap-2">
                                                        @if($ts->teacher->phone)
                                                            <a href="tel:{{ $ts->teacher->phone }}" class="w-8 h-8 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg flex items-center justify-center hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                        @if($ts->teacher->about)
                                                            <button onclick="showTeacherInfo('{{ $ts->teacher->id }}')" class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">Bu fanga o'qituvchi biriktirilmagan</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 💬 COMMENTS SECTION -->
    <section id="comments" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-black text-gray-900 dark:text-gray-100 mb-4">Fikr va mulohazalar</h2>
                <p class="text-gray-500 dark:text-gray-400">O'quv markazi haqida fikringizni bildiring</p>
            </div>

            <!-- Rating Section -->
            @auth
                <div class="glass-card rounded-3xl p-8 mb-8" data-aos="fade-up">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Baholang</h3>
                    <div class="flex items-center gap-2" id="rating-container" data-center-id="{{ $LearningCenter->id }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <button class="star-btn text-4xl text-gray-300 dark:text-gray-600 hover:text-amber-400 transition-all duration-200 hover:scale-125" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <p id="rating-message" class="text-sm text-amber-600 dark:text-amber-400 mt-2 font-medium"></p>
                </div>

                <!-- Comment Form -->
                <div class="glass-card rounded-3xl p-8 mb-8" data-aos="fade-up">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Izoh qoldiring</h3>
                    <form id="commentForm" class="space-y-4">
                        @csrf
                        <textarea id="commentInput" rows="4" class="w-full px-4 py-4 rounded-2xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none" placeholder="Fikringizni yozing..."></textarea>
                        <div id="commentError" class="hidden p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm"></div>
                        <button type="submit" id="submitComment" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg id="sendIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <svg id="loadingIcon" class="w-5 h-5 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Yuborish
                        </button>
                    </form>
                </div>
            @else
                <div class="glass-card rounded-3xl p-8 mb-8 text-center" data-aos="fade-up">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Izoh qoldirish uchun tizimga kiring</p>
                    <a href="{{ route('signin') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition-colors">
                        Kirish
                    </a>
                </div>
            @endauth

            <!-- Comments List -->
            <div id="commentsList" class="space-y-4 max-h-[500px] overflow-y-auto">
                @foreach ($LearningCenter->comments->reverse() as $comment)
                    <div class="glass-card rounded-2xl p-6 comment-enter" id="comment-{{ $comment->id }}">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                    @auth
                                        @if(auth()->user()->id === $comment->user->id)
                                            <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Izohni o\'chirmoqchimisiz?')">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 🗺️ MAP SECTION -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card rounded-3xl overflow-hidden" data-aos="zoom-in">
                @php
                    $coords = $LearningCenter->location ? explode(',', $LearningCenter->location) : null;
                    $lat = isset($coords[0]) && is_numeric(trim($coords[0])) ? (float) trim($coords[0]) : 41.2995;
                    $lon = isset($coords[1]) && is_numeric(trim($coords[1])) ? (float) trim($coords[1]) : 69.2401;
                    $bboxLeft = $lon - 0.01;
                    $bboxRight = $lon + 0.01;
                    $bboxBottom = $lat - 0.01;
                    $bboxTop = $lat + 0.01;
                @endphp
                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox={{ urlencode("$bboxLeft,$bboxBottom,$bboxRight,$bboxTop") }}&layer=mapnik&marker={{ $lat }}%2C{{ $lon }}"
                        class="w-full h-[400px] border-0"
                        allowfullscreen
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- 🎯 CTA SECTION -->
    <section class="py-20 bg-gradient-to-r from-violet-600 to-purple-600">
        <div class="max-w-4xl mx-auto px-4 text-center" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-4">Boshqalar ham bilishlari kerak!</h2>
            <p class="text-xl text-white/80 mb-8">Ushbu o'quv markazi haqida do'stlaringizga aytib bering</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <button onclick="navigator.share ? navigator.share({title: '{{ $LearningCenter->name }}', text: '{{ $LearningCenter->about }}', url: window.location.href}) : alert('Ulashish funksiyasi mavjud emas')" class="px-8 py-4 bg-white text-purple-700 font-bold rounded-full hover:scale-105 transition-all shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Do'stlar bilan ulashish
                </button>
            </div>
        </div>
    </section>

    <!-- 📜 SCRIPTS -->
    @auth
        <script>
            // Rating functionality
            document.querySelectorAll('.star-btn').forEach(star => {
                star.addEventListener('mouseenter', function() {
                    const value = this.dataset.value;
                    document.querySelectorAll('.star-btn').forEach((s, i) => {
                        s.classList.toggle('text-amber-400', i < value);
                        s.classList.toggle('text-gray-300', i >= value);
                        s.classList.toggle('dark:text-gray-600', i >= value);
                    });
                });
                
                star.addEventListener('click', function() {
                    const value = this.dataset.value;
                    const centerId = document.getElementById('rating-container').dataset.centerId;
                    
                    fetch('/comment/favoriteStore', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ rating: value, learning_centers_id: centerId })
                    });
                    
                    const messages = ['Yomon', 'Qoniqarsiz', 'Yaxshi', 'Ajoyib', 'A\'lo'];
                    document.getElementById('rating-message').textContent = `${value} - ${messages[value - 1]}`;
                });
            });

            // Comment form
            document.getElementById('commentForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const btn = document.getElementById('submitComment');
                const sendIcon = document.getElementById('sendIcon');
                const loadingIcon = document.getElementById('loadingIcon');
                const input = document.getElementById('commentInput');
                const error = document.getElementById('commentError');
                
                btn.disabled = true;
                sendIcon.classList.add('hidden');
                loadingIcon.classList.remove('hidden');
                error.classList.add('hidden');
                
                try {
                    const response = await fetch('{{ route('comment.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            learning_centers_id: {{ $LearningCenter->id }},
                            comment: input.value
                        })
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        const commentsList = document.getElementById('commentsList');
                        const newComment = document.createElement('div');
                        newComment.className = 'glass-card rounded-2xl p-6 comment-enter';
                        newComment.innerHTML = `
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">${data.user_name.charAt(0).toUpperCase()}</div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-gray-100">${data.user_name}</h4>
                                            <p class="text-xs text-gray-500">Hozirgina</p>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-gray-700 dark:text-gray-300">${input.value}</p>
                                </div>
                            </div>
                        `;
                        commentsList.insertBefore(newComment, commentsList.firstChild);
                        input.value = '';
                    } else {
                        const err = await response.json();
                        error.textContent = err.message || 'Xatolik yuz berdi';
                        error.classList.remove('hidden');
                    }
                } catch (err) {
                    error.textContent = 'Tarmoq xatoligi';
                    error.classList.remove('hidden');
                } finally {
                    btn.disabled = false;
                    sendIcon.classList.remove('hidden');
                    loadingIcon.classList.add('hidden');
                }
            });

            // Delete comment
            async function deleteComment(id) {
                if (!confirm('O\'chirishni tasdiqlaysizmi?')) return;
                
                try {
                    const response = await fetch(`/comments/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'DELETE'
                        }
                    });
                    
                    if (response.ok) {
                        document.getElementById(`comment-${id}`).remove();
                    }
                } catch (err) {
                    alert('O\'chirishda xatolik');
                }
            }
        </script>
    @endauth

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>


    @push('scripts')
        <!-- GLightbox -->
        <script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
        <script>
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true,
                draggable: true,
                openEffect: 'zoom',
                closeEffect: 'fade',
                slideEffect: 'slide',
                moreText: 'Yana',
                moreLength: 60,
                cssEfects: {
                    fade: { in: 'fadeIn', out: 'fadeOut' },
                    zoom: { in: 'zoomIn', out: 'zoomOut' },
                    slide: { in: 'slideInRight', out: 'slideOutLeft' }
                }
            });
        </script>
    @endpush

</x-layout>
