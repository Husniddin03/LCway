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

    <!-- Contribution Graph -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Yillik aktivlik</h3>
                @php
                    $totalContributions = 0;
                    foreach ($contributionData as $day) {
                        if ($day['date']) {
                            $totalContributions += $day['count'];
                        }
                    }
                @endphp
                <p class="text-sm text-gray-500 mt-1">{{ $totalContributions }} ta aktivlik {{ $selectedYear }} yilda</p>
            </div>
            
            <!-- Year Selector -->
            <div>
                <select wire:model.live="selectedYear" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                    @for($year = now()->year; $year >= now()->year - 5; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        @php
            // Build proper calendar grid
            $yearStart = \Carbon\Carbon::create($selectedYear, 1, 1);
            $yearEnd = \Carbon\Carbon::create($selectedYear, 12, 31);
            
            // Get day of week for Jan 1 (0=Sun, 1=Mon, ..., 6=Sat)
            // We want Monday as first day, so 0=Mon, ..., 6=Sun
            $jan1DayOfWeek = $yearStart->dayOfWeek;
            $mondayBased = ($jan1DayOfWeek === 0) ? 6 : $jan1DayOfWeek - 1;
            
            // Build data lookup by date string
            $dataByDate = [];
            foreach ($contributionData as $day) {
                if ($day['date']) {
                    $dataByDate[$day['date']] = $day['count'];
                }
            }
            
            // Calculate max for color scale
            $values = array_values($dataByDate);
            $maxCount = !empty($values) ? max($values) : 0;
            if ($maxCount === 0) $maxCount = 1;
            
            // Build grid: 7 rows (days) x N columns (weeks)
            // Each cell is [date, count, dayIndex, weekIndex]
            $grid = [];
            $currentDate = $yearStart->copy();
            $weekIndex = 0;
            $dayIndex = $mondayBased;
            
            // Create full year grid
            while ($currentDate <= $yearEnd) {
                $dateStr = $currentDate->format('Y-m-d');
                $count = $dataByDate[$dateStr] ?? 0;
                
                if (!isset($grid[$dayIndex])) {
                    $grid[$dayIndex] = [];
                }
                $grid[$dayIndex][$weekIndex] = [
                    'date' => $dateStr,
                    'count' => $count,
                ];
                
                $dayIndex++;
                if ($dayIndex > 6) {
                    $dayIndex = 0;
                    $weekIndex++;
                }
                $currentDate->addDay();
            }
            
            $totalWeeks = $weekIndex + ($dayIndex > 0 ? 1 : 0);
            
            // Calculate month positions based on first day of each month
            $monthPositions = [];
            for ($month = 1; $month <= 12; $month++) {
                $firstDayOfMonth = \Carbon\Carbon::create($selectedYear, $month, 1);
                
                // Calculate week index for this date
                $dayOfYear = $firstDayOfMonth->dayOfYear;
                $dayOfWeek = $firstDayOfMonth->dayOfWeek;
                $mondayBasedDay = ($dayOfWeek === 0) ? 6 : $dayOfWeek - 1;
                
                // Week index = (days since start + offset) / 7
                $weekIdx = floor(($dayOfYear - 1 + $mondayBased) / 7);
                
                $monthName = $firstDayOfMonth->format('M');
                $monthPositions[] = [
                    'name' => $monthName,
                    'weekIndex' => $weekIdx,
                ];
            }
        @endphp
        
        <div class="relative">
            <!-- Month Labels - positioned absolutely above grid -->
            <div class="grid mb-2 pl-5 ml-[42px]" style="grid-template-columns: repeat({{ $totalWeeks }}, 1fr);">
                @foreach($monthPositions as $month)
                    <div class="text-xs text-gray-600 font-medium" style="grid-column: {{ $month['weekIndex'] + 1 }};" >
                        {{ $month['name'] }}
                    </div>
                @endforeach
            </div>
            
            <div class="flex">
                <!-- Day Labels -->
                <div class="flex flex-col mr-3 text-xs text-gray-500 gap-y-2" style="min-width: 50px;">
                    <div class="h-[16px] mb-[4px] flex items-center">Mon</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Tue</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Wed</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Thu</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Fri</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Sat</div>
                    <div class="h-[16px] mb-[4px] flex items-center">Sun</div>
                </div>
                
                <!-- Contribution Grid - Full Width -->
                <div class="flex-1">
                    <div class="grid gap-[4px] w-full"
                        style="grid-template-columns: repeat({{ $totalWeeks }}, minmax(12px, 1fr));">   
                         @for($w = 0; $w < $totalWeeks; $w++)
                            <div class="flex flex-col gap-[3px]">
                                @for($d = 0; $d < 7; $d++)
                                    @php
                                        $cell = $grid[$d][$w] ?? null;
                                        if ($cell) {
                                            $count = $cell['count'];
                                            
                                            // GitHub-like color scale
                                            if ($count === 0) {
                                                $bgColor = '#ebedf0';
                                                $tooltip = 'No activities';
                                            } elseif ($count <= ceil($maxCount * 0.25)) {
                                                $bgColor = '#9be9a8';
                                                $tooltip = $count . ' activities';
                                            } elseif ($count <= ceil($maxCount * 0.5)) {
                                                $bgColor = '#40c463';
                                                $tooltip = $count . ' activities';
                                            } elseif ($count <= ceil($maxCount * 0.75)) {
                                                $bgColor = '#30a14e';
                                                $tooltip = $count . ' activities';
                                            } else {
                                                $bgColor = '#216e39';
                                                $tooltip = $count . ' activities';
                                            }
                                            $formattedDate = \Carbon\Carbon::parse($cell['date'])->format('F j, Y');
                                        } else {
                                            $bgColor = 'transparent';
                                        }
                                    @endphp
                                    @if($cell)
                                        <div 
                                            class="aspect-square rounded-[3px] hover:ring-2 hover:ring-gray-400 transition-all cursor-pointer"
                                            style="background-color: {{ $bgColor }}; min-height: 14px;"
                                            title="{{ $tooltip }} on {{ $formattedDate }}"
                                        ></div>
                                    @else
                                        <div class="aspect-square rounded-[3px]" style="background-color: transparent; min-height: 14px;"></div>
                                    @endif
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            <!-- Legend -->
            <div class="flex items-center justify-end mt-4 text-xs text-gray-500">
                <span class="mr-2">Less</span>
                <div class="flex gap-[3px]">
                    <div class="w-[14px] h-[14px] rounded-[3px]" style="background-color: #ebedf0;" title="No activities"></div>
                    <div class="w-[14px] h-[14px] rounded-[3px]" style="background-color: #9be9a8;" title="Low"></div>
                    <div class="w-[14px] h-[14px] rounded-[3px]" style="background-color: #40c463;" title="Medium"></div>
                    <div class="w-[14px] h-[14px] rounded-[3px]" style="background-color: #30a14e;" title="High"></div>
                    <div class="w-[14px] h-[14px] rounded-[3px]" style="background-color: #216e39;" title="Very High"></div>
                </div>
                <span class="ml-2">More</span>
            </div>
        </div>
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
