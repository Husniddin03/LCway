<div class="space-y-6">
    <!-- Page Title -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
        <button wire:click="mount" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Yangilash
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach($stats as $key => $stat)
        <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-12 h-12 bg-{{ $stat['color'] }}-100 rounded-lg flex items-center justify-center">
                    @if($stat['icon'] === 'users')
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    @elseif($stat['icon'] === 'building')
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    @elseif($stat['icon'] === 'academic-cap')
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    @elseif($stat['icon'] === 'book-open')
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    @elseif($stat['icon'] === 'chat')
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    @endif
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">{{ ucfirst($key) }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stat['total'] }}</p>
                </div>
            </div>
            @if(isset($stat['active']))
            <div class="mt-3 flex items-center text-sm">
                <span class="text-green-600 font-medium">{{ $stat['active'] }} active</span>
            </div>
            @endif
            @if(isset($stat['pending']) && $stat['pending'] > 0)
            <div class="mt-3 flex items-center text-sm">
                <span class="text-orange-600 font-medium">{{ $stat['pending'] }} kutilmoqda</span>
            </div>
            @endif
            @if(isset($stat['new_today']))
            <div class="mt-3 flex items-center text-sm">
                <span class="text-blue-600 font-medium">+{{ $stat['new_today'] }} bugun</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">So'ngi aktivliklar</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentActivities as $activity)
            <div class="px-6 py-4 flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                    <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                </div>
                <span class="text-sm text-gray-400">{{ $activity['time'] }}</span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500">
                Hozircha aktivlik yo'q
            </div>
            @endforelse
        </div>
    </div>
</div>
