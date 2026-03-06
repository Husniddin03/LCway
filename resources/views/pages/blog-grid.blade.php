<x-layout>
    <x-slot:title>Barcha o'quv markazlar</x-slot:title>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">O'quv markazlar</h1>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">
                    O'zbekiston bo'ylab eng yaxshi o'quv markazlarini toping va o'zingizga mos kurslarni tanlang
                </p>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Search Bar -->
            <div class="mb-6">
                <form action="{{ route('blog-grid') }}" method="get" class="relative">
                    @foreach ($validated as $item)
                        <input type="hidden" name="{{ $item }}" value="{{ $item ?? '' }}" />
                    @endforeach
                    <div class="relative max-w-2xl mx-auto">
                        <input 
                            type="text" 
                            name="searchText" 
                            placeholder="O'quv markazini qidiring..."
                            value="{{ $validated['searchText'] ?? '' }}"
                            class="w-full px-6 py-4 pr-12 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Filter Navigation -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('blog-grid') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        Barchasi
                    </a>
                    <button id="toggle-map" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                        Xarita
                    </button>
                    
                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{ sortDropdown: false }">
                        <button @click="sortDropdown = !sortDropdown" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200 flex items-center gap-2">
                            Saralash
                            <svg class="w-4 h-4" :class="{ 'rotate-180': sortDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="sortDropdown" @click.away="sortDropdown = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10">
                            <div class="py-2">
                                @if (!isset($validated['name']))
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Nomi ↑↓
                                    </a>
                                @elseif ($validated['name'] == 'asc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'desc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Nomi ↑
                                    </a>
                                @elseif ($validated['name'] == 'desc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Nomi ↓
                                    </a>
                                @else
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'name' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Nomi ↑↓
                                    </a>
                                @endif
                                
                                @if (!isset($validated['distance']))
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Masofasi ↑↓
                                    </a>
                                @elseif ($validated['distance'] == 'asc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'desc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Masofasi ↑
                                    </a>
                                @elseif ($validated['distance'] == 'desc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Masofasi ↓
                                    </a>
                                @else
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'distance', 'distance' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Masofasi ↑↓
                                    </a>
                                @endif
                                
                                @if (!isset($validated['favorites']))
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Reytingi ↑↓
                                    </a>
                                @elseif ($validated['favorites'] == 'asc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'desc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Reytingi ↑
                                    </a>
                                @elseif ($validated['favorites'] == 'desc')
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Reytingi ↓
                                    </a>
                                @else
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'favorites', 'favorites' => 'asc']) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Reytingi ↑↓
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Teacher Announcements Dropdown -->
                    <div class="relative" x-data="{ teacherDropdown: false }">
                        <button @click="teacherDropdown = !teacherDropdown" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200 flex items-center gap-2">
                            O'qituvchi e'lonlari
                            <svg class="w-4 h-4" :class="{ 'rotate-180': teacherDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="teacherDropdown" @click.away="teacherDropdown = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10">
                            <div class="py-2">
                                @foreach ($subjects as $subject)
                                    <a href="{{ request()->fullUrlWithQuery(['needTeachers' => $subject->id]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        {{ $subject->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-gray-600 dark:text-gray-400">
                    {{ $LearningCenters->count() }} ta o'quv markaz topildi
                </div>
            </div>
        </div>
    </section>

    <!-- Map Container -->
    <div id="map-container" class="hidden bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="relative">
                    <div id="map" class="h-96"></div>
                    
                    <!-- Map Search Box -->
                    <div class="absolute top-4 left-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-3 w-80">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="O'quv markazini qidiring..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        <div id="searchResults" class="mt-2 max-h-48 overflow-y-auto hidden"></div>
                    </div>
                    
                    <!-- Map Form -->
                    <div class="absolute top-4 right-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 w-80">
                        <form action="{{ route('blog-grid') }}" method="get" class="space-y-3">
                            <input type="text" id="address" name="address" placeholder="Manzil" readonly class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <input type="hidden" id="location" name="location">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            
                            <select name="subject_id" id="subject" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                                <option value="">Fanni tanlang...</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ isset($validated['subject_id']) && $subject->id == $validated['subject_id'] ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <input type="number" name="radius" id="radius" placeholder="Radius (km)" min="1" max="10000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg">
                            <input type="number" name="maxPrice" id="maxPrice" placeholder="Maksimal narx (so'm)" min="0" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg">
                            
                            <button type="submit" class="w-full bg-primary-600 text-white py-2 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                Qidirish
                            </button>
                        </form>
                        
                        <button id="locateBtn" class="absolute bottom-4 right-4 bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg hover:shadow-xl transition-shadow duration-200" title="Joyimni top">
                            📍
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Centers Grid -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($LearningCenters as $LearningCenter)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="{{ asset('storage/' . $LearningCenter->logo) }}" 
                                alt="{{ $LearningCenter->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <a href="{{ route('blog-single', $LearningCenter->id) }}" class="absolute bottom-4 left-4 bg-white dark:bg-gray-800 text-primary-600 dark:text-primary-400 px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                Ko'proq o'qish
                            </a>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta Information -->
                            <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $LearningCenter->region . ', ' . $LearningCenter->province }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $LearningCenter->created_at->diffForHumans() }}</span>
                                </div>
                                @if (isset($LearningCenter->distance))
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <span>{{ $LearningCenter->distance }} km</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Rating -->
                            @php
                                $average = round($LearningCenter->favorites()->avg('rating') ?? 0, 1);
                            @endphp
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $average - $i;
                                        @endphp
                                        <span class="text-lg {{ $average >= $i ? 'text-yellow-400' : ($diff > -1 && $diff < 0 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600') }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>
                                <span class="text-lg font-semibold text-primary-600 dark:text-primary-400">{{ $average }}</span>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                <a href="{{ route('blog-single', $LearningCenter->id) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                                    {{ $LearningCenter->name }}
                                </a>
                            </h3>
                            
                            <!-- Teacher Announcements -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">E'lon</h4>
                                </div>
                                
                                @if ($LearningCenter->needTeachers->count() > 0)
                                    <div class="space-y-2">
                                        <p class="text-sm font-medium text-success-600 dark:text-success-400">O'qituvchi kerak</p>
                                        @foreach ($LearningCenter->needTeachers as $teacher)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-700 dark:text-gray-300">🟢 {{ $teacher->subject->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $teacher->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hozicha e'lon berilmagan!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>

