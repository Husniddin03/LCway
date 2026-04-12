@extends('layouts.user-sidebar')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@php
$totalCenters = $user->centers->count();
$verifiedCenters = $user->centers->where('checked', 1)->count();
$pendingCenters = $user->centers->where('checked', 0)->count();
$totalTeachers = $user->centers->sum(fn($c) => $c->teachers->count());
$totalSubjects = $user->centers->sum(fn($c) => $c->subjects->count());
$totalFavorites = $user->centers->sum(fn($c) => $c->favorites->count());
$totalComments = $user->centers->sum(fn($c) => $c->comments->count());
$recentCenters = $user->centers->sortByDesc('created_at')->take(5);
@endphp

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Salom, {{ $user->name }}! 👋</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-1">Dashboard'da o'z markazlaringizni boshqaring</p>
</div>

<!-- Statistics Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    <!-- Total Centers -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jami markazlar</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalCenters }}</p>
            </div>
            <div class="w-12 h-12 bg-violet-100 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-green-500 font-medium">+{{ $totalCenters > 0 ? 100 : 0 }}%</span>
            <span class="text-gray-400 ml-1">o'sish</span>
        </div>
    </div>

    <!-- Verified -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tasdiqlangan</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $verifiedCenters }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-gray-400">{{ $totalCenters > 0 ? round(($verifiedCenters / $totalCenters) * 100) : 0 }}% tasdiqlangan</span>
        </div>
    </div>

    <!-- Pending -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tekshirilmoqda</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $pendingCenters }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-gray-400">Kutilmoqda</span>
        </div>
    </div>

    <!-- Teachers -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">O'qituvchilar</p>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $totalTeachers }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-gray-400">Barcha markazlarda</span>
        </div>
    </div>

    <!-- Subjects -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Fanlar</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $totalSubjects }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-gray-400">Faol fanlar</span>
        </div>
    </div>

    <!-- Ratings -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Baholar</p>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $totalFavorites }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center text-sm">
            <span class="text-amber-500 font-medium">{{ $totalComments }}</span>
            <span class="text-gray-400 ml-1">izoh</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-gradient-to-r from-violet-600 to-purple-600 rounded-xl p-6 text-white mb-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold">Yangi markaz qo'shish</h3>
            <p class="text-white/80 text-sm">O'quv markazingizni qo'shing va ko'proq o'quvchilarni jalb qiling</p>
        </div>
        <a href="{{ route('course.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-violet-600 font-medium rounded-lg hover:shadow-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Markaz qo'shish
        </a>
    </div>
</div>

<!-- Recent Centers -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 dark:text-white">So'nggi markazlar</h3>
        <a href="{{ route('user.centers') }}" class="text-violet-600 dark:text-violet-400 hover:underline text-sm">Barchasini ko'rish</a>
    </div>
    @if($recentCenters->count() > 0)
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($recentCenters as $center)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center gap-3">
                        @if($center->logo)
                            <img src="{{ asset('storage/' . $center->logo) }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($center->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('center', $center->slug) }}" class="font-medium text-gray-900 dark:text-white hover:text-violet-600 dark:hover:text-violet-400">
                                {{ $center->name }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $center->region }}, {{ $center->province }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $center->teachers->count() }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                {{ $center->favorites->count() }}
                            </span>
                        </div>
                        <a href="{{ route('user.center.manage', $center->slug) }}" class="px-3 py-1 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 text-xs font-medium rounded-lg hover:bg-violet-200 dark:hover:bg-violet-900/50 transition-colors">
                            Batafsil
                        </a>
                        @if($center->checked)
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">Tasdiqlangan</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-medium rounded-full">Tekshirilmoqda</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <p class="text-gray-500 dark:text-gray-400">Hali markazlar yo'q</p>
            <a href="{{ route('course.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Markaz qo'shish
            </a>
        </div>
    @endif
</div>
@endsection
