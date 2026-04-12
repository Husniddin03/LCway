@extends('layouts.user-sidebar')

@section('title', $center->name . ' - Boshqaruv')
@section('header', $center->name)

@section('content')
<div class="space-y-6" x-data="centerManager()">
    <!-- Toast Notifications -->
    <div x-show="toast.show" x-transition class="fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium"
         :class="toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'">
        <span x-text="toast.message"></span>
    </div>

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.centers') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            @if($center->logo)
                <img src="{{ asset('storage/' . $center->logo) }}" alt="{{ $center->name }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 dark:border-gray-700">
            @else
                <div class="w-16 h-16 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ substr($center->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $center->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $center->region }}, {{ $center->province }}</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('center', $center->slug) }}" target="_blank" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Saytda ko'rish
            </a>
            <a href="{{ route('course.edit', $center->slug) }}" class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Tahrirlash
            </a>
        </div>
    </div>

    <!-- Status & Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                    @if($center->checked)
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-medium rounded-full mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Tasdiqlangan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-sm font-medium rounded-full mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tekshirilmoqda
                        </span>
                    @endif
                </div>
                @if($center->premium)
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                @endif
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">O'qituvchilar</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400" x-text="stats.teachers">{{ $center->teachers->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Fanlar</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400" x-text="stats.subjects">{{ $center->subjects->count() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400">Baholar</p>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $center->favorites->count() }}</p>
        </div>
    </div>

    <!-- About -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Markaz haqida</h3>
            <a href="{{ route('course.edit', $center) }}" class="text-violet-600 dark:text-violet-400 hover:underline text-sm">Tahrirlash</a>
        </div>
        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $center->about ?: 'Ma\'lumot kiritilmagan' }}</p>
    </div>

    
    <!-- Yuridik malumotlar -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Yuridik malumotlar</h3>
            <a href="{{ route('course.edit', $center) }}" class="text-violet-600 dark:text-violet-400 hover:underline text-sm">Tahrirlash</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">TIN</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.tin || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Yuridik manzili</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.legal_address || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Litsenziya raqami</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.license_number || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ro'yxat sanasi</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.license_registration_date ? new Date(center.license_registration_date).toLocaleDateString('uz-UZ') : 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Amal qilish muddati</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.license_validity_period ? new Date(center.license_validity_period).toLocaleDateString('uz-UZ') : 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Menejer ismi</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.manager_name || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Telefon raqami</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.phone_number || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.email || 'Kiritilmagan'"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">IFUT kodi</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.ifut_code || 'Kiritilmagan'"></p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">Hudud</p>
                <p class="font-medium text-gray-900 dark:text-white" x-text="center.territory || 'Kiritilmagan'"></p>
            </div>
        </div>
    </div>

    <!-- Contacts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aloqa ma'lumotlari (<span x-text="connections.length">{{ $center->connections->count() }}</span>)</h3>
            <button @click="openConnectionModal()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Qo‘shish
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3" x-show="connections.length > 0">
            <template x-for="conn in connections" :key="conn.id">
                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg group">
                    <div class="w-10 h-10 bg-white dark:bg-gray-600 rounded-lg flex items-center justify-center shadow-sm text-gray-500">
                        {{-- Default icon when no icon set --}}
                        <svg x-show="!conn.icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        {{-- Dynamic icon based on conn.icon --}}
                        <div x-show="conn.icon" x-html="getConnectionIcon(conn.icon)"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate" x-text="conn.name"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="conn.url"></p>
                    </div>
                    <button @click="deleteConnection(conn.id)" class="text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </template>
        </div>
        <div x-show="connections.length === 0" class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Aloqa ma'lumotlari yo'q</p>
            <button @click="openConnectionModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Qo‘shish
            </button>
        </div>
    </div>

    <!-- Teachers -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">O'qituvchilar (<span x-text="teachers.length">{{ $center->teachers->count() }}</span>)</h3>
            <button @click="openTeacherModal()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Qo‘shish
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-show="teachers.length > 0">
            <template x-for="teacher in teachers" :key="teacher.id">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow group">
                    <div class="flex items-start gap-3">
                        <!-- Photo or Initial -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0"
                             :class="teacher.photo ? 'bg-transparent' : 'bg-purple-100 dark:bg-purple-900/30'">
                            <img x-show="teacher.photo" :src="teacher.photo" class="w-full h-full object-cover" alt="">
                            <span x-show="!teacher.photo" class="text-purple-600 dark:text-purple-400 font-bold text-lg" x-text="teacher.name.charAt(0)"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-900 dark:text-white" x-text="teacher.name"></p>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openTeacherViewModal(teacher)" class="text-green-500 hover:text-green-700" title="O'qituvchi ma'lumotlari">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button @click="openTeacherSubjectModal(teacher)" class="text-blue-500 hover:text-blue-700" title="Fan biriktirish">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </button>
                                    <button @click="editTeacher(teacher)" class="text-violet-500 hover:text-violet-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button @click="deleteTeacher(teacher.id)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="teacher.phone || 'Telefon yo\'q'"></p>
                            <div class="mt-2 flex flex-wrap gap-1" x-show="teacher.subjects && teacher.subjects.length > 0">
                                <template x-for="subj in teacher.subjects" :key="subj.id">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300" x-text="subj.name"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div x-show="teachers.length === 0" class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <p class="text-gray-500 dark:text-gray-400 mb-3">O'qituvchilar yo'q</p>
            <button @click="openTeacherModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                O'qituvchi qo'shish
            </button>
        </div>
    </div>

    <!-- Subjects -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Fanlar (<span x-text="subjects.length">{{ $center->subjects->count() }}</span>)</h3>
            <button @click="openSubjectModal()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Qo‘shish
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-show="subjects.length > 0">
            <template x-for="subject in subjects" :key="subject.id">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-900 dark:text-white" x-text="subject.name"></p>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="editSubject(subject)" class="text-violet-500 hover:text-violet-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button @click="deleteSubject(subject.id)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><span x-text="subject.teacher_count || 0"></span> o'qituvchi</p>
                            <!-- Show assigned teachers -->
                            <div class="mt-2 flex flex-wrap gap-1" x-show="subject.teachers && subject.teachers.length > 0">
                                <template x-for="tchr in subject.teachers" :key="tchr.id">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300" x-text="tchr.name"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div x-show="subjects.length === 0" class="text-center py-8">
            <p class="text-gray-500 dark:text-gray-400 mb-3">Fanlar yo'q</p>
            <button @click="openSubjectModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Fan qo'shish
            </button>
        </div>
    </div>

    <!-- Work Schedule -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ish jadvali (<span x-text="weekdays.length">{{ $center->calendar->count() }}</span>)</h3>
            <button @click="openWeekdayModal()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Qo‘shish
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3" x-show="weekdays.length > 0">
            <template x-for="day in weekdays" :key="day.id">
                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        <span x-text="day.weekdays.substring(0, 2)"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white text-sm" x-text="day.weekdays"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <span x-text="day.open_time || '--:--'"></span> - <span x-text="day.close_time || '--:--'"></span>
                        </p>
                    </div>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="editWeekday(day)" class="p-1.5 text-violet-500 hover:text-violet-700 hover:bg-violet-50 dark:hover:bg-violet-900/20 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <button @click="deleteWeekday(day.id)" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
        <div x-show="weekdays.length === 0" class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Ish jadvali yo'q</p>
            <button @click="openWeekdayModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Jadval qo'shish
            </button>
        </div>
    </div>

    <!-- Images -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rasmlar (<span x-text="images.length">{{ $center->images->count() }}</span>)</h3>
            <button @click="openImageModal()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 rounded-lg hover:bg-pink-200 dark:hover:bg-pink-900/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Qo‘shish
            </button>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" x-show="images.length > 0">
            <template x-for="image in images" :key="image.id">
                <div class="relative group">
                    <img :src="image.url" @click="openLightboxFromIndex(images.indexOf(image))" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:opacity-90 transition-opacity">
                    <button @click="deleteImage(image.id)" class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </template>
        </div>
        <div x-show="images.length === 0" class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-gray-500 dark:text-gray-400 mb-3">Rasmlar yo'q</p>
            <button @click="openImageModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Rasm qo'shish
            </button>
        </div>
    </div>

    <!-- ================= MODALS ================= -->

    <!-- Connection Modal -->
    <x-modals.connection-modal />

    <!-- Teacher Modal -->
    <x-modals.teacher-modal />

    <!-- Subject Modal -->
    <x-modals.subject-modal />

    <!-- Enhanced Image Modal -->
    <x-modals.image-modal />

    <!-- Weekday Modal -->
    <x-modals.weekday-modal />

    <!-- Teacher-Subject Assignment Modal -->
    <x-modals.teacher-subject-modal />

    <!-- Teacher View Modal -->
    <x-modals.teacher-view-modal />