<style>
    /* Rating Stars */
    .star {
        transition: color 0.2s ease;
    }
    
    /* Map Container */
    #map-container.hidden {
        display: none;
    }
    
    #map-container.show {
        display: block;
    }
    
    /* Search Results */
    .search-result-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s;
    }
    
    .search-result-item:hover {
        background-color: #f3f4f6;
    }
    
    .dark .search-result-item {
        border-bottom-color: #374151;
    }
    
    .dark .search-result-item:hover {
        background-color: #374151;
    }
</style>

<script>
    // Toggle Map
    document.getElementById('toggle-map').addEventListener('click', function() {
        const mapContainer = document.getElementById('map-container');
        mapContainer.classList.toggle('hidden');
        mapContainer.classList.toggle('show');
        
        if (mapContainer.classList.contains('show')) {
            setTimeout(() => {
                if (window.google && window.google.maps) {
                    google.maps.event.trigger(map, 'resize');
                }
            }, 300);
        }
    });
    
    // Learning Centers Data
    const learningCentersData = {!! json_encode(
        $LearningCenters->map(function ($center) {
            $location = explode(',', $center->location);
            return [
                'id' => $center->id,
                'name' => $center->name,
                'latitude' => (float) ($location[0] ?? 0),
                'longitude' => (float) ($location[1] ?? 0),
                'address' => $center->address ?? '',
                'logo' => $center->logo ?? '',
                'distance' => 0,
            ];
        }),
    ) !!};
    
    let map, geocoder, userMarker;
    const markers = [];
    const defaultLat = 41.2995;
    const defaultLng = 69.2401;
    
    // Initialize Map (if Google Maps API is loaded)
    function initMap() {
        if (!window.google || !window.google.maps) return;
        
        const defaultCenter = { lat: defaultLat, lng: defaultLng };
        
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
            gestureHandling: 'greedy',
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });
        
        geocoder = new google.maps.Geocoder();
        
        // User marker
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            title: "Sizning joylashuvingiz",
            optimized: true
        });
        
        // Add learning centers
        addLearningCenters();
        
        // Setup events
        setupEventListeners();
        
        // Get user location
        getUserLocation();
    }
    
    // Add learning centers to map
    function addLearningCenters() {
        learningCentersData.forEach(center => {
            if (!center.latitude || !center.longitude) return;
            
            const position = {
                lat: parseFloat(center.latitude),
                lng: parseFloat(center.longitude)
            };
            
            const marker = new google.maps.Marker({
                map: map,
                position: position,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(32, 32)
                },
                title: center.name,
                optimized: true
            });
            
            const infoWindow = new google.maps.InfoWindow({
                content: createInfoContent(center)
            });
            
            marker.addListener("click", () => {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
                updateDistance(center, userMarker.getPosition());
            });
            
            markers.push({ marker, infoWindow, center });
        });
    }
    
    // Create info window content
    function createInfoContent(center) {
        return `
            <div class="p-3">
                <h3 class="font-semibold text-lg mb-2">${center.name}</h3>
                <p class="text-sm text-gray-600 mb-1">📍 Masofa: <span id="dist-${center.id}">Hisoblanmoqda...</span></p>
                <p class="text-sm text-gray-600 mb-3">${center.address || 'Manzil ko\'rsatilmagan'}</p>
                <div class="flex gap-2">
                    <a href="/blog-single/${center.id}" class="bg-primary-600 text-white px-3 py-1 rounded text-sm hover:bg-primary-700">Batafsil</a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${center.latitude},${center.longitude}" 
                       class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700" target="_blank">Yo'nalish</a>
                </div>
            </div>
        `;
    }
    
    // Close all info windows
    function closeAllInfoWindows() {
        markers.forEach(m => m.infoWindow.close());
    }
    
    // Setup event listeners
    function setupEventListeners() {
        // Map click
        map.addListener("click", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            userMarker.setPosition(pos);
            updateLocation(pos.lat, pos.lng);
        });
        
        // Marker drag
        userMarker.addListener("dragend", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            updateLocation(pos.lat, pos.lng);
        });
    }
    
    // Get user location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    userMarker.setPosition(pos);
                    map.setCenter(pos);
                    updateLocation(pos.lat, pos.lng);
                },
                () => {
                    console.log("Location access denied");
                }
            );
        }
    }
    
    // Update location
    function updateLocation(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('location').value = `${lat},${lng}`;
        
        // Update address
        if (geocoder) {
            geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    document.getElementById('address').value = results[0].formatted_address;
                }
            });
        }
    }
    
    // Update distance
    function updateDistance(center, userPos) {
        if (!userPos) return;
        
        const distance = google.maps.geometry.spherical.computeDistanceBetween(
            new google.maps.LatLng(center.latitude, center.longitude),
            userPos
        ) / 1000; // Convert to km
        
        const distanceElement = document.getElementById(`dist-${center.id}`);
        if (distanceElement) {
            distanceElement.textContent = `${distance.toFixed(1)} km`;
        }
    }
    
    // Locate button
    document.getElementById('locateBtn').addEventListener('click', function() {
        getUserLocation();
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        
        const results = learningCentersData.filter(center => 
            center.name.toLowerCase().includes(query.toLowerCase())
        );
        
        if (results.length > 0) {
            searchResults.innerHTML = results.map(center => `
                <div class="search-result-item" onclick="selectCenter(${center.id})">
                    <div class="font-medium">${center.name}</div>
                    <div class="text-sm text-gray-600">${center.address || 'Manzil ko\'rsatilmagan'}</div>
                </div>
            `).join('');
            searchResults.classList.remove('hidden');
        } else {
            searchResults.innerHTML = '<div class="search-result-item text-gray-500">Hech narsa topilmadi</div>';
            searchResults.classList.remove('hidden');
        }
    });
    
    // Select center from search
    function selectCenter(centerId) {
        const center = learningCentersData.find(c => c.id === centerId);
        if (center && map) {
            map.setCenter({ lat: center.latitude, lng: center.longitude });
            map.setZoom(15);
            
            // Find and open the marker
            const markerData = markers.find(m => m.center.id === centerId);
            if (markerData) {
                closeAllInfoWindows();
                markerData.infoWindow.open(map, markerData.marker);
            }
            
            searchResults.classList.add('hidden');
            searchInput.value = center.name;
        }
    }
    
    // Initialize map when page loads
    if (typeof google !== 'undefined' && google.maps) {
        initMap();
    } else {
        // Wait for Google Maps to load
        window.addEventListener('load', initMap);
    }
