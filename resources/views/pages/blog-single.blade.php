<x-layout>
    <x-slot:title>{{ $LearningCenter->name }} haqida batafsil ma'lumot</x-slot:title>

    <!-- Hero Section -->
    <section
        class="relative py-16 md:py-20 bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800 overflow-hidden">
        <!-- Background Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-accent-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-white">{{ $LearningCenter->name }}
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto text-gray-900 dark:text-white">
                    {{ $LearningCenter->type }}</p>
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
                            <img src="{{ asset('storage/' . $LearningCenter->logo) }}" alt="{{ $LearningCenter->name }}"
                                class="w-full h-96 object-cover">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
                            </div>
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
                                            <span
                                                class="text-2xl {{ $average >= $i ? '' : ($diff > -1 && $diff < 0 ? 'opacity-50' : 'opacity-20') }}">
                                                ★
                                            </span>
                                        @endfor
                                    </div>
                                    <span
                                        class="ml-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $average }}</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $LearningCenter->user->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                    @if ($LearningCenter->images->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Rasmlar</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($LearningCenter->images as $image)
                                    <div class="relative group overflow-hidden rounded-xl">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Gallery image"
                                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @auth
                                @can('isOun', $LearningCenter)
                                    <div class="mt-6 text-center">
                                        <x-button variant="outline"
                                            href="{{ route('course.editImage', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Rasmlarni tahrirlash
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Rasmlar</h2>


                            @auth
                                @can('isOun', $LearningCenter)
                                    <div class="mt-6 text-center">
                                        <x-button variant="outline"
                                            href="{{ route('course.editImage', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Rasmlar qo'shish
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @endif

                    <!-- Schedule Section -->
                    @if ($LearningCenter->calendar->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Ish grafigi</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($LearningCenter->calendar as $calendar)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $calendar->calendar->weekdays }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ date('H:i', strtotime($calendar->open_time)) }} -
                                                {{ date('H:i', strtotime($calendar->close_time)) }}
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Grafikni tahrirlash
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Ish grafigi</h2>

                            @auth
                                @can('isOun', $LearningCenter)
                                    <div class="mt-6 text-center">
                                        <x-button variant="outline" href="{{ route('course.weekday', $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Grafikni qo'shish
                                        </x-button>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @endif

                    <!-- Teachers Section -->
                    @if ($LearningCenter->teachers->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Ustozlar</h2>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary"
                                            href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Yangi ustoz
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>

                            <div class="space-y-6">
                                @foreach ($LearningCenter->teachers as $teacher)
                                    <div
                                        class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 relative">
                                                @if (isset($teacher->photo))
                                                    <img src="{{ asset('storage/' . $teacher->photo) }}"
                                                        alt="{{ $teacher->name }}"
                                                        class="w-16 h-16 rounded-full object-cover ring-2 ring-white dark:ring-gray-700">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ $teacher->name }}&background=random&size=64"
                                                        alt="{{ $teacher->name }}"
                                                        class="w-16 h-16 rounded-full ring-2 ring-white dark:ring-gray-700">
                                                @endif
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-700">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h4
                                                        class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                                        {{ $teacher->name }}</h4>
                                                    <p
                                                        class="text-primary-600 dark:text-primary-400 font-medium flex items-center mt-1">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                        {{ $teacher->subject->name }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                                        {{ $teacher->about }}</p>
                                                    <div
                                                        class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        {{ $teacher->phone }}
                                                    </div>
                                                </div>

                                                <!-- Teacher actions for owner -->
                                                @auth
                                                    @can('isOun', $LearningCenter)
                                                        <div
                                                            class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <x-button variant="outline" size="sm"
                                                                href="{{ route('teacher.edit', $teacher->id) }}"
                                                                class="p-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </x-button>
                                                            <form action="{{ route('teacher.destroy', $teacher->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Rostdan ham {{ $teacher->name }}ni o‘chirilsinmi?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                <div
                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ustozlar hozircha
                                    yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazida hozircha ustozlar
                                    ro'yxatlanmagan</p>

                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary"
                                            href="{{ route('teacher.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
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
                            <iframe
                                src="https://www.google.com/maps?q={{ $LearningCenter->location }}&hl=uz&z=14&output=embed"
                                allowfullscreen loading="lazy" class="w-full h-96 rounded-xl border-0"></iframe>
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="https://www.google.com/maps?q={{ $LearningCenter->location }}"
                                    target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">
                                    {{ $LearningCenter->address }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    @auth
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Izohlar</h2>

                            <!-- Rating Form -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Markazni baholang</h3>
                                <div class="flex items-center space-x-4">
                                    <div class="flex text-2xl" id="rating1"
                                        data-center-id="{{ $LearningCenter->id }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="star cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors"
                                                data-value="{{ $i }}">★</span>
                                        @endfor
                                    </div>
                                    <span id="result1"
                                        class="text-lg font-medium text-gray-600 dark:text-gray-400"></span>
                                </div>
                            </div>

                            <!-- Comment Form -->
                            <form action="{{ route('comment.store') }}" method="POST" class="mb-8">
                                @csrf
                                <input type="hidden" name="learning_centers_id" value="{{ $LearningCenter->id }}">
                                <div class="flex space-x-4">
                                    <input name="comment" type="text"
                                        placeholder="{{ $LearningCenter->name }} haqida fikringizni qoldiring..."
                                        class="text-gray-900 bg-white dark:text-white flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                    <button type="submit"
                                        class="text-gray-900 dark:text-white bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                <p class="text-gray-600 dark:text-gray-400">Jami izohlar:
                                    {{ $LearningCenter->comments->count() }}</p>
                                @foreach ($LearningCenter->comments->reverse() as $comment)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $comment->user->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $comment->user->email }}</p>
                                            </div>
                                            <span
                                                class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $comment->comment }}</p>

                                        @auth
                                            @can('myComment', $comment)
                                                <form action="{{ route('comment.delete', $comment->id) }}" method="POST"
                                                    onsubmit="return confirm('Rostdan bu izohni o‘chirilsinmi?');" class="mt-4">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 text-sm transition-colors">
                                                        Izohni o'chirish
                                                    </button>
                                                </form>
                                            @endcan
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Quick Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 static md:sticky md:top-16 mb-8">
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
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $LearningCenter->created_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">O'quvchilar soni</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $LearningCenter->student_count ?? 0 }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @auth
                            @can('isOun', $LearningCenter)
                                <div class="mt-6 space-y-3">
                                    <x-button variant="primary" href="{{ route('course.edit', $LearningCenter->id) }}"
                                        class="w-full">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Tahrirlash
                                    </x-button>

                                    <form action="{{ route('course.destroy', $LearningCenter->id) }}" method="POST"
                                        onsubmit="return confirm('Rostdan ham {{ $LearningCenter->name }} markazini o‘chirilsinmi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-gray-900 dark:text-white w-full bg-danger-600 hover:bg-danger-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            O'chirish
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        @endauth
                    </div>

                    <!-- Subjects -->
                    @if ($LearningCenter->subjects->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mt-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Fanlar</h3>
                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="outline" size="sm"
                                            href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Qo'shish
                                        </x-button>
                                    @endcan
                                @endauth
                            </div>

                            <div class="space-y-3">
                                @foreach ($LearningCenter->subjects as $subject)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 flex items-center justify-center">
                                                <!-- @if (isset($subject->subject->icon))
<img src="{{ asset('storage/' . $subject->subject->icon) }}"
                                                         alt="{{ $subject->subject->name }}"
                                                         class="w-8 h-8 rounded-full object-cover">
@else
<div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-accent-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                        {{ strtoupper(substr($subject->subject->name, 0, 1)) }}
                                                    </div>
@endif -->
                                                <div
                                                    class="text-gray-900 dark:text-white w-8 h-8 bg-gradient-to-br from-primary-400 to-accent-400 rounded-full flex items-center justify-center text-white font-bold text-sm bg-gray-100 border border-gray-200 dark:bg-gray-800">
                                                    {{ strtoupper(substr($subject->subject->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <p
                                                    class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                                    {{ $subject->subject->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ number_format($subject->price) }} so'm/oy</p>
                                            </div>
                                        </div>

                                        <!-- Subject actions for owner -->
                                        @auth
                                            @can('isOun', $LearningCenter)
                                                <div
                                                    class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <x-button variant="outline" size="sm"
                                                        href="{{ route('subject.edit', $subject->id) }}" class="p-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </x-button>
                                                    <form action="{{ route('subject.destroy', $subject->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Rostdan ham {{ $subject->subject->name }} fani o‘chirilsinmi?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-red-500 hover:text-red-700 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                <div
                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Fanlar hozircha
                                    yo'q</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">Bu o'quv markazida hozircha fanlar
                                    ro'yxatlanmagan</p>

                                @auth
                                    @can('isOun', $LearningCenter)
                                        <x-button variant="primary"
                                            href="{{ route('subject.create', 'id=' . $LearningCenter->id) }}">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Birinchi fanni qo'shish
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
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 text-gray-900 dark:text-white">
                Ushbu markazga qiziqish bildiraysizmi?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto text-gray-900 dark:text-white">
                Bog'lanish orqali qo'shimcha ma'lumot oling yoki to'g'ridan-to'g'ri markazga murojaat qiling
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @foreach ($LearningCenter->connections as $connection)
                    @if ($connection->connection->name == 'Phone')
                        <a href="tel:{{ $connection->url }}"
                            class="bg-white text-primary-600 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $connection->url }}
                        </a>
                    @elseif($connection->connection->name == 'Email')
                        <a href="mailto:{{ $connection->url }}"
                            class="bg-white/10 border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal"
        class="fixed inset-0 bg-black bg-opacity-90 z-[9999] hidden items-center justify-center p-4"
        style="backdrop-filter: blur(4px);">
        <div class="relative max-w-7xl max-h-full">
            <button onclick="closeImagePreview()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="previewImage" src="" alt="Preview"
                class="max-w-full max-h-[80vh] rounded-lg shadow-2xl">
            <div class="text-center mt-4">
                <p id="imageCaption" class="text-white text-lg font-medium"></p>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        function openImagePreview(imageSrc, caption = '') {
            console.log('Opening image preview:', imageSrc); // Debug log
            const modal = document.getElementById('imagePreviewModal');
            const previewImage = document.getElementById('previewImage');
            const imageCaption = document.getElementById('imageCaption');

            previewImage.src = imageSrc;
            imageCaption.textContent = caption;
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            console.log('Closing image preview'); // Debug log
            const modal = document.getElementById('imagePreviewModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImagePreview();
            }
        });

        // Close modal on background click
        document.getElementById('imagePreviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImagePreview();
            }
        });

        // Add click handlers to all images when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Main image - use more specific selector
            const mainImage = document.querySelector('img[alt="{{ $LearningCenter->name }}"]');
            if (mainImage) {
                mainImage.style.cursor = 'pointer';
                mainImage.addEventListener('click', function() {
                    openImagePreview(this.src, '{{ $LearningCenter->name }}');
                });
            }

            // Gallery images - use better selector
            const galleryImages = document.querySelectorAll('img[alt="Gallery image"]');
            galleryImages.forEach(function(img) {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    openImagePreview(this.src, 'Galereya rasmi');
                });
            });

            // Teacher photos - use more specific selector
            const teacherPhotos = document.querySelectorAll('img[alt*=""]');
            teacherPhotos.forEach(function(img) {
                // Skip main image and gallery images (already handled)
                if (img.alt !== '{{ $LearningCenter->name }}' && img.alt !== 'Gallery image') {
                    img.style.cursor = 'pointer';
                    img.addEventListener('click', function() {
                        const teacherCard = this.closest('.group');
                        if (teacherCard) {
                            const teacherName = teacherCard.querySelector('h4');
                            if (teacherName) {
                                openImagePreview(this.src, teacherName.textContent);
                            } else {
                                openImagePreview(this.src, 'Ustoz rasmi');
                            }
                        }
                    });
                }
            });

            // Also add preview to any other images that might be added dynamically
            setTimeout(function() {
                const allImages = document.querySelectorAll('img:not([onclick])');
                allImages.forEach(function(img) {
                    if (!img.style.cursor || img.style.cursor !== 'pointer') {
                        img.style.cursor = 'pointer';
                        img.addEventListener('click', function() {
                            openImagePreview(this.src, img.alt || 'Rasm');
                        });
                    }
                });
            }, 1000);
        });
    </script>
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
                    console.log('Raw response text:', text);

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
</script>
