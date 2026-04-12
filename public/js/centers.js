// Blog Grid JavaScript - Extracted from centers.blade.php
// This file contains all JavaScript functionality for the blog grid page

// Check if page was restored from cache (back button) and reload if needed
window.addEventListener('pageshow', function (event) {
    // If persisted is true, the page was loaded from cache (bfcache)
    if (event.persisted) {
        window.location.reload();
        return;
    }

    // Also check if the centers grid contains JSON instead of HTML
    const centersGrid = document.getElementById('centersGrid');
    if (centersGrid && centersGrid.innerHTML.trim().startsWith('{')) {
        window.location.reload();
        return;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Initialize sorting buttons based on current URL
    updateSortingButtons();

    // Search form handler
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }

    // Initialize current filters
    window.currentFilters = new URLSearchParams(window.location.search);

    // Initialize infinite scroll
    setupInfiniteScroll();
});

// Search form handler
function handleSearch(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const searchBtn = document.getElementById('searchBtn');
    const searchIcon = document.getElementById('searchIcon');
    const loadingIcon = document.getElementById('loadingIcon');

    // Update URL parameters
    window.currentFilters.set('searchText', formData.get('searchText'));

    // Show loading state
    searchBtn.disabled = true;
    searchIcon.classList.add('hidden');
    loadingIcon.classList.remove('hidden');

    // Perform AJAX search
    performSearch();
}

function clearAllFilters() {
    window.currentFilters = new URLSearchParams();
    performSearch();
}

function applyFilter(type, value) {
    if (value && value !== 'all') {
        window.currentFilters.set(type, value);
    } else {
        window.currentFilters.delete(type);
    }
    performSearch();
}

function removeFilter(type) {
    window.currentFilters.delete(type);
    performSearch();
}

function applyPriceFilter() {
    const minPrice = document.getElementById('minPriceInput').value;
    const maxPrice = document.getElementById('maxPriceInput').value;

    if (minPrice) {
        window.currentFilters.set('min_price', minPrice);
    } else {
        window.currentFilters.delete('min_price');
    }

    if (maxPrice) {
        window.currentFilters.set('max_price', maxPrice);
    } else {
        window.currentFilters.delete('max_price');
    }

    performSearch();
}

// Preserve existing user search queries in price inputs
document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    if (params.has('min_price')) {
        let el = document.getElementById('minPriceInput');
        if (el) el.value = params.get('min_price');
    }
    if (params.has('max_price')) {
        let el = document.getElementById('maxPriceInput');
        if (el) el.value = params.get('max_price');
    }
});

function applySorting(sortType, direction) {
    // Clear all existing sort parameters
    window.currentFilters.delete('name');
    window.currentFilters.delete('distance');
    window.currentFilters.delete('favorites');
    window.currentFilters.delete('sort');

    // Set the new sort type and direction
    window.currentFilters.set(sortType, direction);
    window.currentFilters.set('sort', sortType);
    performSearch();
}

function updateSortingButtons() {
    const urlParams = new URLSearchParams(window.location.search);
    const sortType = urlParams.get('sort');
    const sortDirection = urlParams.get(sortType);

    // Update name sorting button
    const nameButton = document.querySelector('[onclick*="applySorting(\'name\'"]');
    if (nameButton) {
        if (sortType === 'name' && sortDirection === 'asc') {
            nameButton.setAttribute('onclick', "applySorting('name', 'desc')");
            nameButton.innerHTML = 'Nomi ↑';
        } else if (sortType === 'name' && sortDirection === 'desc') {
            nameButton.setAttribute('onclick', "applySorting('name', 'asc')");
            nameButton.innerHTML = 'Nomi ↓';
        } else {
            nameButton.setAttribute('onclick', "applySorting('name', 'asc')");
            nameButton.innerHTML = 'Nomi ↑↓';
        }
    }

    // Update distance sorting button
    const distanceButton = document.querySelector('[onclick*="applySorting(\'distance\'"]');
    if (distanceButton) {
        if (sortType === 'distance' && sortDirection === 'asc') {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'desc')");
            distanceButton.innerHTML = 'Masofasi ↑';
        } else if (sortType === 'distance' && sortDirection === 'desc') {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'asc')");
            distanceButton.innerHTML = 'Masofasi ↓';
        } else {
            distanceButton.setAttribute('onclick', "applySorting('distance', 'asc')");
            distanceButton.innerHTML = 'Masofasi ↑↓';
        }
    }

    // Update favorites sorting button
    const favoritesButton = document.querySelector('[onclick*="applySorting(\'favorites\'"]');
    if (favoritesButton) {
        if (sortType === 'favorites' && sortDirection === 'asc') {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'desc')");
            favoritesButton.innerHTML = 'Reytingi ↑';
        } else if (sortType === 'favorites' && sortDirection === 'desc') {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'asc')");
            favoritesButton.innerHTML = 'Reytingi ↓';
        } else {
            favoritesButton.setAttribute('onclick', "applySorting('favorites', 'asc')");
            favoritesButton.innerHTML = 'Reytingi ↑↓';
        }
    }
}

