<x-layout>
    <x-slot:title>{{ $LearningCenter->name }} haqida batafsil ma'lumot</x-slot:title>
    
    <!-- Hero Section -->
    <section class="relative py-16 md:py-20 bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800 overflow-hidden">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $LearningCenter->name }}</h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">{{ $LearningCenter->type }}</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content Area -->
                <div class="lg:col-span-2">
                    <!-- Main Image -->
                    <div class="mb-8">
                        <div class="relative rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ asset('storage/' . $LearningCenter->logo) }}" 
                                 alt="{{ $LearningCenter->name }}" 
                                 class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    </div>

                    <!-- Rating and Meta Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                @php
                                    $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                                @endphp
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @php
                                                $diff = $average - $i;
                                            @endphp
                                            <span class="text-2xl {{ $average >= $i ? '' : ($diff > -1 && $diff < 0 ? 'opacity-50' : 'opacity-20') }}">
                                                ★
                                            </span>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $average }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $LearningCenter->user->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $LearningCenter->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Markaz haqida</h2>
                        <div class="prose prose-lg max-w-none text-gray-600 dark:text-gray-300">
                            <p>{{ $LearningCenter->about }}</p>
                        </div>
                    </div>

                    <!-- Image Gallery -->
                    @if($LearningCenter->images->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Rasmlar</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($LearningCenter->images as $image)
                                    <div class="relative group overflow-hidden rounded-xl">
                                        <img src="{{ asset('storage/' . $image->image) }}" 
                                             alt="Gallery image" 
                                             class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @auth
                                @can('isOun', $LearningCenter)
                                    <div class="mt-6 text-center">
                                        <x-button variant="outline" href="{{ route('course.editImage', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Rasmlarni tahrirlash
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @endif

                    <!-- Schedule Section -->
                    @if($LearningCenter->calendar && $LearningCenter->calendar->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Ish grafigi</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($LearningCenter->calendar as $calendar)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $calendar->weekdays }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ date('H:i', strtotime($calendar->open_time)) }} - {{ date('H:i', strtotime($calendar->close_time)) }}
                                            </p>
                                        </div>
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @auth
                                @can('isOun', $LearningCenter)
                                    <div class="mt-6 text-center">
                                        <x-button variant="outline" href="{{ route('course.weekday', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Grafikni tahrirlash
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @endif

                    <!-- Teachers Section -->
                    @if($LearningCenter->teachers->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Ustozlar</h2>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Yangi ustoz
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                            
                            <div class="space-y-6">
                                @foreach ($LearningCenter->teachers as $teacher)
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 relative">
                                                @if(isset($teacher->photo))
                                                    <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                                         alt="{{ $teacher->name }}" 
                                                         class="w-16 h-16 rounded-full object-cover ring-2 ring-white dark:ring-gray-700">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ $teacher->name }}&background=random&size=64" 
                                                         alt="{{ $teacher->name }}" 
                                                         class="w-16 h-16 rounded-full ring-2 ring-white dark:ring-gray-700">
                                                @endif
                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-700"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $teacher->name }}</h4>
                                                    @php
                                                        $teacherSubject = $teacher->teacherSubjects->first();
                                                        $subjectName = $teacherSubject?->subject?->subject_name ?? 'Fan biriktirilmagan';
                                                        $subjectType = $teacherSubject?->subject_type ?? '';
                                                    @endphp
                                                    <p class="text-primary-600 dark:text-primary-400 font-medium flex items-center mt-1">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                        {{ $subjectName }}
                                                        @if($subjectType)
                                                            <span class="ml-2 text-sm text-gray-500">({{ $subjectType }})</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $teacher->about }}</p>
                                                    @if($teacherSubject && $teacherSubject->price)
                                                        <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                                                            {{ number_format($teacherSubject->price) }} {{ $teacherSubject->currency ?? 'so\'m' }}/{{ $teacherSubject->period ?? 'oy' }}
                                                        </p>
                                                    @endif
                                                    <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        {{ $teacher->phone }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Teacher actions for owner -->
                                                @auth
                                                    @can('isOun', $LearningCenter)
                                                        <div class="flex items-center space-x-2">
                                                            <x-button variant="outline" size="sm" href="{{ route('teacher.edit', $teacher->id) }}" class="p-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </x-button>
                                                            <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Rostdan ham {{ $teacher->name }}ni o‘chirilsinmi?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ustozlar hozircha yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazida hozircha ustozlar ro'yxatlanmagan</p>
                                
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Birinchi ustozni qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @endif

                    <!-- Location Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Manzil</h2>
                        <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden">
                            <iframe src="https://www.google.com/maps?q={{ $LearningCenter->location }}&hl=uz&z=14&output=embed"
                                    allowfullscreen 
                                    loading="lazy"
                                    class="w-full h-96 rounded-xl border-0"></iframe>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="https://www.google.com/maps?q={{ $LearningCenter->location }}" 
                                   target="_blank" 
                                   class="text-primary-600 dark:text-primary-400 hover:underline">
                                    {{ $LearningCenter->address }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Izohlar</h2>
                        
                        <!-- Rating Form -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Markazni baholang</h3>
                            <div class="flex items-center space-x-4">
                                <div class="flex text-2xl" id="rating1" data-center-id="{{ $LearningCenter->id }}" @auth data-user-rating="{{ $userRating ?? 0 }}" @endauth>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $isActive = auth()->check() && $userRating && $i <= $userRating;
                                        @endphp
                                        <span class="star cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors {{ $isActive ? 'text-yellow-400 active' : '' }}" data-value="{{ $i }}">★</span>
                                    @endfor
                                </div>
                                <span id="result1" class="text-lg font-medium text-gray-600 dark:text-gray-400">
                                    @auth
                                        @if($userRating)
                                            @php
                                                $ratings_text = ['Juda yomon', 'Yomon', "O'rtacha", 'Yaxshi', 'Ajoyib'];
                                            @endphp
                                            {{ $userRating }} ⭐ - {{ $ratings_text[$userRating - 1] }}
                                        @endif
                                    @endauth
                                </span>
                            </div>
                        </div>
                        
                        @auth
                            <!-- AJAX Comment Form -->
                            <form id="commentForm" class="mb-8">
                                @csrf
                                <input type="hidden" name="learning_centers_id" value="{{ $LearningCenter->id }}">
                                <div class="flex space-x-4">
                                    <input name="comment" 
                                           id="commentInput"
                                           type="text" 
                                           placeholder="{{ $LearningCenter->name }} haqida fikringizni qoldiring..."
                                           class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                                           required>
                                    <button type="submit" id="submitComment" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl transition-colors duration-200 flex items-center">
                                        <svg id="sendIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        <svg id="loadingIcon" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p id="commentError" class="text-red-500 text-sm mt-2 hidden"></p>
                            </form>
                        @else
                            <!-- Guest Login/Register Prompt -->
                            <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <p class="text-gray-700 dark:text-gray-300 mb-4">Izoh qoldirish uchun tizimga kiring yoki ro'yxatdan o'ting</p>
                                <div class="flex gap-3">
                                    <a href="{{ route('signin') }}" class="flex-1 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-center rounded-lg transition-colors">
                                        Kirish
                                    </a>
                                    <a href="{{ route('signup') }}" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-center rounded-lg transition-colors">
                                        Ro'yxatdan o'tish
                                    </a>
                                </div>
                            </div>
                        @endauth
                        
                        <!-- Comments List -->
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 mb-3">Jami izohlar: <span id="commentsCount">{{ $LearningCenter->comments->count() }}</span></p>
                            <div id="commentsList" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                                @foreach ($LearningCenter->comments->reverse() as $comment)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl" id="comment-{{ $comment->id }}">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->user->email }}</p>
                                            </div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $comment->comment }}</p>
                                        
                                        @auth
                                            @can('myComment', $comment)
                                                <button onclick="deleteComment({{ $comment->id }})" class="mt-4 text-red-500 hover:text-red-700 text-sm transition-colors">
                                                    Izohni o'chirish
                                                </button>
                                            @endcan
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Quick Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tezkor ma'lumot</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Turi</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->type }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Manzil</p>
                                <a href="https://www.google.com/maps?q={{ $LearningCenter->location }}" 
                                   target="_blank" 
                                   class="text-primary-600 dark:text-primary-400 hover:underline text-sm">
                                    {{ $LearningCenter->address }}
                                </a>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Qo'shilgan sana</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->created_at->diffForHumans() }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">O'quvchilar soni</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $LearningCenter->student_count ?? 0 }}</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        @auth
                            @can('isOun', $LearningCenter)
                                <div class="mt-6 space-y-3">
                                    <x-button variant="primary" href="{{ route('course.edit', $LearningCenter->id) }}" class="w-full">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Tahrirlash
                                    </x-button>
                                    
                                    <form action="{{ route('course.destroy', $LearningCenter->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Rostdan ham {{ $LearningCenter->name }} markazini o‘chirilsinmi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-danger-600 hover:bg-danger-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            O'chirish
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        @endauth
                    </div>
                    
                    <!-- Subjects -->
                    @if($LearningCenter->subjects->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Fanlar</h3>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="outline" size="sm" href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                            
                            <div class="space-y-3">
                                @foreach ($LearningCenter->subjects as $subject)
                                    @php
                                        $subjectPivot = $subject->teacherSubjects->first();
                                    @endphp
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 flex items-center justify-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-accent-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($subject->subject_name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $subject->subject_name }}</p>
                                                @if($subjectPivot)
                                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ $subjectPivot->subject_type ?? 'Fan turi ko\'rsatilmagan' }}</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 italic">{{ $subjectPivot->description ?? 'Tavsif ko\'rsatilmagan' }}</p>
                                                    <p class="text-sm text-green-600 dark:text-green-400 font-semibold">{{ number_format($subjectPivot->price ?? 0) }} {{ $subjectPivot->currency ?? 'so\'m' }}/{{ $subjectPivot->period ?? 'oy' }}</p>
                                                @else
                                                    <p class="text-sm text-orange-500 dark:text-orange-400">O'qituvchi biriktirilmagan</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Subject actions for owner -->
                                        @auth
                                            @can('isOun', $LearningCenter)
                                                <div class="flex items-center space-x-2">
                                                    <x-button variant="outline" size="sm" href="{{ route('subject.edit', $subject->id) }}" class="p-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </x-button>
                                                    <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Rostdan ham {{ $subject->subject_name }} fani o\'chirilsinmi?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endcan
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Fanlar hozircha yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazida hozircha fanlar ro'yxatlanmagan</p>
                                
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Birinchi fanni qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @endif

                    <!-- Weekly Schedule -->
                    @if($LearningCenter->calendar && $LearningCenter->calendar->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 my-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Haftalik jadval
                                </h3>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="outline" size="sm" href="{{ route('course.weekday', $LearningCenter->id) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tahrirlash
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                            <div class="space-y-3">
                                @forelse ($LearningCenter->calendar as $schedule)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $schedule->weekdays }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $schedule->open_time ? substr($schedule->open_time, 0, 5) : '--:--' }} - {{ $schedule->close_time ? substr($schedule->close_time, 0, 5) : '--:--' }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <p>Jadval mavjud emas</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 my-8">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Jadval hozircha yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazda hozircha ish jadvali ko'rsatilmagan</p>
                                
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('course.weekday', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Jadval qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @endif

                    <!-- Social Networks -->
                    @if($LearningCenter->connections && $LearningCenter->connections->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    Ijtimoiy tarmoqlar
                                </h3>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="outline" size="sm" href="{{ route('connect.edit', $LearningCenter->id) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($LearningCenter->connections as $connection)
                                    @php
                                        $url = $connection->url;
                                        $name = strtolower($connection->connection_name);
                                        
                                        // Phone redirect
                                        if ($name === 'phone' || str_contains($url, 'tel:')) {
                                            $url = str_replace('tel:', '', $url);
                                            $href = 'tel:' . $url;
                                        }
                                        // Email redirect  
                                        elseif ($name === 'email' || str_contains($url, 'mailto:')) {
                                            $url = str_replace('mailto:', '', $url);
                                            $href = 'mailto:' . $url;
                                        }
                                        // Regular URL
                                        else {
                                            $href = $url;
                                        }
                                    @endphp
                                    <a href="{{ $href }}" 
                                       @if(!str_starts_with($href, 'tel:') && !str_starts_with($href, 'mailto:')) target="_blank" @endif
                                       class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                        <div class="w-8 h-8 flex items-center justify-center bg-white dark:bg-gray-600 rounded-lg mr-3">
                                            <x-social-icon :icon="$connection->connection_icon" size="w-5 h-5" />
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">{{ $connection->connection_name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ijtimoiy tarmoqlar yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazda hozircha aloqa ma'lumotlari ro'yxatlanmagan</p>
                                
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('connect.edit', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Aloqa qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @endif

                    <!-- Teacher Announcements -->
                    @if($LearningCenter->needTeachers && $LearningCenter->needTeachers->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                    O'qituvchi e'lonlari
                                </h3>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="outline" size="sm" href="{{ route('teacher.announcement', $LearningCenter->id) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            E'lon qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                            <div class="space-y-4">
                                @foreach ($LearningCenter->needTeachers as $announcement)
                                    <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700/50 rounded-xl">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($announcement->subject_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $announcement->subject_name }}</h4>
                                                @if($announcement->subject_type)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $announcement->subject_type }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($announcement->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">{{ $announcement->description }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">E'lonlar yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazda hozircha o'qituvchi e'lonlari yo'q</p>
                                
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary" href="{{ route('teacher.announcement', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            E'lon yaratish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-accent-600">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ushbu markazga qiziqish bildiraysizmi?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Bog'lanish orqali qo'shimcha ma'lumot oling yoki to'g'ridan-to'g'ri markazga murojaat qiling
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @foreach ($LearningCenter->connections as $connection)
                    @php
                        $url = $connection->url;
                        $name = strtolower($connection->connection_name);
                        
                        // Phone redirect
                        if ($name === 'phone' || str_contains($url, 'tel:')) {
                            $url = str_replace('tel:', '', $url);
                            $href = 'tel:' . $url;
                        }
                        // Email redirect  
                        elseif ($name === 'email' || str_contains($url, 'mailto:')) {
                            $url = str_replace('mailto:', '', $url);
                            $href = 'mailto:' . $url;
                        }
                        // Regular URL
                        else {
                            $href = $url;
                        }
                    @endphp
                    <a href="{{ $href }}" 
                       @if(!str_starts_with($href, 'tel:') && !str_starts_with($href, 'mailto:')) target="_blank" @endif
                       class="bg-white/10 border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-6 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <x-social-icon :icon="$connection->connection_icon" size="w-5 h-5" />
                        </span>
                        <span>{{ $connection->connection_name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>

<style>
    /* Rating System Styles */
    .star {
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .star:hover {
        transform: scale(1.1);
    }

    .star.hover {
        color: #fbbf24;
    }

    .star.active {
        color: #f59e0b;
    }

    /* Dark mode adjustments */
    .dark .star.hover {
        color: #fbbf24;
    }

    .dark .star.active {
        color: #f59e0b;
    }
</style>


@auth
    <script>
        // Rating functionality
        document.addEventListener('DOMContentLoaded', function() {
            const ratings = {};

            function initRating(ratingId, resultId) {
                const starsContainer = document.getElementById(ratingId);
                if (!starsContainer) return;
                
                const stars = starsContainer.querySelectorAll('.star');

                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => {
                        const value = star.dataset.value;
                        highlightStars(stars, value);
                    });

                    star.addEventListener('click', () => {
                        const value = star.dataset.value;
                        const centerId = starsContainer.dataset.centerId;
                        ratings[ratingId] = value;

                        // Update stars
                        stars.forEach(s => {
                            if (s.dataset.value <= value) {
                                s.classList.add('active');
                            } else {
                                s.classList.remove('active');
                            }
                        });

                        updateResult(resultId, value);

                        // Send rating to server
                        sendRating(centerId, value);
                    });
                });

                starsContainer.addEventListener('mouseleave', () => {
                    const savedRating = ratings[ratingId];
                    if (savedRating) {
                        highlightStars(stars, savedRating);
                    } else {
                        stars.forEach(s => s.classList.remove('hover'));
                    }
                });
            }

            function highlightStars(stars, value) {
                stars.forEach(star => {
                    if (star.dataset.value <= value) {
                        star.classList.add('hover');
                    } else {
                        star.classList.remove('hover');
                    }
                });
            }

            function updateResult(resultId, value) {
                const resultEl = document.getElementById(resultId);
                if (!resultEl) return;
                
                const ratings_text = ['Juda yomon', 'Yomon', "O'rtacha", 'Yaxshi', 'Ajoyib'];
                resultEl.textContent = `${value} ⭐ - ${ratings_text[value - 1]}`;
            }

            // Send rating to server
            function sendRating(centerId, value) {
                fetch('/comment/favoriteStore', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rating: value,
                        learning_centers_id: centerId
                    })
                })
                .then(async response => {
                    const text = await response.text();

                    try {
                        const data = JSON.parse(text);
                        if (!response.ok) {
                            console.error('Server returned error:', data);
                        } else {
                            console.log('Reyting yuborildi:', data);
                        }
                    } catch (err) {
                        console.error('JSON.parse xatosi:', err);
                        console.error('Server returned raw text:', text);
                    }
                })
                .catch(error => {
                    console.error('Fetch xatosi:', error);
                });
            }

            // Initialize rating
            initRating('rating1', 'result1');
        });

        document.getElementById('commentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitComment');
            const sendIcon = document.getElementById('sendIcon');
            const loadingIcon = document.getElementById('loadingIcon');
            const errorDiv = document.getElementById('commentError');
            const input = document.getElementById('commentInput');
            
            // Show loading state
            submitBtn.disabled = true;
            sendIcon.classList.add('hidden');
            loadingIcon.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            
            try {
                const response = await fetch('{{ route('comment.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
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
                    
                    // Add new comment to list
                    const commentsList = document.getElementById('commentsList');
                    const newComment = document.createElement('div');
                    newComment.className = 'p-4 bg-gray-50 dark:bg-gray-700 rounded-xl';
                    newComment.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">${data.user_name}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">${data.user_email}</p>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Hozirgina</span>
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">${input.value}</p>
                        <button onclick="deleteComment(${data.comment_id})" class="mt-4 text-red-500 hover:text-red-700 text-sm transition-colors">
                            Izohni o'chirish
                        </button>
                    `;
                    commentsList.insertBefore(newComment, commentsList.children[1]);
                    
                    // Update count
                    const countSpan = document.getElementById('commentsCount');
                    countSpan.textContent = parseInt(countSpan.textContent) + 1;
                    
                    // Clear input
                    input.value = '';
                } else {
                    const error = await response.json();
                    errorDiv.textContent = error.message || 'Xatolik yuz berdi';
                    errorDiv.classList.remove('hidden');
                }
            } catch (err) {
                errorDiv.textContent = 'Tarmoq xatosi. Qayta urinib ko\'ring.';
                errorDiv.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                sendIcon.classList.remove('hidden');
                loadingIcon.classList.add('hidden');
            }
        });

        async function deleteComment(commentId) {
            if (!confirm('Rostdan bu izohni o\'chirilsinmi?')) return;
            
            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                });
                
                if (response.ok) {
                    document.getElementById(`comment-${commentId}`).remove();
                    const countSpan = document.getElementById('commentsCount');
                    countSpan.textContent = parseInt(countSpan.textContent) - 1;
                }
            } catch (err) {
                alert('Izohni o\'chirishda xatolik yuz berdi');
            }
        }
    </script>
@endauth