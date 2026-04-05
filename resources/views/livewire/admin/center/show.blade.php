<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.centers') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $center->name }}</h2>
                <p class="text-sm text-gray-500">{{ $center->address }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.centers.edit', $center->id) }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Tahrirlash
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Status</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Tasdiqlangan:</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $center->checked ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $center->checked ? 'Ha' : 'Yo\'q' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Premium:</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $center->premium ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $center->premium ? 'Ha' : 'Yo\'q' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Contact Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Aloqa</h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span class="text-sm text-gray-900">{{ $center->phone }}</span>
                </div>
                @if($center->email)
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm text-gray-900">{{ $center->email }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Owner Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Egasi</h3>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                    <span class="text-indigo-600 font-medium">{{ substr($center->user?->name, 0, 1) }}</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $center->user?->name }}</p>
                    <p class="text-sm text-gray-500">{{ $center->user?->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tavsif</h3>
        <p class="text-gray-700 whitespace-pre-wrap">{{ $center->description }}</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-sm text-gray-500">O'qituvchilar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $center->teachers_count ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Fanlar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $center->subjects_count ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Izohlar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $center->comments_count ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Rasmlar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $center->images_count ?? 0 }}</p>
        </div>
    </div>

    <!-- Timestamps -->
    <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-500">
        <p>Yaratilgan: {{ $center->created_at->format('d.m.Y H:i') }}</p>
        <p>Yangilangan: {{ $center->updated_at->format('d.m.Y H:i') }}</p>
    </div>
</div>
