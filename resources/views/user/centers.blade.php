@extends('layouts.user-sidebar')

@section('title', 'Markazlarim')
@section('header', 'Mening Markazlarim')

@section('content')
<!-- Header & Actions -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mening Markazlarim</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Barcha o'quv markazlaringizni boshqaring</p>
    </div>
    <a href="{{ route('course.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Yangi markaz
    </a>
</div>

<!-- Centers Grid -->
@if($centers->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($centers as $center)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden card-hover">
                <!-- Center Image -->
                <div class="relative h-48 bg-gradient-to-br from-violet-500 to-purple-600">
                    @if($center->logo)
                        <img src="{{ asset('storage/' . $center->logo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-white text-4xl font-bold">{{ strtoupper(substr($center->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @if($center->checked)
                            <span class="px-2 py-1 bg-green-500/90 text-white text-xs font-medium rounded-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Tasdiqlangan
                            </span>
                        @else
                            <span class="px-2 py-1 bg-yellow-500/90 text-white text-xs font-medium rounded-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tekshirilmoqda
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Center Info -->
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $center->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $center->region }}, {{ $center->province }}
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="text-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $center->teachers->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">O'qituvchi</p>
                        </div>
                        <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $center->subjects->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Fan</p>
                        </div>
                        <div class="text-center p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                            <p class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $center->favorites->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Baho</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('center', $center->slug) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Saytda ko'rish
                        </a>
                        <a href="{{ route('user.center.manage', $center->slug) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Batafsil
                        </a>
                    </div>

                    <!-- More Actions Dropdown -->
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex flex-wrap gap-2">
                        <a href="{{ route('course.edit', $center->slug) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-2-600 dark:text-pink-400 hover:bg-pink-50 dark:hover:bg-pink-900/20 rounded-lg transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Tahrirlash
                        </a>
                        <form action="{{ route('course.destroy', $center->slug) }}" method="POST" class="inline ml-auto" onsubmit="return confirm('Markazni o\'chirishni tasdiqlaysizmi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                O'chirish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($centers->hasPages())
        <div class="mt-8">
            {{ $centers->links('pagination::tailwind') }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Hali markazlar yo'q</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">O'zingizning o'quv markazingizni qo'shing va minglab o'quvchilarga xizmat ko'rsating</p>
        <a href="{{ route('course.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Birinchi markazni qo'shish
        </a>
    </div>
@endif
@endsection
