<div class="space-y-6" wire:ignore x-data="adminMap()" x-init="boot()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Markazlar xaritada</h1>
        <div class="text-sm text-gray-500">
            Jami: <span class="font-medium text-gray-900" x-text="centerCount"></span> ta markaz
        </div>
    </div>

    <!-- Map Filter Component -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Map Toolbar -->
        <div class="flex flex-wrap items-center gap-3 p-4 border-b border-gray-200 bg-gray-50">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <input x-model="searchInput" type="text" placeholder="Markaz nomini qidirish..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                    @input.debounce.500ms="onSearchChange($event.target.value)">
            </div>

            <!-- Province Filter -->
            <div class="w-40">
                <select x-model="provinceInput" @change="onProvinceChange($event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                    <option value="">Barcha viloyatlar</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov }}">{{ $prov }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Radius Filter -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Radius:</span>
                <select x-model.number="radius" @change="onRadiusChange()"
                    class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="5">5 km</option>
                    <option value="10">10 km</option>
                    <option value="25">25 km</option>
                    <option value="50">50 km</option>
                    <option value="100">100 km</option>
                </select>
            </div>

            <!-- Location Search -->
            <div class="flex-1 min-w-[200px] max-w-xs">
                <div class="relative">
                    <input x-model="locationSearch" type="text" placeholder="Joylashuv qidirish (shahar, tuman)..."
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                        @keydown.enter="searchLocation()">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button x-show="locationSearch" @click="searchLocation()"
                        class="absolute right-2 top-1.5 px-2 py-1 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">
                        Qidirish
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="button" @click="locateMe()"
                    class="flex items-center gap-2 px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm"
                    :disabled="locating"
                    title="GPS orqali joylashuvni aniqlash">
                    <svg class="w-4 h-4" :class="locating ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M12 2v3m0 14v3M2 12h3m14 0h3" />
                    </svg>
                    <span x-text="locating ? 'Aniqlanmoqda...' : 'GPS'"></span>
                </button>

                <button type="button" @click="toggleClickToSet()"
                    class="px-3 py-2 border rounded-lg text-sm transition-colors"
                    :class="clickToSet ? 'bg-blue-100 border-blue-500 text-blue-700' : 'border-gray-300 text-gray-700 hover:bg-gray-100'"
                    title="Xaritada bosib joylashuvni belgilash">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>

                <button type="button" @click="toggleBoundsFiltering()"
                    class="px-3 py-2 border rounded-lg text-sm transition-colors"
                    :class="boundsFiltering ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300 text-gray-700 hover:bg-gray-100'"
                    title="Xarita ko'rsatayotgan hududni filtrlash">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </button>

                <button type="button" @click="resetFilter()"
                    class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-sm">
                    Tozalash
                </button>

                <button type="button" @click="toggleFullscreen()"
                    class="p-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100"
                    title="To'liq ekran">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Map Area -->
        <div class="relative" :class="isFullscreen ? 'fixed inset-0 z-50' : 'h-[calc(100vh-280px)]'" id="mapContainer">
            <div id="map" class="w-full h-full" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;"></div>

            <!-- Loading Placeholder -->
            <div x-show="!mapReady" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                <div class="text-center">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="text-gray-500">Xarita yuklanmoqda...</span>
                </div>
            </div>

            <!-- Markers Loading Indicator -->
            <div x-show="mapReady && loadingMarkers" class="absolute top-4 left-1/2 transform -translate-x-1/2 z-20">
                <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Markazlar yuklanmoqda...</span>
                </div>
            </div>

            <!-- Close Fullscreen Button -->
            <button x-show="isFullscreen" @click="toggleFullscreen()"
                class="absolute top-4 right-4 z-20 p-2 bg-white rounded-lg shadow-md hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Info Panel -->
            <div x-show="selectedCenter" x-transition class="absolute bottom-4 left-4 right-4 sm:left-auto sm:right-4 sm:w-80 bg-white rounded-lg shadow-lg p-4 z-10 max-h-64 overflow-y-auto">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-gray-900" x-text="selectedCenter?.name"></h3>
                    <button @click="selectedCenter = null" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-1" x-text="selectedCenter?.address"></p>
                <p class="text-sm text-gray-500 mb-2">
                    <span x-text="selectedCenter?.province"></span>, <span x-text="selectedCenter?.region"></span>
                </p>
                <p x-show="selectedCenter?.phone" class="text-sm text-gray-500 mb-2">
                    📞 <span x-text="selectedCenter?.phone"></span>
                </p>
                <a :href="'/admin/centers/' + selectedCenter?.id" class="text-indigo-600 text-sm hover:underline">
                    Batafsil →
                </a>
            </div>
        </div>
    </div>
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Map Container CSS Fix -->
    <style>
        #mapContainer { position: relative; overflow: hidden; min-height: 600px; }
        #map { position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1; width: 100%; height: 100%; }
        .leaflet-tile { visibility: visible !important; }
        .leaflet-container { background: #f0f0f0; }
        /* Ensure map is properly layered */
        .leaflet-pane { z-index: 400; }
        .leaflet-tile-pane { z-index: 200; }
        .leaflet-overlay-pane { z-index: 400; }
        .leaflet-marker-pane { z-index: 600; }
        .leaflet-popup-pane { z-index: 700; }
    </style>

    <!-- MarkerCluster CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        function adminMap() {
            return {
                map: null,
                markers: [],
                markerCluster: null,
                circle: null,
                mapReady: false,
                isFullscreen: false,
                locating: false,
                radius: 50,
                searchQuery: '',
                selectedProvince: '',
                selectedCenter: null,
                userLocation: null,
                centerCount: {{ count($centers) }},
                allCenters: @json($centers),
                filteredCenters: @json($centers),
                boundsFiltering: false,
                isFiltering: false,
                searchInput: '',
                provinceInput: '',
                locationSearch: '',
                clickToSet: false,
                userMarker: null,
                isZooming: false,
                pendingLoad: false,
                dynamicLoading: true,
                loadingMarkers: false,
                abortController: null,
                lastRequestId: 0,

                boot() {
                    this.$nextTick(() => {
                        console.log('Boot called, initializing map...');
                        // Prevent multiple initializations
                        if (this.map) {
                            console.log('Map already exists, skipping initialization');
                            return;
                        }
                        try {
                            this.initMap();
                        } catch (e) {
                            console.error('Map initialization error:', e);
                        }
                    });
                },

                initMap() {
                    console.log('initMap started');
                    const DEFAULT_LAT = 41.3111;
                    const DEFAULT_LNG = 69.2406;

                    // Check if map container exists
                    const mapContainer = document.getElementById('map');
                    if (!mapContainer) {
                        console.error('Map container not found!');
                        return;
                    }

                    // Check if map is already initialized (prevent duplicates)
                    if (mapContainer._leaflet_id) {
                        console.log('Map already initialized on this container, skipping');
                        return;
                    }
                    console.log('Map container found:', mapContainer);

                    this.map = L.map('map', {
                        zoomAnimation: true,
                        markerZoomAnimation: true
                    }).setView([DEFAULT_LAT, DEFAULT_LNG], 7);

                    console.log('Leaflet map created:', this.map);

                    const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors',
                        maxZoom: 18
                    }).addTo(this.map);

                    console.log('Tile layer added:', tiles);

                    // Initialize marker cluster with custom styling
                    this.markerCluster = L.markerClusterGroup({
                        chunkedLoading: true,
                        maxClusterRadius: 60,
                        spiderfyOnMaxZoom: true,
                        showCoverageOnHover: true,
                        zoomToBoundsOnClick: true,
                        iconCreateFunction: (cluster) => {
                            const count = cluster.getChildCount();
                            let className = 'bg-indigo-600';
                            let size = 'w-10 h-10';

                            if (count < 10) {
                                className = 'bg-green-500';
                                size = 'w-8 h-8';
                            } else if (count < 50) {
                                className = 'bg-indigo-500';
                                size = 'w-10 h-10';
                            } else if (count < 100) {
                                className = 'bg-orange-500';
                                size = 'w-12 h-12';
                            } else {
                                className = 'bg-red-600';
                                size = 'w-14 h-14';
                            }

                            return L.divIcon({
                                html: `<div class="${className} ${size} text-white rounded-full flex items-center justify-center font-bold shadow-lg border-2 border-white">${count}</div>`,
                                className: 'custom-cluster',
                                iconSize: null
                            });
                        }
                    });

                    this.map.addLayer(this.markerCluster);

                    // Track zoom state to prevent loading during animation
                    this.map.on('zoomstart', () => {
                        this.isZooming = true;
                        console.log('Zoom started');
                    });

                    this.map.on('zoomend', () => {
                        this.isZooming = false;
                        console.log('Zoom ended');
                        // Trigger load after zoom completes
                        if (this.pendingLoad) {
                            this.pendingLoad = false;
                            this.loadMarkersByBounds();
                        }
                    });

                    // Dynamic loading on map move (500ms debounce - increased for stability)
                    let debounceTimer;
                    let isMoving = false;
                    this.map.on('moveend', () => {
                        if (isMoving) return;
                        isMoving = true;

                        // Clear existing debounce timer
                        clearTimeout(debounceTimer);

                        debounceTimer = setTimeout(() => {
                            const zoom = this.map.getZoom();

                            // Skip if map not ready or zoom is invalid
                            if (!this.mapReady || !zoom || zoom <= 0 || zoom > 20) {
                                console.log('Skipping - map not ready or invalid zoom:', zoom);
                                isMoving = false;
                                return;
                            }

                            // If zoom < 6, clear markers and don't load
                            if (zoom < 6) {
                                this.markerCluster.clearLayers();
                                this.centerCount = 0;
                                console.warn('Zoom too low (' + zoom + '), markers cleared');
                                isMoving = false;
                                return;
                            }

                            // Skip if bounds filtering is active
                            if (this.boundsFiltering && !this.isFiltering) {
                                this.filterByBounds();
                                isMoving = false;
                                return;
                            }

                            // Skip if currently zooming - mark as pending
                            if (this.isZooming) {
                                console.log('Zoom in progress, marking load as pending');
                                this.pendingLoad = true;
                                isMoving = false;
                                return;
                            }

                            // Dynamic loading from backend
                            if (this.dynamicLoading) {
                                this.loadMarkersByBounds();
                            }

                            isMoving = false;
                        }, 500);
                    });

                    // Click to set location
                    this.map.on('click', (e) => {
                        if (this.clickToSet) {
                            this.setUserLocation(e.latlng.lat, e.latlng.lng);
                        }
                    });

                    // Ensure proper sizing before loading markers (multiple calls for stability)
                    setTimeout(() => {
                        this.map.invalidateSize();

                        setTimeout(() => {
                            this.map.invalidateSize();
                            this.mapReady = true;
                            console.log('Map ready, loading initial markers...');
                            this.loadMarkersByBounds();
                        }, 300);
                    }, 100);
                },

                addMarkers() {
                    // Clear cluster layers
                    this.markerCluster.clearLayers();

                    // Add markers to cluster (without fitBounds to prevent loops)
                    this.filteredCenters.forEach(center => {
                        if (!center.lat || !center.lng) return;

                        const marker = L.marker([center.lat, center.lng]);

                        marker.bindPopup(`
                            <div class="p-2 min-w-[200px]">
                                <h3 class="font-bold text-gray-900 text-base mb-1">${center.name}</h3>
                                <p class="text-sm text-gray-600">${center.address || 'Manzil kiritilmagan'}</p>
                                <p class="text-sm text-gray-500 mt-1">${center.province}, ${center.region}</p>
                                ${center.phone ? `<p class="text-sm text-gray-500 mt-1">📞 ${center.phone}</p>` : ''}
                                ${center.distance ? `<p class="text-sm text-indigo-600 mt-1 font-medium">📍 ${center.distance} km</p>` : ''}
                                <div class="mt-3 pt-2 border-t border-gray-200">
                                    <a href="/admin/centers/${center.id}" class="inline-flex items-center px-3 py-1.5 text-gray-50 text-xs font-medium rounded hover:bg-indigo-700 transition-colors">
                                        Batafsil ma'lumot
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        `, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });

                        marker.on('click', () => {
                            this.selectedCenter = center;
                        });

                        marker.on('mouseover', function() {
                            this.openPopup();
                        });

                        this.markerCluster.addLayer(marker);
                    });

                    // Note: Removed fitBounds to prevent moveend -> load loop
                },

                filterByBounds() {
                    if (this.isFiltering) return;
                    this.isFiltering = true;

                    const bounds = this.map.getBounds();

                    this.filteredCenters = this.allCenters.filter(c => {
                        if (!c.lat || !c.lng) return false;
                        return bounds.contains([c.lat, c.lng]);
                    });

                    this.centerCount = this.filteredCenters.length;

                    // Add markers without fitBounds to avoid moveend loop
                    this.addMarkersNoFitBounds();

                    setTimeout(() => {
                        this.isFiltering = false;
                    }, 100);
                },

                addMarkersNoFitBounds() {
                    this.markerCluster.clearLayers();

                    this.filteredCenters.forEach(center => {
                        if (!center.lat || !center.lng) return;

                        const marker = L.marker([center.lat, center.lng]);

                        marker.bindPopup(`
                            <div class="p-2 min-w-[200px]">
                                <h3 class="font-bold text-gray-900 text-base mb-1">${center.name}</h3>
                                <p class="text-sm text-gray-600">${center.address || 'Manzil kiritilmagan'}</p>
                                <p class="text-sm text-gray-500 mt-1">${center.province}, ${center.region}</p>
                                ${center.phone ? `<p class="text-sm text-gray-500 mt-1">📞 ${center.phone}</p>` : ''}
                                ${center.distance ? `<p class="text-sm text-indigo-600 mt-1 font-medium">📍 ${center.distance} km</p>` : ''}
                                <div class="mt-3 pt-2 border-t border-gray-200">
                                    <a href="/admin/centers/${center.id}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition-colors">
                                        Batafsil ma'lumot
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        `, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });

                        marker.on('click', () => {
                            this.selectedCenter = center;
                        });

                        marker.on('mouseover', function() {
                            this.openPopup();
                        });

                        this.markerCluster.addLayer(marker);
                    });
                },

                locateMe() {
                    this.locating = true;
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
                                this.map.setView([this.userLocation.lat, this.userLocation.lng], 12);
                                this.addUserMarker();
                                this.applyFilters();
                                this.locating = false;
                            },
                            () => {
                                alert('Joylashuvni aniqlash mumkin emas');
                                this.locating = false;
                            }
                        );
                    } else {
                        alert('Geolokatsiya qo\'llab-quvvatlanmaydi');
                        this.locating = false;
                    }
                },

                addUserMarker() {
                    if (this.userLocation) {
                        L.marker([this.userLocation.lat, this.userLocation.lng], {
                            icon: L.divIcon({
                                className: 'bg-blue-500 rounded-full w-4 h-4 border-2 border-white shadow',
                                iconSize: [16, 16]
                            })
                        }).addTo(this.map).bindPopup('Sizning joylashuvingiz');

                        // Add circle for radius
                        if (this.circle) {
                            this.map.removeLayer(this.circle);
                        }
                        this.circle = L.circle([this.userLocation.lat, this.userLocation.lng], {
                            radius: this.radius * 1000,
                            color: '#4f46e5',
                            fillColor: '#4f46e5',
                            fillOpacity: 0.1
                        }).addTo(this.map);
                    }
                },

                onSearchChange(value) {
                    this.searchQuery = value.toLowerCase();
                    this.applyFilters();
                },

                onProvinceChange(value) {
                    this.selectedProvince = value;
                    this.applyFilters();
                },

                onRadiusChange() {
                    this.applyFilters();
                    if (this.userLocation) {
                        this.addUserMarker();
                    }
                },

                applyFilters() {
                    let filtered = this.allCenters;

                    // Search filter
                    if (this.searchQuery) {
                        filtered = filtered.filter(c =>
                            c.name.toLowerCase().includes(this.searchQuery) ||
                            (c.address && c.address.toLowerCase().includes(this.searchQuery))
                        );
                    }

                    // Province filter
                    if (this.selectedProvince) {
                        filtered = filtered.filter(c => c.province === this.selectedProvince);
                    }

                    // Radius filter
                    if (this.userLocation) {
                        filtered = filtered.map(c => {
                            const distance = this.calculateDistance(
                                this.userLocation.lat, this.userLocation.lng,
                                c.lat, c.lng
                            );
                            return { ...c, distance: distance.toFixed(1) };
                        }).filter(c => parseFloat(c.distance) <= this.radius);
                    }

                    this.filteredCenters = filtered;
                    this.centerCount = filtered.length;
                    this.addMarkers();
                },

                calculateDistance(lat1, lng1, lat2, lng2) {
                    const R = 6371; // Earth's radius in km
                    const dLat = this.deg2rad(lat2 - lat1);
                    const dLng = this.deg2rad(lng2 - lng1);
                    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                              Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
                              Math.sin(dLng/2) * Math.sin(dLng/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    return R * c;
                },

                deg2rad(deg) {
                    return deg * (Math.PI/180);
                },

                async loadMarkersByBounds() {
                    // Prevent concurrent requests
                    if (this.loadingMarkers) {
                        console.log('Already loading, skipping...');
                        return;
                    }

                    // Double-check zoom is valid before loading
                    const zoom = this.map.getZoom();
                    if (!zoom || zoom <= 0 || zoom > 20) {
                        console.log('Invalid zoom, skipping load:', zoom);
                        return;
                    }

                    this.loadingMarkers = true;
                    const requestId = ++this.lastRequestId;

                    try {
                        const bounds = this.map.getBounds();

                        const north = bounds.getNorth();
                        const south = bounds.getSouth();
                        const east = bounds.getEast();
                        const west = bounds.getWest();

                        console.log(`Loading markers: zoom=${zoom}, bounds=[${north.toFixed(4)}, ${south.toFixed(4)}, ${east.toFixed(4)}, ${west.toFixed(4)}]`);

                        // Call Livewire method
                        const centers = await @this.call('getCentersByBounds', north, south, east, west, zoom);

                        // Check if this is the most recent request
                        if (requestId !== this.lastRequestId) {
                            console.log('Ignoring outdated response #' + requestId);
                            return;
                        }

                        // Validate data before updating
                        if (!Array.isArray(centers)) {
                            console.error('Invalid response format:', centers);
                            return;
                        }

                        this.allCenters = centers;
                        this.filteredCenters = centers;
                        this.centerCount = centers.length;

                        // Update markers (with check to prevent updates during zoom)
                        if (!this.isZooming) {
                            this.updateMarkers(centers);
                        } else {
                            console.log('Zoom in progress, deferring marker update');
                            // Store for later update
                            this.deferredCenters = centers;
                        }

                        // Warning if hitting the limit
                        const currentLimit = zoom < 8 ? 100 : (zoom < 11 ? 300 : (zoom < 14 ? 1000 : 2000));
                        if (centers.length >= currentLimit) {
                            console.warn(`Loaded ${centers.length} markers (limit reached). Zoom in for more details.`);
                        } else {
                            console.log(`Loaded ${centers.length} markers successfully`);
                        }

                    } catch (error) {
                        if (error.name !== 'AbortError') {
                            console.error('Error loading markers:', error);
                        }
                    } finally {
                        if (requestId === this.lastRequestId) {
                            this.loadingMarkers = false;
                        }
                    }
                },

                updateMarkers(centers) {
                    // Skip if no valid centers
                    if (!Array.isArray(centers) || centers.length === 0) {
                        this.markerCluster.clearLayers();
                        return;
                    }

                    // Use chunked loading for large datasets to prevent UI blocking
                    const chunkSize = 100;
                    let index = 0;

                    // Clear existing markers first
                    this.markerCluster.clearLayers();

                    // Process markers in chunks
                    const processChunk = () => {
                        const chunk = centers.slice(index, index + chunkSize);

                        chunk.forEach(center => {
                            if (!center.lat || !center.lng) return;

                            const marker = L.marker([center.lat, center.lng]);

                            marker.bindPopup(`
                                <div class="p-2 min-w-[200px]">
                                    <h3 class="font-bold text-gray-900 text-base mb-1">${center.name}</h3>
                                    <p class="text-sm text-gray-600">${center.address || 'Manzil kiritilmagan'}</p>
                                    <p class="text-sm text-gray-500 mt-1">${center.province}, ${center.region}</p>
                                    ${center.phone ? `<p class="text-sm text-gray-500 mt-1">📞 ${center.phone}</p>` : ''}
                                    ${center.distance ? `<p class="text-sm text-indigo-600 mt-1 font-medium">📍 ${center.distance} km</p>` : ''}
                                    <div class="mt-3 pt-2 border-t border-gray-200">
                                        <a href="/admin/centers/${center.id}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition-colors">
                                            Batafsil ma'lumot
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            `, {
                                maxWidth: 300,
                                className: 'custom-popup'
                            });

                            marker.on('click', () => {
                                this.selectedCenter = center;
                            });

                            marker.on('mouseover', function() {
                                this.openPopup();
                            });

                            this.markerCluster.addLayer(marker);
                        });

                        index += chunkSize;

                        // Schedule next chunk if there are more markers
                        if (index < centers.length) {
                            requestAnimationFrame(processChunk);
                        }
                    };

                    // Start processing chunks
                    processChunk();
                },

                focusOnCenter(center) {
                    this.map.setView([center.lat, center.lng], 16, {
                        animate: true,
                        duration: 0.5
                    });
                    this.selectedCenter = center;

                    // Ensure marker is loaded by fetching bounds that include this center
                    const lat = center.lat;
                    const lng = center.lng;
                    const smallBounds = L.latLngBounds([lat - 0.01, lng - 0.01], [lat + 0.01, lng + 0.01]);
                    this.map.fitBounds(smallBounds, { animate: false });

                    // Reload markers for this area
                    this.loadMarkersByBounds().then(() => {
                        // Find marker in cluster and open popup
                        setTimeout(() => {
                            const marker = this.markerCluster.getLayers().find(m => {
                                const pos = m.getLatLng();
                                return Math.abs(pos.lat - center.lat) < 0.0001 && Math.abs(pos.lng - center.lng) < 0.0001;
                            });
                            if (marker) {
                                this.markerCluster.zoomToShowLayer(marker, () => {
                                    marker.openPopup();
                                });
                            }
                        }, 400);
                    });
                },

                toggleClickToSet() {
                    this.clickToSet = !this.clickToSet;
                    if (this.clickToSet) {
                        this.map.getContainer().style.cursor = 'crosshair';
                    } else {
                        this.map.getContainer().style.cursor = '';
                    }
                },

                setUserLocation(lat, lng) {
                    this.userLocation = { lat, lng };

                    // Remove existing user marker
                    if (this.userMarker) {
                        this.map.removeLayer(this.userMarker);
                    }

                    // Add draggable marker
                    this.userMarker = L.marker([lat, lng], {
                        draggable: true,
                        icon: L.divIcon({
                            html: `<div class="bg-red-500 rounded-full w-5 h-5 border-2 border-white shadow-lg animate-pulse"></div>`,
                            className: 'user-location-marker',
                            iconSize: [20, 20],
                            iconAnchor: [10, 10]
                        })
                    }).addTo(this.map);

                    this.userMarker.bindPopup('Sizning joylashuvingiz<br>(Sudrab olib o`zgartirish mumkin)').openPopup();

                    // Handle drag end
                    this.userMarker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        this.userLocation = { lat: pos.lat, lng: pos.lng };
                        this.applyFilters();
                    });

                    this.clickToSet = false;
                    this.map.getContainer().style.cursor = '';
                    this.applyFilters();
                },

                async searchLocation() {
                    if (!this.locationSearch.trim()) return;

                    try {
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.locationSearch + ', Uzbekistan')}&limit=1`
                        );
                        const data = await response.json();

                        if (data && data.length > 0) {
                            const result = data[0];
                            const lat = parseFloat(result.lat);
                            const lng = parseFloat(result.lon);

                            this.map.setView([lat, lng], 14, { animate: true });
                            this.setUserLocation(lat, lng);
                            this.locationSearch = result.display_name.split(',')[0];
                        } else {
                            alert('Joylashuv topilmadi');
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        alert('Qidirishda xatolik yuz berdi');
                    }
                },

                toggleFullscreen() {
                    this.isFullscreen = !this.isFullscreen;
                    this.$nextTick(() => {
                        // Force multiple invalidations for fullscreen transition
                        [0, 100, 300, 500].forEach(delay => {
                            setTimeout(() => {
                                if (this.map) {
                                    this.map.invalidateSize(true);
                                }
                            }, delay);
                        });
                    });
                },

                resetFilter() {
                    this.searchQuery = '';
                    this.selectedProvince = '';
                    this.searchInput = '';
                    this.provinceInput = '';
                    this.locationSearch = '';
                    this.radius = 50;
                    this.userLocation = null;
                    this.selectedCenter = null;
                    this.boundsFiltering = false;
                    this.clickToSet = false;

                    if (this.circle) {
                        this.map.removeLayer(this.circle);
                        this.circle = null;
                    }

                    if (this.userMarker) {
                        this.map.removeLayer(this.userMarker);
                        this.userMarker = null;
                    }

                    this.map.getContainer().style.cursor = '';

                    @this.set('search', '');
                    @this.set('province', '');
                    this.applyFilters();

                    // Reset map view to Uzbekistan
                    this.map.setView([41.3111, 69.2406], 7, { animate: true });
                },

                toggleBoundsFiltering() {
                    this.boundsFiltering = !this.boundsFiltering;
                    if (this.boundsFiltering) {
                        this.filterByBounds();
                    } else {
                        this.applyFilters();
                    }
                }
            }
        }
    </script>
</div>