</div>

<script>
    function centerManager() {
        return {
            centerSlug: '{{ $center->slug }}',
            csrfToken: '{{ csrf_token() }}',
            stats: {
                teachers: {{ $center->teachers->count() }},
                subjects: {{ $center->subjects->count() }}
            },
            connections: @js($connectionsData),
            teachers: @js($teachersData),
            subjects: @js($subjectsData),
            images: @js($imagesData),
            weekdays: @js($weekdaysData),
            modals: { connection: false, teacher: false, subject: false, image: false, weekday: false, teacherSubject: false, teacherView: false },
            // Teacher-subject assignment state
            selectedTeacher: null,
            selectedSubjectIds: [],
            viewingTeacher: null,
            teacherSubjectForm: {
                subject_id: '',
                subject_type: '',
                subject_icon: '',
                description: '',
                price: '',
                currency: 'UZS',
                period: ''
            },
            editing: { connection: null, teacher: null, subject: null },
            connectionError: '',
            forms: {
                connection: { name: '', url: '', icon: '' },
                teacher: { name: '', phone: '', about: '', photo: '' },
                subject: { name: '' },
                image: { file: null, preview: null }
            },
            // Teacher image preview
            teacherImagePreview: null,
            // Weekday form state
            weekdayForm: {
                show: false,
                editing: false,
                id: null,
                weekdays: '',
                open_time: '',
                close_time: ''
            },
            // Image upload state
            imageUploads: {
                files: [],
                previews: [],
                uploading: false
            },
            // Lightbox state
            lightbox: {
                show: false,
                currentIndex: 0,
                currentImage: ''
            },
            toast: { show: false, message: '', type: 'success' },

            showToast(message, type = 'success') {
                this.toast = { show: true, message, type };
                setTimeout(() => this.toast.show = false, 3000);
            },

            // Get connection icon SVG based on icon name
            getConnectionIcon(icon) {
                const icons = {
                    'telegram': '<svg class="w-5 h-5" viewBox="0 0 496 512" fill="currentColor"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"/></svg>',
                    'phone': '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.81 12.81 0 0 0 .62 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.62A2 2 0 0 1 22 16.92z"/></svg>',
                    'email': '<svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.8-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.5 21.1 15.4 56.7 47.8 92.2 47.6 35.5.2 71-32.2 92.2-47.6 102-74.1 131.6-96.3 154-113.5zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.5 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/></svg>',
                    'instagram': '<svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>',
                    'facebook': '<svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>',
                    'website': '<svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64h185.4c2.2 20.4 3.3 41.8 3.3 64zm151.9-64c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64h123.1zm-10.5-32H376.7c-10-63.8-29.8-117.4-55.3-151.6 78.3 20.7 142 77.5 170.1 151.6zm-105.1 0H175.7c9.3-59.7 27.8-110.1 51.3-143.3 19.3-27.3 41.2-45.6 69-45.6s49.7 18.3 69 45.6c23.5 33.2 42.1 83.6 51.3 143.3zM8.1 192c-5.3 20.5-8.1 41.9-8.1 64s2.8 43.5 8.1 64h123.1c-2.1-20.6-3.2-42-3.2-64s1.1-43.4 3.2-64H8.1zm110.4-32C146.6 85.9 210.3 29.1 288.6 8.4c-25.5 34.2-45.3 87.8-55.3 151.6H118.5zm3.1 192h115.2c10 63.8 29.8 117.4 55.3 151.6-78.3-20.7-142-77.5-170.1-151.6zm105.1 0h218.6c-9.3 59.7-27.8 110.1-51.3 143.3-19.3 27.3-41.2 45.6-69 45.6s-49.7-18.3-69-45.6c-23.5-33.2-42.1-83.6-51.3-143.3zM393.5 352h110.4c-28.1 74.1-91.8 130.9-170.1 151.6 25.5-34.2 45.3-87.8 55.3-151.6z"/></svg>',
                    'youtube': '<svg class="w-5 h-5" viewBox="0 0 576 512" fill="currentColor"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-318.71 213.986V195.669l142.739 71.37-142.739 71.03z"/></svg>',
                    'whatsapp': '<svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-97.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 185.7-186.4 185.7zm101.9-138.8c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7s-12.5-30.1-17.1-41.2c-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2s-9.7 1.4-14.8 6.9c-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>',
                    'linkedin': '<svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>',
                    'twitter': '<svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M459.37 151.72c.32 4.55.32 9.1.32 13.65 0 138.72-105.58 298.56-298.56 298.56-59.45 0-114.68-17.22-161.14-47.11 8.45.97 16.57 1.3 25.12 1.3 49.05 0 94.21-16.58 130.13-44.83-46.13-.97-84.79-31.19-98.11-72.77 6.5.97 13 1.62 19.82 1.62 9.42 0 18.84-1.3 27.61-3.57-48.08-9.75-84.14-52-84.14-102.98v-1.3c13.97 7.79 30.21 12.67 47.43 13.32-28.26-18.84-46.79-51.3-46.79-87.85 0-19.49 5.2-37.36 14.35-52.95 51.72 63.67 129.32 105.26 216.37 109.81-1.62-7.8-2.6-15.92-2.6-24.04 0-57.82 46.79-104.62 104.62-104.62 30.21 0 57.48 12.67 76.67 33.14 23.73-4.55 46.13-13.32 66.24-25.69-7.79 24.04-24.04 44.34-46.13 57.05 21.12-2.27 41.58-8.15 60.43-16.3-14.03 20.77-32.48 39.31-52.63 54.25z"/></svg>',
                    'tiktok': '<svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.25V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17A122.2 122.2 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14V209.9z"/></svg>',
                    'location': '<svg class="w-5 h-5" viewBox="0 0 384 512" fill="currentColor"><path d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.8 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg>',
                    'clock': '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                };
                return icons[icon] || '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
            },

            // Connection Modal
            openConnectionModal(conn = null) {
                this.editing.connection = conn;
                this.forms.connection = conn ? { name: conn.name, url: conn.url, icon: conn.icon || '' } : { name: '', url: '', icon: '' };
                this.modals.connection = true;
            },
            closeConnectionModal() {
                this.modals.connection = false;
                this.editing.connection = null;
            },
            async saveConnection() {
                const url = this.editing.connection 
                    ? `/api/centers/${this.centerSlug}/connections/${this.editing.connection.id}` 
                    : `/api/centers/${this.centerSlug}/connections`;
                const method = this.editing.connection ? 'PUT' : 'POST';
                
                const res = await fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken },
                    body: JSON.stringify(this.forms.connection)
                });
                const data = await res.json();
                if (data.success) {
                    if (this.editing.connection) {
                        const idx = this.connections.findIndex(c => c.id === this.editing.connection.id);
                        this.connections[idx] = data.data;
                    } else {
                        this.connections.push(data.data);
                    }
                    this.showToast(this.editing.connection ? 'Yangilandi' : 'Qo\'shildi');
                    this.closeConnectionModal();
                } else {
                    this.showToast(data.message || 'Xatolik yuz berdi', 'error');
                }
            },
            async deleteConnection(id) {
                if (!confirm('O\'chirishni tasdiqlaysizmi?')) return;
                const res = await fetch(`/api/centers/${this.centerSlug}/connections/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    this.connections = this.connections.filter(c => c.id !== id);
                    this.showToast('O\'chirildi');
                }
            },

            // Teacher Modal
            openTeacherModal(teacher = null) {
                this.editing.teacher = teacher;
                this.forms.teacher = teacher ? { name: teacher.name, phone: teacher.phone || '', about: teacher.about || '', photo: teacher.photo || '' } : { name: '', phone: '', about: '', photo: '' };
                this.teacherImagePreview = null;
                this.modals.teacher = true;
            },
            previewTeacherImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.teacherImagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            removeTeacherImage() {
                this.teacherImagePreview = null;
                this.forms.teacher.photo = '';
                document.getElementById('teacher-image-input').value = '';
            },
            closeTeacherModal() {
                this.modals.teacher = false;
                this.editing.teacher = null;
            },
            editTeacher(teacher) {
                this.openTeacherModal(teacher);
            },
            openTeacherSubjectModal(teacher, existingAssignment = null) {
                this.selectedTeacher = teacher;
                if (existingAssignment) {
                    // Edit existing assignment
                    this.teacherSubjectForm = {
                        subject_id: existingAssignment.subject_id || '',
                        subject_type: existingAssignment.subject_type || '',
                        subject_icon: existingAssignment.subject_icon || '',
                        description: existingAssignment.description || '',
                        price: existingAssignment.price || '',
                        currency: existingAssignment.currency || 'UZS',
                        period: existingAssignment.period || ''
                    };
                } else {
                    // New assignment
                    this.teacherSubjectForm = {
                        subject_id: '',
                        subject_type: '',
                        subject_icon: '',
                        description: '',
                        price: '',
                        currency: 'UZS',
                        period: ''
                    };
                }
                this.modals.teacherSubject = true;
            },
            closeTeacherSubjectModal() {
                this.modals.teacherSubject = false;
                this.selectedTeacher = null;
                this.teacherSubjectForm = {
                    subject_id: '',
                    subject_type: '',
                    subject_icon: '',
                    description: '',
                    price: '',
                    currency: 'UZS',
                    period: ''
                };
            },

            // Teacher View Modal
            openTeacherViewModal(teacher) {
                this.viewingTeacher = teacher;
                this.modals.teacherView = true;
            },
            closeTeacherViewModal() {
                this.modals.teacherView = false;
                this.viewingTeacher = null;
            },

            // Helper functions for formatting
            getSubjectTypeText(type) {
                const types = {
                    'individual': 'Individual',
                    'group': 'Guruhli',
                    'both': 'Ikkalasi ham'
                };
                return types[type] || type;
            },

            getPeriodText(period) {
                const periods = {
                    'monthly': 'Oylik',
                    'course': 'Kurs davomida',
                    'hourly': 'Soatbay',
                    'per_lesson': 'Dars uchun'
                };
                return periods[period] || period;
            },

            formatPrice(price) {
                return new Intl.NumberFormat('uz-UZ').format(price);
            },
            get availableSubjects() {
                return this.subjects;
            },
            async saveTeacherSubject() {
                if (!this.selectedTeacher) {
                    this.showToast('O\'qituvchi tanlanmagan', 'error');
                    return;
                }
                if (!this.teacherSubjectForm.subject_id) {
                    this.showToast('Fan tanlang', 'error');
                    return;
                }
                
                const url = `/api/centers/${this.centerSlug}/teachers/${this.selectedTeacher.id}/subjects`;
                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken },
                        body: JSON.stringify(this.teacherSubjectForm)
                    });
                    const data = await res.json();
                    
                    if (data.success) {
                        // Update teacher's subjects in the list
                        const idx = this.teachers.findIndex(t => t.id === this.selectedTeacher.id);
                        if (idx !== -1) {
                            const subject = this.subjects.find(s => s.id === parseInt(this.teacherSubjectForm.subject_id));
                            if (subject) {
                                const newAssignment = {
                                    id: data.data.id,
                                    subject_id: data.data.subject_id,
                                    name: subject.name, // Use name from frontend subjects data
                                    pivot: { ...this.teacherSubjectForm }
                                };
                                if (!this.teachers[idx].subjects) {
                                    this.teachers[idx].subjects = [];
                                }
                                const existingIdx = this.teachers[idx].subjects.findIndex(s => s.id === subject.id);
                                if (existingIdx !== -1) {
                                    this.teachers[idx].subjects[existingIdx] = newAssignment;
                                } else {
                                    this.teachers[idx].subjects.push(newAssignment);
                                }
                            }
                        }
                        this.showToast('Fan biriktirildi');
                        this.closeTeacherSubjectModal();
                    } else {
                        this.showToast(data.message || 'Xatolik yuz berdi', 'error');
                    }
                } catch (error) {
                    console.error('Error saving teacher subject:', error);
                    this.showToast('Server xatosi, qayta urinib ko\'ring', 'error');
                }
            },
            async saveTeacher() {
                const url = this.editing.teacher 
                    ? `/api/centers/${this.centerSlug}/teachers/${this.editing.teacher.id}` 
                    : `/api/centers/${this.centerSlug}/teachers`;
                
                // Use FormData for file upload
                const formData = new FormData();
                formData.append('name', this.forms.teacher.name);
                formData.append('phone', this.forms.teacher.phone || '');
                formData.append('about', this.forms.teacher.about || '');
                
                // Add _method for PUT request when editing
                if (this.editing.teacher) {
                    formData.append('_method', 'PUT');
                }
                
                // Only send photo when there's a new upload (base64 preview exists)
                if (this.teacherImagePreview && this.teacherImagePreview.startsWith('data:')) {
                    // Convert base64 to blob and append as file
                    const response = await fetch(this.teacherImagePreview);
                    const blob = await response.blob();
                    formData.append('photo', blob, 'teacher-photo.jpg');
                }
                // Note: Don't send existing photo URL as 'photo' - backend only accepts file uploads
                
                const res = await fetch(url, {
                    method: 'POST', // Always use POST, Laravel handles PUT via _method parameter
                    headers: { 'X-CSRF-TOKEN': this.csrfToken },
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    if (this.editing.teacher) {
                        const idx = this.teachers.findIndex(t => t.id === this.editing.teacher.id);
                        this.teachers[idx] = { ...this.teachers[idx], ...data.data };
                    } else {
                        this.teachers.push(data.data);
                        this.stats.teachers++;
                    }
                    this.showToast(this.editing.teacher ? 'Yangilandi' : 'Qo\'shildi');
                    this.closeTeacherModal();
                }
            },
            async deleteTeacher(id) {
                if (!confirm('O\'chirishni tasdiqlaysizmi?')) return;
                const res = await fetch(`/api/centers/${this.centerSlug}/teachers/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    this.teachers = this.teachers.filter(t => t.id !== id);
                    this.stats.teachers--;
                    this.showToast('O\'chirildi');
                }
            },

            // Subject Modal
            openSubjectModal(subject = null) {
                this.editing.subject = subject;
                this.forms.subject = subject ? { name: subject.name } : { name: '' };
                this.modals.subject = true;
            },
            closeSubjectModal() {
                this.modals.subject = false;
                this.editing.subject = null;
            },
            editSubject(subject) {
                this.openSubjectModal(subject);
            },
            async saveSubject() {
                const url = this.editing.subject 
                    ? `/api/centers/${this.centerSlug}/subjects/${this.editing.subject.id}` 
                    : `/api/centers/${this.centerSlug}/subjects`;
                const res = await fetch(url, {
                    method: this.editing.subject ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken },
                    body: JSON.stringify(this.forms.subject)
                });
                const data = await res.json();
                if (data.success) {
                    if (this.editing.subject) {
                        const idx = this.subjects.findIndex(s => s.id === this.editing.subject.id);
                        this.subjects[idx] = { ...this.subjects[idx], name: data.data.name };
                    } else {
                        this.subjects.push({ ...data.data, teacher_count: 0 });
                        this.stats.subjects++;
                    }
                    this.showToast(this.editing.subject ? 'Yangilandi' : 'Qo\'shildi');
                    this.closeSubjectModal();
                }
            },
            async deleteSubject(id) {
                if (!confirm('O\'chirishni tasdiqlaysizmi?')) return;
                const res = await fetch(`/api/centers/${this.centerSlug}/subjects/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    this.subjects = this.subjects.filter(s => s.id !== id);
                    this.stats.subjects--;
                    this.showToast('O\'chirildi');
                }
            },

            // Image Modal
            openImageModal() {
                this.forms.image = { file: null, preview: null };
                this.modals.image = true;
            },
            closeImageModal() {
                this.modals.image = false;
            },
            handleImageUpload(e) {
                const file = e.target.files[0];
                if (file) {
                    this.forms.image.file = file;
                    this.forms.image.preview = URL.createObjectURL(file);
                }
            },
            async saveImage() {
                if (!this.forms.image.file) return;
                const formData = new FormData();
                formData.append('image', this.forms.image.file);
                const res = await fetch(`/api/centers/${this.centerSlug}/images`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken },
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    this.images.push(data.data);
                    this.showToast('Rasm qo\'shildi');
                    this.closeImageModal();
                }
            },
            async deleteImage(id) {
                if (!confirm('O\'chirishni tasdiqlaysizmi?')) return;
                const res = await fetch(`/api/centers/${this.centerSlug}/images/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken }
                });
                const data = await res.json();
                if (data.success) {
                    this.images = this.images.filter(i => i.id !== id);
                    this.showToast('O\'chirildi');
                }
            },

            // Enhanced Image Gallery Methods
            handleImageSelect(e) {
                const files = Array.from(e.target.files);
                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        this.imageUploads.files.push(file);
                        this.imageUploads.previews.push(URL.createObjectURL(file));
                    }
                });
            },
            handleImageDrop(e) {
                const files = Array.from(e.dataTransfer.files);
                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        this.imageUploads.files.push(file);
                        this.imageUploads.previews.push(URL.createObjectURL(file));
                    }
                });
                this.$refs.dropZone.classList.remove('border-violet-500', 'bg-violet-50', 'dark:bg-violet-900/20');
            },
            removeImagePreview(index) {
                this.imageUploads.files.splice(index, 1);
                this.imageUploads.previews.splice(index, 1);
            },
            clearImageUploads() {
                this.imageUploads.files = [];
                this.imageUploads.previews = [];
            },
            async uploadImages() {
                if (this.imageUploads.files.length === 0) return;
                this.imageUploads.uploading = true;
                
                const formData = new FormData();
                this.imageUploads.files.forEach((file, index) => {
                    formData.append(`images[${index}]`, file);
                });
                
                try {
                    const res = await fetch(`/api/centers/${this.centerSlug}/images/multiple`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': this.csrfToken },
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        data.data.forEach(img => this.images.push(img));
                        this.showToast(`${data.count} ta rasm yuklandi`);
                        this.clearImageUploads();
                    }
                } catch (error) {
                    this.showToast('Xatolik yuz berdi', 'error');
                } finally {
                    this.imageUploads.uploading = false;
                }
            },
            
            // Lightbox Methods
            openLightboxFromIndex(index) {
                this.lightbox.currentIndex = index;
                this.lightbox.currentImage = this.images[index]?.url || '';
                this.lightbox.show = true;
                document.body.style.overflow = 'hidden';
            },
            openLightbox(index) {
                this.openLightboxFromIndex(index);
            },
            closeLightbox() {
                this.lightbox.show = false;
                document.body.style.overflow = '';
            },
            nextLightboxImage() {
                if (this.images.length > 1) {
                    this.lightbox.currentIndex = (this.lightbox.currentIndex + 1) % this.images.length;
                    this.lightbox.currentImage = this.images[this.lightbox.currentIndex]?.url || '';
                }
            },
            prevLightboxImage() {
                if (this.images.length > 1) {
                    this.lightbox.currentIndex = (this.lightbox.currentIndex - 1 + this.images.length) % this.images.length;
                    this.lightbox.currentImage = this.images[this.lightbox.currentIndex]?.url || '';
                }
            },

            // Weekday Modal
            openWeekdayModal() {
                this.resetWeekdayForm();
                this.weekdayForm.show = true;
                this.modals.weekday = true;
            },
            closeWeekdayModal() {
                this.modals.weekday = false;
                this.weekdayForm.show = false;
                this.resetWeekdayForm();
            },
            resetWeekdayForm() {
                this.weekdayForm = {
                    show: false,
                    editing: false,
                    id: null,
                    weekdays: '',
                    open_time: '',
                    close_time: ''
                };
            },
            editWeekday(day) {
                this.weekdayForm = {
                    show: true,
                    editing: true,
                    id: day.id,
                    weekdays: day.weekdays,
                    open_time: day.open_time || '',
                    close_time: day.close_time || ''
                };
                this.modals.weekday = true;
            },
            async saveWeekday() {
                const url = this.weekdayForm.editing 
                    ? `/api/centers/${this.centerSlug}/weekdays/${this.weekdayForm.id}` 
                    : `/api/centers/${this.centerSlug}/weekdays`;
                const method = this.weekdayForm.editing ? 'PUT' : 'POST';
                
                try {
                    const res = await fetch(url, {
                        method,
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': this.csrfToken 
                        },
                        body: JSON.stringify({
                            weekdays: this.weekdayForm.weekdays,
                            open_time: this.weekdayForm.open_time || null,
                            close_time: this.weekdayForm.close_time || null
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        if (this.weekdayForm.editing) {
                            const idx = this.weekdays.findIndex(w => w.id === this.weekdayForm.id);
                            if (idx !== -1) {
                                this.weekdays[idx] = data.data;
                            }
                        } else {
                            this.weekdays.push(data.data);
                            // Sort weekdays
                            const dayOrder = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];
                            this.weekdays.sort((a, b) => dayOrder.indexOf(a.weekdays) - dayOrder.indexOf(b.weekdays));
                        }
                        this.showToast(this.weekdayForm.editing ? 'Yangilandi' : 'Qo\'shildi');
                        this.resetWeekdayForm();
                        this.weekdayForm.show = false;
                    }
                } catch (error) {
                    this.showToast('Xatolik yuz berdi', 'error');
                }
            },
            async deleteWeekday(id) {
                if (!confirm('Hafta kunini o\'chirishni tasdiqlaysizmi?')) return;
                
                try {
                    const res = await fetch(`/api/centers/${this.centerSlug}/weekdays/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': this.csrfToken }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.weekdays = this.weekdays.filter(w => w.id !== id);
                        this.showToast('O\'chirildi');
                    }
                } catch (error) {
                    this.showToast('Xatolik yuz berdi', 'error');
                }
            },

            init() {
                // Keyboard navigation for lightbox
                document.addEventListener('keydown', (e) => {
                    if (!this.lightbox.show) return;
                    
                    if (e.key === 'Escape') {
                        this.closeLightbox();
                    } else if (e.key === 'ArrowRight') {
                        this.nextLightboxImage();
                    } else if (e.key === 'ArrowLeft') {
                        this.prevLightboxImage();
                    }
                });
            }
        }
    }
</script>
@endsection