function performSearch() {
    const loadingIndicator = document.getElementById('loadingIndicator');
    const centersGrid = document.getElementById('centersGrid');
    const resultsCount = document.getElementById('resultsCount');

    // Show loading
    loadingIndicator.classList.remove('hidden');
    centersGrid.classList.add('hidden');

    // Build URL
    const url = window.location.pathname + '?' + window.currentFilters.toString();

    // Update browser URL without reload
    history.pushState(null, '', url);

    // Perform AJAX request
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update results count — use total, not the per-page count
                resultsCount.textContent = data.pagination ? data.pagination.total : data.count;

                // Update centers grid
                centersGrid.innerHTML = data.html;

                // Update pagination state
                if (data.pagination) {
                    currentPage = data.pagination.current_page;
                    hasMorePages = data.pagination.has_more_pages;
                } else {
                    // Fallback for non-paginated responses
                    currentPage = 1;
                    hasMorePages = false;
                }

                // Update sorting buttons based on current URL
                updateSortingButtons();

                // Reinitialize map component if needed
                if (typeof window.mapFilterComp === 'function') {
                    // Update centers data for map
                    if (data.centers) {
                        updateMapCenters(data.centers);
                    } else {
                        console.warn('No centers data received for map');
                    }
                } else {
                    console.warn('Map component not available');
                }

                // Show/hide no more results message
                const noMoreResults = document.getElementById('noMoreResults');
                if (noMoreResults) {
                    if (hasMorePages) {
                        noMoreResults.classList.add('hidden');
                    } else {
                        noMoreResults.classList.remove('hidden');
                    }
                }
            } else {
                // Show error
                centersGrid.innerHTML = '<div class="col-span-full text-center py-8 text-red-600">Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.</div>';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            centersGrid.innerHTML = '<div class="col-span-full text-center py-8 text-red-600">Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.</div>';
        })
        .finally(() => {
            // Hide loading and reset button
            loadingIndicator.classList.add('hidden');
            centersGrid.classList.remove('hidden');

            const searchBtn = document.getElementById('searchBtn');
            const searchIcon = document.getElementById('searchIcon');
            const loadingIcon = document.getElementById('loadingIcon');

            if (searchBtn) {
                searchBtn.disabled = false;
                searchIcon.classList.remove('hidden');
                loadingIcon.classList.add('hidden');
            }

            // Close all dropdowns after AJAX request
            closeAllDropdowns();
        });
}

function updateMapCenters(centers) {
    // Backend now sends already normalized payload:
    // [{id,name,lat,lng,address,image,detail_url}, ...]
    window._CENTERS = Array.isArray(centers) ? centers : [];

    // Refresh map if open
    const mapElement = document.querySelector('[x-data="mapFilterComp()"]');
    const mapComponent = mapElement && mapElement._x_dataStack ? mapElement._x_dataStack[0] : null;
    if (mapComponent && typeof mapComponent._loadCenters === 'function') {
        mapComponent._loadCenters();
    }
}