</script>

<style>
    /* Base styles remain the same */
    .favorite {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
    }

    .favorite .stars {
        display: flex;
        justify-content: center;
        gap: 5px;
        font-size: 40px;
        cursor: pointer;
        position: relative;
    }

    .favorite .star {
        color: #ddd;
        transition: color 0.2s ease;
        user-select: none;
        position: relative;
    }

    .favorite .star.full {
        color: #ffc107;
    }

    .favorite .star.half {
        background: linear-gradient(90deg, #ffc107 50%, #ddd 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .favorite .result {
        font-size: 18px;
        color: #667eea;
        font-weight: bold;
        min-height: 30px;
    }

    .standard-img {
        aspect-ratio: 4 / 3;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    /* Navigation Links - Responsive */
    .nav-links {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        list-style: none;
        padding: 0;
        flex-wrap: wrap;
        align-items: center;
    }

    .nav-links-li:hover {
        color: blue;
    }

    /* Map Container - Responsive */
    #map-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
        position: relative;
    }

    #map-container.active {
        max-height: 700px;
        margin-top: 10px;
    }

    #map {
        width: 100%;
        height: 400px;
        border-radius: 10px;
    }

    /* Map Form - Desktop */
    .map-form {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 320px;
        z-index: 1000;
        max-height: 90vh;
        overflow-y: auto;
    }

    .map-form input,
    .map-form select,
    .map-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .map-form button {
        background-color: #4285f4;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .map-form button:hover {
        background-color: #3367d6;
    }

    /* Search Box - Responsive */
    .search-box {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 300px;
        z-index: 1000;
        max-width: calc(100vw - 360px);
    }

    .search-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .search-results {
        max-height: 250px;
        overflow-y: auto;
        margin-top: 8px;
        display: none;
        background: white;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .result-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .result-item:hover {
        background: #f5f5f5;
    }

    /* Locate Button */
    .locate-btn {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: white;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        z-index: 1000;
    }

    .locate-btn:hover {
        background: #f5f5f5;
    }

    /* Toggle Button */
    .toggle-btn {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 1001;
        font-weight: 500;
        border: none;
        font-size: 14px;
    }

    /* Learning Centers Grid - Responsive */
    .learning-centers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .learning-center-card {
        width: 100%;
        max-width: none;
    }

    /* Card Meta - Responsive */
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Announcement Header */
    .announcement-header {
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
    }

    /* Dropdown Menus - Responsive */
    .dropdown-container {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        z-index: 1000;
    }

    /* Info Window Content */
    .info-content {
        padding: 10px;
        max-width: 250px;
    }

    .info-content img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .info-title {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: bold;
    }

    .info-distance {
        margin: 0 0 5px 0;
        font-size: 13px;
        color: #1976d2;
        font-weight: 500;
    }

    .info-address {
        margin: 0 0 10px 0;
        font-size: 12px;
        color: #666;
    }

    .info-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #4285f4;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 5px;
    }

    .info-btn:hover {
        background-color: #3367d6;
    }

    /* Scrollbar styling */
    .search-results::-webkit-scrollbar,
    .map-form::-webkit-scrollbar {
        width: 6px;
    }

    .search-results::-webkit-scrollbar-thumb,
    .map-form::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {

        /* Navigation */
        .nav-links {
            overflow-x: auto;
            white-space: nowrap;
            gap: 15px;
            padding-bottom: 10px;
        }

        .nav-links li {
            flex-shrink: 0;
        }

        /* Map Container Mobile */
        #map-container.active {
            max-height: 80vh;
        }

        #map {
            height: 300px;
        }

        /* Map Form Mobile */
        .map-form {
            position: relative;
            top: 0;
            right: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin: 10px 0;
            box-sizing: border-box;
        }

        /* Search Box Mobile */
        .search-box {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            max-width: none;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        /* Toggle Button Mobile */
        .toggle-btn {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            margin-bottom: 10px;
        }

        /* Locate Button Mobile */
        .locate-btn {
            right: 15px;
            bottom: 15px;
            width: 50px;
            height: 50px;
            font-size: 22px;
        }

        /* Learning Centers Grid Mobile */
        .learning-centers-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        /* Card Meta Mobile */
        .card-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .meta-item {
            width: 100%;
            justify-content: flex-start;
        }

        .meta-item p {
            font-size: 14px;
        }

        /* Stars Mobile */
        .favorite {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .favorite .stars {
            font-size: 32px;
            gap: 3px;
        }

        .favorite .result {
            font-size: 20px;
        }

        /* Dropdown Mobile */
        .dropdown-menu {
            position: fixed;
            top: auto;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            max-height: 50vh;
            overflow-y: auto;
            border-radius: 8px 8px 0 0;
        }

        /* Announcement Header Mobile */
        .announcement-header {
            flex-direction: row;
            align-items: center;
        }

        .announcement-header img {
            width: 1.5rem !important;
            height: 1.5rem !important;
            margin-right: 1rem !important;
        }
    }

    /* TABLET RESPONSIVE STYLES */
    @media (max-width: 1024px) and (min-width: 769px) {

        /* Learning Centers Grid Tablet */
        .learning-centers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        /* Map Form Tablet */
        .map-form {
            width: 280px;
        }

        /* Search Box Tablet */
        .search-box {
            width: 250px;
            max-width: calc(100vw - 320px);
        }

        /* Navigation Tablet */
        .nav-links {
            gap: 18px;
        }
    }

    /* LARGE DESKTOP STYLES */
    @media (min-width: 1200px) {
        .learning-centers-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .map-form {
            width: 350px;
        }

        .search-box {
            width: 320px;
        }
    }

    /* EXTRA LARGE DESKTOP STYLES */
    @media (min-width: 1400px) {
        .learning-centers-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* SMALL MOBILE STYLES */
    @media (max-width: 480px) {
        .nav-links {
            gap: 10px;
            font-size: 14px;
        }

        .favorite .stars {
            font-size: 28px;
        }

        .favorite .result {
            font-size: 18px;
        }

        .meta-item p {
            font-size: 13px;
        }

        #map {
            height: 250px;
        }

        .map-form {
            padding: 10px;
        }

        .search-box {
            padding: 8px;
        }
    }
</style>

<script>
    // Demo data - Laravel blade'dan keladi
    // Backend'da:
    const learningCentersData = {!! json_encode(
        $LearningCenters->map(function ($center) {
            $location = explode(',', $center->location);
            return [
                'id' => $center->id,
                'name' => $center->name,
                'latitude' => (float) ($location[0] ?? 0),
                'longitude' => (float) ($location[1] ?? 0),
                'address' => $center->address ?? '',
                'logo' => $center->logo ?? '',
                'distance' => 0,
            ];
        }),
    ) !!};

    let map, geocoder, userMarker;
    const markers = [];
    const defaultLat = 41.2995;
    const defaultLng = 69.2401;

    // Toggle map visibility
    document.getElementById('toggle-map').addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('map-container');
        container.classList.toggle('active');

        // Trigger map resize after container is visible
        if (container.classList.contains('active')) {
            setTimeout(() => {
                if (map) {
                    google.maps.event.trigger(map, 'resize');
                }
            }, 500);
        }
    });

    // Initialize map
    function initMap() {
        const defaultCenter = {
            lat: defaultLat,
            lng: defaultLng
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
            gestureHandling: 'greedy',
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });

        geocoder = new google.maps.Geocoder();

        // User marker
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            title: "Sizning joylashuvingiz",
            optimized: true
        });

        // Add learning centers
        addLearningCenters();

        // Setup events
        setupEventListeners();

        // Get user location
        getUserLocation();
    }

    // Add learning centers to map
    function addLearningCenters() {
        learningCentersData.forEach(center => {
            if (!center.latitude || !center.longitude) return;

            const position = {
                lat: parseFloat(center.latitude),
                lng: parseFloat(center.longitude)
            };

            const marker = new google.maps.Marker({
                map: map,
                position: position,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(32, 32)
                },
                title: center.name,
                optimized: true
            });

            const infoWindow = new google.maps.InfoWindow({
                content: createInfoContent(center)
            });

            marker.addListener("click", () => {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
                updateDistance(center, userMarker.getPosition());
            });

            markers.push({
                marker,
                infoWindow,
                center
            });
        });
    }

    // Create info window content
    function createInfoContent(center) {
        return `
            <div class="info-content">
                <h3 class="info-title">${center.name}</h3>
                <p class="info-distance">📍 Masofa: <span id="dist-${center.id}">Hisoblanmoqda...</span></p>
                <p class="info-address">${center.address || 'Manzil ko\'rsatilmagan'}</p>
                <a href="/blog-single/${center.id}" class="info-btn">Batafsil</a>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${center.latitude},${center.longitude}" 
                   class="info-btn" target="_blank">Yo'nalish</a>
            </div>
        `;
    }

    // Close all info windows
    function closeAllInfoWindows() {
        markers.forEach(m => m.infoWindow.close());
    }

    // Setup event listeners
    function setupEventListeners() {
        // Map click
        map.addListener("click", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            userMarker.setPosition(pos);
            updateLocation(pos.lat, pos.lng);
        });

        // Marker drag
        userMarker.addListener("dragend", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            updateLocation(pos.lat, pos.lng);
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase().trim();

            searchTimeout = setTimeout(() => {
                searchResults.innerHTML = '';

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                const filtered = learningCentersData.filter(center =>
                    center.name.toLowerCase().includes(query) ||
                    center.address.toLowerCase().includes(query)
                );

                if (filtered.length === 0) {
                    searchResults.innerHTML = '<div class="result-item">Natija topilmadi</div>';
                    searchResults.style.display = 'block';
                    return;
                }

                searchResults.style.display = 'block';

                const fragment = document.createDocumentFragment();
                filtered.forEach(center => {
                    const div = document.createElement('div');
                    div.className = 'result-item';
                    div.innerHTML =
                        `<strong>${center.name}</strong><br><small>${center.address || 'Manzil ko\'rsatilmagan'}</small>`;
                    div.addEventListener('click', () => selectCenter(center));
                    fragment.appendChild(div);
                });
                searchResults.appendChild(fragment);
            }, 300);
        });

        // Close search on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box')) {
                searchResults.style.display = 'none';
            }
        });

        // Locate button
        document.getElementById('locateBtn').addEventListener('click', getUserLocation);

        // Handle window resize for map
        window.addEventListener('resize', () => {
            if (map && document.getElementById('map-container').classList.contains('active')) {
                setTimeout(() => {
                    google.maps.event.trigger(map, 'resize');
                }, 100);
            }
        });
    }

    // Select center from search
    function selectCenter(center) {
        map.setCenter({
            lat: center.latitude,
            lng: center.longitude
        });
        map.setZoom(16);

        const targetMarker = markers.find(m => m.center.id === center.id);
        if (targetMarker) {
            closeAllInfoWindows();
            targetMarker.infoWindow.open(map, targetMarker.marker);
        }

        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('searchInput').value = '';
    }

    // Get user location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                    userMarker.setPosition(pos);
                    updateLocation(pos.lat, pos.lng);
                },
                () => {
                    updateLocation(defaultLat, defaultLng);
                }
            );
        } else {
            updateLocation(defaultLat, defaultLng);
        }
    }

    // Update location
    function updateLocation(lat, lng) {
        const url = `https://www.google.com/maps?q=${lat},${lng}`;

        // Update form fields
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        document.getElementById("location").value = url;

        // Geocode address
        geocoder.geocode({
            location: {
                lat,
                lng
            }
        }, (results, status) => {
            if (status === "OK" && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("address").value = address;
            }
        });

        // Calculate distances
        calculateAllDistances({
            lat,
            lng
        });
    }

    // Calculate all distances
    function calculateAllDistances(userPos) {
        markers.forEach(m => {
            updateDistance(m.center, userPos);
        });
    }

    // Update distance for one center
    function updateDistance(center, userPos) {
        const dist = getDistance(userPos.lat, userPos.lng, center.latitude, center.longitude);
        const elem = document.getElementById(`dist-${center.id}`);
        if (elem) {
            elem.textContent = `${dist.toFixed(2)} km`;
        }
        center.distance = dist;
    }

    // Calculate distance (Haversine formula)
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    window.initMap = initMap;
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap">
</script>
