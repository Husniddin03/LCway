@extends('layouts.user-sidebar')

@section('title', __('user.profile.title'))
@section('header', __('user.profile.title'))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Profile Info -->
    <div class="lg:col-span-1">
        <!-- Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
            <div class="relative w-24 h-24 mx-auto mb-4">
                @if(auth()->user()->avatar)
                    @if(str_starts_with(auth()->user()->avatar, 'http'))
                        <img src="{{ auth()->user()->avatar }}" class="w-24 h-24 rounded-full object-cover border-4 border-violet-100 dark:border-violet-900">
                    @else
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-24 h-24 rounded-full object-cover border-4 border-violet-100 dark:border-violet-900">
                    @endif
                @else
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-violet-100 dark:border-violet-900">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
            </div>
            
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</p>
            
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('d.m.Y') }}</span> {{ __('user.profile.member_since') }}
                </p>
            </div>

            <div class="mt-4 space-y-2">
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all text-sm font-medium w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    {{ __('user.profile.go_to_dashboard') }}
                </a>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded-lg hover:bg-violet-200 dark:hover:bg-violet-900/50 transition-colors text-sm font-medium w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    {{ __('user.profile.edit_profile') }}
                </a>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">{{ __('user.profile.statistics') }}</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('user.profile.centers') }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $user->centers->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('user.profile.teachers') }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $user->centers->sum(fn($c) => $c->teachers->count()) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('user.profile.ratings') }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $user->centers->sum(fn($c) => $c->favorites->count()) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('user.profile.comments') }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $user->centers->sum(fn($c) => $c->comments->count()) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ __('user.profile.personal_info') }}
                </h3>
                <a href="{{ route('profile.edit') }}" class="text-violet-600 dark:text-violet-400 hover:underline text-sm">{{ __('user.profile.edit') }}</a>
            </div>

            @if($user->userData)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.first_name') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->userData->first_name }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.last_name') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->userData->last_name }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.phone') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->userData->phone }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.gender') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->userData->gender_uzbek ?? '-' }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.birthday') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->userData->formatted_birthday ?? '-' }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.status') }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">{{ __('user.profile.active') }}</span>
                    </div>
                </div>

                @if($user->userData->bio)
                    <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('user.profile.bio') }}</p>
                        <p class="text-gray-900 dark:text-white">{{ $user->userData->bio }}</p>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-3">{{ __('user.profile.no_personal_info') }}</p>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('user.profile.fill_info') }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Security -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                {{ __('user.profile.security') }}
            </h3>
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ __('user.profile.password') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('user.profile.security_description') }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}#password" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                    {{ __('user.profile.change') }}
                </a>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-900/30 p-6">
            <h3 class="font-semibold text-red-600 dark:text-red-400 flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ __('user.profile.danger_zone') }}
            </h3>
            <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <div>
                    <p class="font-medium text-red-900 dark:text-red-300">{{ __('user.profile.delete_account') }}</p>
                    <p class="text-sm text-red-600 dark:text-red-400">{{ __('user.profile.delete_warning') }}</p>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('{{ __('user.profile.delete_confirm') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                        {{ __('user.profile.delete_account_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