function closeAllDropdowns() {
    // Close all dropdown panels by clicking outside or setting their display to none
    const dropdownPanels = document.querySelectorAll('[x-show]');
    dropdownPanels.forEach(function (panel) {
        // Check if this panel is currently shown
        const xShowAttr = panel.getAttribute('x-show');
        if (xShowAttr) {
            // Try to evaluate the expression to see if it's true
            try {
                const context = panel.closest('[x-data]');
                if (context && window.Alpine) {
                    // Force the expression to be false by updating the underlying data
                    if (xShowAttr === 'sortDropdown') {
                        window.Alpine.evaluate(context, 'sortDropdown = false');
                    } else if (xShowAttr === 'teacherDropdown') {
                        window.Alpine.evaluate(context, 'teacherDropdown = false');
                    } else if (xShowAttr === 'open') {
                        window.Alpine.evaluate(context, 'open = false');
                    }
                }
            } catch (e) {
                // Fallback: hide the panel directly
                panel.style.display = 'none';
            }
        }
    });

    // Alternative approach: click outside to trigger @click.away
    document.body.click();
}

// Handle browser back/forward buttons
window.addEventListener('popstate', function () {
    window.currentFilters = new URLSearchParams(window.location.search);
    performSearch();
});

// Infinite Scroll Pagination
let currentPage = 1;
let isLoading = false;
let hasMorePages = true;

// Initialize pagination from server-side data (will be set by Laravel)
// These values will be dynamically set in the template

function loadMorePages() {
    if (isLoading || !hasMorePages) return;

    isLoading = true;
    currentPage++;

    // Show loading indicator
    const loadingIndicator = document.getElementById('infiniteScrollLoading');
    const noMoreResults = document.getElementById('noMoreResults');

    if (loadingIndicator) {
        loadingIndicator.classList.remove('hidden');
    }

    // Build URL with page parameter
    const filters = new URLSearchParams(window.currentFilters.toString());
    filters.set('page', currentPage);

    const url = window.location.pathname + '?' + filters.toString();

    // Perform AJAX request for next page
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.html) {
                // Append new items to the grid
                const centersGrid = document.getElementById('centersGrid');
                if (centersGrid) {
                    // Create a temporary div to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;

                    // Extract and append only the center cards
                    // The cards are wrapped in group containers with glow effect
                    const newCards = tempDiv.querySelectorAll('.group.relative');
                    newCards.forEach(card => {
                        centersGrid.appendChild(card);
                    });
                }

                // Update pagination state
                if (data.pagination) {
                    hasMorePages = data.pagination.has_more_pages;
                    currentPage = data.pagination.current_page;
                }

                // Update results count
                const resultsCount = document.getElementById('resultsCount');
                if (resultsCount && data.pagination) {
                    resultsCount.textContent = data.pagination.total;
                }

                // Show/hide appropriate messages
                if (!hasMorePages) {
                    if (noMoreResults) {
                        noMoreResults.classList.remove('hidden');
                    }
                }

                // Update map with new centers data
                if (data.centers && typeof window.mapFilterComp === 'function') {
                    updateMapCenters(data.centers);
                }
            } else {
                console.error('Failed to load more items');
                hasMorePages = false;
            }
        })
        .catch(error => {
            console.error('Error loading more items:', error);
            hasMorePages = false;
        })
        .finally(() => {
            isLoading = false;
            if (loadingIndicator) {
                loadingIndicator.classList.add('hidden');
            }
        });
}

// Set up infinite scroll event listener
function setupInfiniteScroll() {
    const scrollThreshold = 200; // Load more when 200px from bottom

    window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;

        // Check if user is near the bottom
        if (scrollTop + windowHeight >= documentHeight - scrollThreshold) {
            loadMorePages();
        }
    });
}

// Reset pagination state when performing new search
const originalPerformSearch = performSearch;
performSearch = function () {
    currentPage = 1;
    hasMorePages = true;
    isLoading = false;

    // Hide no more results message
    const noMoreResults = document.getElementById('noMoreResults');
    if (noMoreResults) {
        noMoreResults.classList.add('hidden');
    }

    // Call original performSearch function
    originalPerformSearch.apply(this, arguments);
};

// NOTE: location detection for map filter is handled inside mapFilterComp().

// Modern Leaflet Map UX (clustered markers + locate + fullscreen)

