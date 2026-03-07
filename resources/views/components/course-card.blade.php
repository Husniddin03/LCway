@props(['course', 'showCategory' => true, 'showRating' => true, 'showPrice' => true, 'compact' => false])

<x-card hover class="overflow-hidden group cursor-pointer"
    onclick="window.location.href='{{ route('course.show', $course->id) }}'">
    <!-- Course Image -->
    <div class="relative {{ $compact ? 'h-40' : 'h-48' }} overflow-hidden">
        @if ($course->image)
            <img src="{{ asset($course->image) }}" alt="{{ $course->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        @endif

        <!-- Category Badge -->
        @if ($showCategory && isset($course->category))
            <div class="absolute top-3 left-3">
                <x-badge variant="primary" size="sm">
                    {{ $course->category->name ?? 'Umumiy' }}
                </x-badge>
            </div>
        @endif

        <!-- Rating Badge -->
        @if ($showRating && $course->rating)
            <div
                class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm text-white px-2 py-1 rounded-lg text-xs font-medium flex items-center space-x-1">
                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span>{{ number_format($course->rating, 1) }}</span>
            </div>
        @endif
    </div>

    <!-- Course Content -->
    <div class="p-4">
        <h3
            class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
            {{ $course->title }}
        </h3>

        @if (!$compact)
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                {{ Str::limit($course->description ?? '', 100) }}
            </p>
        @endif

        <!-- Course Meta -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 text-sm text-gray-500 dark:text-gray-400">
                @if (isset($course->teacher))
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ $course->teacher->name }}</span>
                    </div>
                @endif

                @if ($course->duration)
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $course->duration }}</span>
                    </div>
                @endif
            </div>

            <!-- Price -->
            @if ($showPrice)
                <div class="text-right">
                    @if ($course->price > 0)
                        <div class="text-lg font-bold text-primary-600 dark:text-primary-400">
                            {{ number_format($course->price) }} so'm
                        </div>
                    @else
                        <div class="text-lg font-bold text-success-600 dark:text-success-400">
                            Bepul
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Students Count -->
        @if (isset($course->students_count) && $course->students_count > 0)
            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>{{ $course->students_count }} o'quvchi</span>
                </div>
            </div>
        @endif
    </div>
</x-card>