// Alpine.js Map Filter Component - Enhanced Version
document.addEventListener('alpine:init', () => {
    window.mapFilterComp = function () {
        return {
            /* public state */
            isPanelOpen: false,
            isFullscreen: false,
            mapReady: false,
            locating: false,
            lat: null,
            lng: null,
            radius: 5,
            darkMode: false,
            addressText: 'Xaritada joylashuvni tanlang',
            resultShown: false,
            resultCount: 0,
            mapHeight: 500, // Dynamic height
            isResizing: false,

            /* private */
            _map: null,
            _selectedMarker: null,
            _cluster: null,
            _centerMarkers: [],
            _escHandler: null,
            _resizeObserver: null,
            _allCenters: [], // Store all centers
            _centerBounds: null, // Store bounds for all centers

            boot() {
                this.darkMode = document.documentElement.classList.contains('dark');

                const p = new URLSearchParams(window.location.search);
                if (p.get('latitude')) this.lat = parseFloat(p.get('latitude'));
                if (p.get('longitude')) this.lng = parseFloat(p.get('longitude'));
                if (p.get('radius')) this.radius = parseFloat(p.get('radius'));

                // Load all centers from window._CENTERS
                this._allCenters = window._CENTERS || [];
                
                // Calculate bounds for all centers
                this._calculateAllCenterBounds();

                new MutationObserver(() => {
                    this.darkMode = document.documentElement.classList.contains('dark');
                    if (this._map) {
                        this._applyTiles();
                    }
                }).observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
                
                // Listen for window resize
                window.addEventListener('resize', () => {
                    if (this._map) {
                        this._map.invalidateSize({ animate: false });
                    }
                });
            },

            _calculateAllCenterBounds() {
                const validCenters = this._allCenters.filter(c => {
                    const lat = parseFloat(c.lat);
                    const lng = parseFloat(c.lng);
                    return Number.isFinite(lat) && Number.isFinite(lng);
                });
                
                if (validCenters.length === 0) {
                    // Default to Uzbekistan bounds
                    this._centerBounds = [[37.2, 55.9], [45.6, 73.2]];
                    return;
                }
                
                const lats = validCenters.map(c => parseFloat(c.lat));
                const lngs = validCenters.map(c => parseFloat(c.lng));
                
                this._centerBounds = [
                    [Math.min(...lats) - 0.5, Math.min(...lngs) - 0.5], // SW corner with padding
                    [Math.max(...lats) + 0.5, Math.max(...lngs) + 0.5]  // NE corner with padding
                ];
            },

            // Dynamic resize handlers
            startResize(e) {
                this.isResizing = true;
                const startY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;
                const startHeight = this.mapHeight;
                
                const handleMove = (moveEvent) => {
                    if (!this.isResizing) return;
                    const currentY = moveEvent.type === 'touchmove' ? moveEvent.touches[0].clientY : moveEvent.clientY;
                    const deltaY = currentY - startY;
                    this.mapHeight = Math.max(300, Math.min(900, startHeight + deltaY));
                    
                    this.$nextTick(() => {
                        if (this._map) this._map.invalidateSize({ animate: false });
                    });
                };
                
                const handleEnd = () => {
                    this.isResizing = false;
                    document.removeEventListener('mousemove', handleMove);
                    document.removeEventListener('mouseup', handleEnd);
                    document.removeEventListener('touchmove', handleMove);
                    document.removeEventListener('touchend', handleEnd);
                };
                
                document.addEventListener('mousemove', handleMove);
                document.addEventListener('mouseup', handleEnd);
                document.addEventListener('touchmove', handleMove);
                document.addEventListener('touchend', handleEnd);
            },

            toggle() {
                this.isPanelOpen = !this.isPanelOpen;
                if (this.isPanelOpen) {
                    this.$nextTick(() => setTimeout(() => this._initMap(), 120));
                } else {
                    this._exitFullscreen();
                }
            },

            toggleFullscreen() {
                if (!this.isPanelOpen) return;
                this.isFullscreen = !this.isFullscreen;
                const panel = this.$root.querySelector('.mf-panel');
                if (!panel) return;

                panel.classList.toggle('mf-fullscreen', this.isFullscreen);
                document.body.classList.toggle('mf-fullscreen-open', this.isFullscreen);

                if (this.isFullscreen) {
                    this._escHandler = (e) => {
                        if (e.key === 'Escape') this._exitFullscreen();
                    };
                    window.addEventListener('keydown', this._escHandler);
                } else {
                    this._removeEscHandler();
                }

                this.$nextTick(() => {
                    if (this._map) this._map.invalidateSize({ animate: true });
                });
            },

            _exitFullscreen() {
                if (!this.isFullscreen) return;
                this.isFullscreen = false;
                const panel = this.$root.querySelector('.mf-panel');
                if (panel) panel.classList.remove('mf-fullscreen');
                document.body.classList.remove('mf-fullscreen-open');
                this._removeEscHandler();
                this.$nextTick(() => {
                    if (this._map) this._map.invalidateSize({ animate: true });
                });
            },

            _removeEscHandler() {
                if (this._escHandler) {
                    window.removeEventListener('keydown', this._escHandler);
                    this._escHandler = null;
                }
            },

            locateMe() {
                this._ensureMap();
                this._detectUserLocation(true);
            },

            applyMapFilter() {
                if (!window.currentFilters) {
                    window.currentFilters = new URLSearchParams(window.location.search);
                }

                if (Number.isFinite(this.lat)) window.currentFilters.set('latitude', this.lat);
                if (Number.isFinite(this.lng)) window.currentFilters.set('longitude', this.lng);
                if (Number.isFinite(this.radius)) window.currentFilters.set('radius', this.radius);

                // Do NOT auto-trigger on slider change; only run when user clicks Search.
                if (typeof performSearch === 'function') {
                    performSearch();
                }
            },

            resetFilter() {
                // Clear selected location + radius to defaults, but DO NOT trigger AJAX.
                this.lat = null;
                this.lng = null;
                this.radius = 5;
                this.addressText = 'Xaritada joylashuvni tanlang';

                if (this._map && this._selectedMarker) {
                    this._map.removeLayer(this._selectedMarker);
                    this._selectedMarker = null;
                }

                // Clear URL params only; user must hit "Qidirish" to apply.
                const url = new URL(window.location);
                url.searchParams.delete('latitude');
                url.searchParams.delete('longitude');
                url.searchParams.delete('radius');
                window.history.replaceState({}, '', url);
            },

            _ensureMap() {
                if (!this._map) {
                    this._initMap();
                }
            },

            _initMap() {
                if (this._map) {
                    this._map.invalidateSize({ animate: true });
                    return;
                }

                const el = document.getElementById('filterMapEl');
                if (!el || typeof L === 'undefined') return;

                const uzDefault = [41.3775, 64.5853];
                const initialCenter = [
                    Number.isFinite(this.lat) ? this.lat : uzDefault[0],
                    Number.isFinite(this.lng) ? this.lng : uzDefault[1]
                ];

                this._map = L.map(el, {
                    center: initialCenter,
                    zoom: 6,
                    zoomControl: false,
                    scrollWheelZoom: true,
                    worldCopyJump: true,
                    zoomSnap: 0.5,
                    zoomDelta: 0.5,
                    wheelDebounceTime: 40
                });

                L.control.zoom({ position: 'topright' }).addTo(this._map);

                this._applyTiles();

                // Enhanced marker clustering similar to admin map
                this._cluster = L.markerClusterGroup({
                    chunkedLoading: true,
                    showCoverageOnHover: true,
                    spiderfyOnMaxZoom: true,
                    zoomToBoundsOnClick: true,
                    maxClusterRadius: 60,
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
                this._map.addLayer(this._cluster);

                this._map.on('click', (e) => {
                    // Allow manual location selection by clicking map
                    if (e && e.latlng) {
                        this._setSelectedLocation(e.latlng.lat, e.latlng.lng, true);
                    }
                });

                // Enhanced resize observer for dynamic resizing
                const panel = this.$root.querySelector('.mf-panel');
                const mapEl = this.$root.querySelector('#filterMapEl');
                if (mapEl && !this._resizeObserver && typeof ResizeObserver !== 'undefined') {
                    this._resizeObserver = new ResizeObserver(() => {
                        if (this._map) this._map.invalidateSize({ animate: false });
                    });
                    this._resizeObserver.observe(mapEl);
                }

                // Render all centers
                this._renderCenters(window._CENTERS || []);

                // Set initial view to show all of Uzbekistan or all center bounds
                if (this._centerBounds) {
                    this._map.fitBounds(this._centerBounds, {
                        padding: [50, 50],
                        animate: true,
                        duration: 0.6
                    });
                } else {
                    // Default to Uzbekistan view
                    this._map.setView([41.3775, 64.5853], 6, { animate: true });
                }

                // Only auto-detect once: if URL doesn't already have explicit coordinates
                if (!Number.isFinite(this.lat) || !Number.isFinite(this.lng)) {
                    // Don't auto-detect, keep the full country view
                } else {
                    // If URL already contains a location, show it as selected
                    this._setSelectedLocation(this.lat, this.lng, false);
                }

                this.mapReady = true;
            },

            _applyTiles() {
                if (!this._map) return;

                if (this._tileLayer) {
                    this._map.removeLayer(this._tileLayer);
                }

                const tileUrl = this.darkMode
                    ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                    : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

                this._tileLayer = L.tileLayer(tileUrl, {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(this._map);
            },

            // Called by AJAX refresh code (updateMapCenters)
            _loadCenters() {
                this._renderCenters(window._CENTERS || []);
            },

            _renderCenters(centers) {
                if (!this._map || !this._cluster) return;

                // Store centers for later use
                if (centers && centers.length > 0) {
                    this._allCenters = centers;
                    this._calculateAllCenterBounds();
                }

                // Clear previous
                this._cluster.clearLayers();
                this._centerMarkers = [];

                const validCenters = (centers || []).filter(c => {
                    const lat = parseFloat(c.lat);
                    const lng = parseFloat(c.lng);
                    return Number.isFinite(lat) && Number.isFinite(lng);
                });

                // Update center count for display
                this.resultCount = validCenters.length;
                this.resultShown = validCenters.length > 0;

                // If no centers, show all centers from initial data
                if (validCenters.length === 0 && this._allCenters.length > 0) {
                    this._allCenters.forEach((c) => {
                        const lat = parseFloat(c.lat);
                        const lng = parseFloat(c.lng);
                        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

                        const marker = L.marker([lat, lng], {
                            icon: this._centerIcon()
                        });

                        marker.bindPopup(this._popupHtml(c, lat, lng), {
                            closeButton: false,
                            maxWidth: 320,
                            className: 'mf-popup'
                        });

                        this._cluster.addLayer(marker);
                        this._centerMarkers.push(marker);
                    });
                } else {
                    // Show filtered centers
                    validCenters.forEach((c) => {
                        const lat = parseFloat(c.lat);
                        const lng = parseFloat(c.lng);
                        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

                        const marker = L.marker([lat, lng], {
                            icon: this._centerIcon()
                        });

                        marker.bindPopup(this._popupHtml(c, lat, lng), {
                            closeButton: false,
                            maxWidth: 320,
                            className: 'mf-popup'
                        });

                        this._cluster.addLayer(marker);
                        this._centerMarkers.push(marker);
                    });
                }

                // Fit bounds to show all markers or default to Uzbekistan
                if (this._centerBounds) {
                    this._map.fitBounds(this._centerBounds, {
                        padding: [50, 50],
                        animate: true,
                        duration: 0.6
                    });
                } else {
                    // fallback: Uzbekistan view
                    this._map.setView([41.3775, 64.5853], 6, { animate: true });
                }
            },

            _centerIcon() {
                return L.divIcon({
                    className: 'mf-pin mf-pin-center',
                    html: '<div class="mf-pin-dot"></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });
            },

            _userIcon() {
                return L.divIcon({
                    className: 'mf-pin mf-pin-user',
                    html: '<div class="mf-pin-dot"></div>',
                    iconSize: [34, 34],
                    iconAnchor: [17, 34],
                    popupAnchor: [0, -34]
                });
            },

            _popupHtml(center, lat, lng) {
                const name = (center && center.name) ? String(center.name) : 'O‘quv markazi';
                const address = (center && center.address) ? String(center.address) : 'Manzil ko‘rsatilmagan';
                const img = (center && center.image) ? String(center.image) : '';
                const detailUrl = (center && center.detail_url) ? String(center.detail_url) : `/center/${center.slug || center.id}`;
                const type = (center && center.type) ? String(center.type) : '';
                const rating = (center && center.calculated_total_reyting) ? parseFloat(center.calculated_total_reyting).toFixed(1) : null;
                const verified = (center && center.checked) ? true : false;

                const gmaps = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(lat + ',' + lng)}`;

                // Image section with gradient fallback
                const imageHtml = img
                    ? `<div class="mf-card-image"><img src="${img}" alt="${name}" loading="lazy"><div class="mf-card-image-overlay"></div></div>`
                    : `<div class="mf-card-image mf-card-image--gradient"><div class="mf-card-image-overlay"></div><span class="mf-card-image-letter">${name.charAt(0).toUpperCase()}</span></div>`;

                // Type badge
                const typeBadge = type ? `<span class="mf-card-type">${type}</span>` : '';

                // Rating badge
                const ratingBadge = rating ? `<div class="mf-card-rating"><svg class="mf-card-star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg><span>${rating}</span></div>` : '';

                // Verified badge
                const verifiedBadge = verified ? `<div class="mf-card-verified"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>` : '';

                return `
                    <div class="mf-card">
                        ${imageHtml}
                        <div class="mf-card-content">
                            <div class="mf-card-header">
                                <div class="mf-card-badges">
                                    ${typeBadge}
                                    ${ratingBadge}
                                </div>
                                ${verifiedBadge}
                            </div>
                            <h3 class="mf-card-name">${name}</h3>
                            <div class="mf-card-address">
                                <svg class="mf-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>${address}</span>
                            </div>
                            <div class="mf-card-actions">
                                <a class="mf-card-btn mf-card-btn--primary" href="${detailUrl}">
                                    <svg class="mf-card-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Batafsil
                                </a>
                                <a class="mf-card-btn" href="${gmaps}" target="_blank" rel="noopener">
                                    <svg class="mf-card-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Yo‘nalish
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            },

            _detectUserLocation(forceCenter) {
                if (!navigator.geolocation) return;

                this.locating = true;
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.locating = false;
                        const latitude = pos.coords.latitude;
                        const longitude = pos.coords.longitude;

                        this._setSelectedLocation(latitude, longitude, forceCenter);
                    },
                    () => {
                        this.locating = false;
                        // Permission denied or failure: keep default location
                        if (forceCenter && this._map) {
                            this._map.flyTo([41.3775, 64.5853], 6, { duration: 0.6 });
                        }
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 300000 }
                );
            },

            _setSelectedLocation(lat, lng, fly) {
                this.lat = lat;
                this.lng = lng;
                this.addressText = lat.toFixed(5) + ', ' + lng.toFixed(5);

                if (this._map) {
                    if (this._selectedMarker) {
                        this._map.removeLayer(this._selectedMarker);
                    }

                    this._selectedMarker = L.marker([lat, lng], { icon: this._userIcon() })
                        .bindPopup(`
                            <div class="mf-selected-popup">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                                    <div style="width:32px;height:32px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <div class="mf-selected-popup-title">Tanlangan joylashuv</div>
                                        <div class="mf-selected-popup-coords">${lat.toFixed(5)}, ${lng.toFixed(5)}</div>
                                    </div>
                                </div>
                                <div style="padding-top:8px;border-top:1px solid #e5e7eb;font-size:12px;color:#6b7280;">
                                    Radius: ${this.radius} km
                                </div>
                            </div>
                        `, {
                            closeButton: false,
                            className: 'mf-popup mf-popup--user'
                        })
                        .addTo(this._map);

                    if (fly) {
                        this._map.flyTo([lat, lng], 13, { duration: 0.65 });
                        this._selectedMarker.openPopup();
                    }
                }

                this._updateURL();
            },

            _updateURL() {
                const url = new URL(window.location);
                if (Number.isFinite(this.lat)) url.searchParams.set('latitude', this.lat);
                if (Number.isFinite(this.lng)) url.searchParams.set('longitude', this.lng);
                if (Number.isFinite(this.radius)) url.searchParams.set('radius', this.radius);
                window.history.replaceState({}, '', url);
            },

            onRadiusChange() {
                this._updateURL();
                // IMPORTANT: no auto-AJAX here. User must click "Qidirish".
            }
        };
    };
});

/* module-level haversine for filter closure */
function _haversine(lat1, lon1, lat2, lon2) {
    var R = 6371,
        dLat = (lat2 - lat1) * Math.PI / 180,
        dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}
