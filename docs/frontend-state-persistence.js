/**
 * FRONTEND STATE PERSISTENCE FOR GEO FILTERS
 * 
 * Problem: When user clicks browser "back", latitude/longitude state is lost
 * causing the HY093 error (missing parameters).
 * 
 * Solutions: Store state in URL params, localStorage, or sessionStorage
 */

// =============================================================================
// SOLUTION 1: URL QUERY PARAMETERS (RECOMMENDED)
// =============================================================================
// Pros: Shareable URLs, survives back button, bookmarkable
// Cons: Visible in address bar, limited storage (~2000 chars)

class GeoFilterStateManager {
    constructor() {
        // Initialize from URL on page load
        this.restoreFromUrl();
    }

    /**
     * Save geo filter state to URL
     */
    saveToUrl(lat, lng, radius) {
        const url = new URL(window.location);
        
        if (this.isValidCoordinate(lat, lng)) {
            url.searchParams.set('latitude', lat);
            url.searchParams.set('longitude', lng);
            if (radius) url.searchParams.set('radius', radius);
        } else {
            url.searchParams.delete('latitude');
            url.searchParams.delete('longitude');
            url.searchParams.delete('radius');
        }
        
        // Update URL without page reload
        window.history.replaceState({}, '', url);
    }

    /**
     * Restore state from URL on page load
     */
    restoreFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const lat = params.get('latitude');
        const lng = params.get('longitude');
        const radius = params.get('radius');

        if (this.isValidCoordinate(lat, lng)) {
            // Set your form inputs or Alpine state here
            this.updateFormValues(lat, lng, radius);
            
            // Trigger search if coordinates present
            this.performSearch({
                latitude: parseFloat(lat),
                longitude: parseFloat(lng),
                radius: radius ? parseInt(radius) : null
            });
        }
    }

    isValidCoordinate(lat, lng) {
        return lat !== null && lng !== null 
            && !isNaN(parseFloat(lat)) 
            && !isNaN(parseFloat(lng));
    }

    updateFormValues(lat, lng, radius) {
        // Update your DOM elements
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const radiusInput = document.getElementById('radius');
        
        if (latInput) latInput.value = lat;
        if (lngInput) lngInput.value = lng;
        if (radiusInput && radius) radiusInput.value = radius;
        
        // If using Alpine.js
        if (window.Alpine) {
            // Dispatch custom event to update Alpine state
            window.dispatchEvent(new CustomEvent('geo-state-restored', {
                detail: { lat: parseFloat(lat), lng: parseFloat(lng), radius: radius ? parseInt(radius) : 5 }
            }));
        }
    }

    performSearch(filters) {
        // Your existing search implementation
        if (typeof performSearch === 'function') {
            performSearch();
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    window.geoStateManager = new GeoFilterStateManager();
});


// =============================================================================
// SOLUTION 2: LOCALSTORAGE (BACKUP FOR NON-URL STATE)
// =============================================================================
// Pros: Larger storage (~5MB), not visible in URL
// Cons: Not shareable, cleared on browser data clear

class LocalStorageGeoState {
    static STORAGE_KEY = 'geoFilterState';
    static EXPIRY_MINUTES = 60;

    static save(lat, lng, radius) {
        const data = {
            latitude: lat,
            longitude: lng,
            radius: radius,
            timestamp: Date.now()
        };
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(data));
    }

    static load() {
        try {
            const data = JSON.parse(localStorage.getItem(this.STORAGE_KEY));
            
            // Check expiry
            if (data && Date.now() - data.timestamp < this.EXPIRY_MINUTES * 60000) {
                return {
                    latitude: parseFloat(data.latitude),
                    longitude: parseFloat(data.longitude),
                    radius: data.radius ? parseInt(data.radius) : null
                };
            }
        } catch (e) {
            // Invalid JSON or missing data
        }
        return null;
    }

    static clear() {
        localStorage.removeItem(this.STORAGE_KEY);
    }
}

// =============================================================================
// SOLUTION 3: HYBRID APPROACH (RECOMMENDED FOR PRODUCTION)
// =============================================================================
// Use URL for coordinates (shareable) + localStorage for UI state

class HybridGeoStateManager {
    constructor() {
        this.restoreState();
    }

    /**
     * Save all filter state
     */
    save(lat, lng, radius, additionalFilters = {}) {
        // 1. Save coordinates to URL (shareable)
        const url = new URL(window.location);
        if (lat !== null && lng !== null) {
            url.searchParams.set('latitude', lat);
            url.searchParams.set('longitude', lng);
            if (radius) url.searchParams.set('radius', radius);
        }
        window.history.replaceState({}, '', url);

        // 2. Save UI state to localStorage
        localStorage.setItem('geoFilterUI', JSON.stringify({
            isPanelOpen: additionalFilters.isPanelOpen || false,
            selectedAddress: additionalFilters.address || null,
            timestamp: Date.now()
        }));
    }

    /**
     * Restore state from both sources
     */
    restoreState() {
        // 1. Try URL first (coordinates)
        const urlParams = new URLSearchParams(window.location.search);
        let lat = urlParams.get('latitude');
        let lng = urlParams.get('longitude');
        let radius = urlParams.get('radius');

        // 2. If not in URL, try localStorage
        if (!lat || !lng) {
            const stored = LocalStorageGeoState.load();
            if (stored) {
                lat = stored.latitude;
                lng = stored.longitude;
                radius = stored.radius;
                
                // Sync back to URL for future back button
                this.save(lat, lng, radius);
            }
        }

        // 3. Restore UI state from localStorage
        const uiState = JSON.parse(localStorage.getItem('geoFilterUI') || '{}');
        
        // 4. Apply to your component
        if (lat && lng) {
            this.applyToComponent({
                latitude: parseFloat(lat),
                longitude: parseFloat(lng),
                radius: radius ? parseInt(radius) : 5,
                isPanelOpen: uiState.isPanelOpen || false,
                address: uiState.selectedAddress || null
            });
        }
    }

    applyToComponent(state) {
        // Update Alpine.js component
        const alpineEl = document.querySelector('[x-data="mapFilterComp()"]');
        if (alpineEl && alpineEl._x_dataStack) {
            const component = alpineEl._x_dataStack[0];
            component.lat = state.latitude;
            component.lng = state.longitude;
            component.radius = state.radius;
            if (state.address) component.addressText = state.address;
            if (state.isPanelOpen) component.isPanelOpen = true;
        }

        // Trigger search
        if (typeof performSearch === 'function') {
            performSearch();
        }
    }
}


// =============================================================================
// SOLUTION 4: BFCACHE DETECTION (FOR BACK BUTTON ISSUES)
// =============================================================================
// Detect when page is restored from back-forward cache

window.addEventListener('pageshow', (event) => {
    // If persisted is true, page loaded from bfcache
    if (event.persisted) {
        console.log('Page restored from back-forward cache');
        
        // Re-initialize geo state
        if (window.geoStateManager) {
            window.geoStateManager.restoreState();
        }
    }
});


// =============================================================================
// ALPINE.JS INTEGRATION EXAMPLE
// =============================================================================

document.addEventListener('alpine:init', () => {
    Alpine.data('mapFilterComp', () => ({
        lat: null,
        lng: null,
        radius: 5,
        addressText: 'Xaritada joylashuvni tanlang',
        isPanelOpen: false,

        init() {
            // Listen for state restoration
            window.addEventListener('geo-state-restored', (e) => {
                this.lat = e.detail.lat;
                this.lng = e.detail.lng;
                this.radius = e.detail.radius;
                this.addressText = `${e.detail.lat.toFixed(5)}, ${e.detail.lng.toFixed(5)}`;
            });

            // Restore from URL on init
            this.restoreFromUrl();
        },

        restoreFromUrl() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('latitude') && params.has('longitude')) {
                this.lat = parseFloat(params.get('latitude'));
                this.lng = parseFloat(params.get('longitude'));
                this.radius = parseInt(params.get('radius') || '5');
                this.addressText = `${this.lat.toFixed(5)}, ${this.lng.toFixed(5)}`;
            }
        },

        saveToUrl() {
            if (this.lat !== null && this.lng !== null) {
                const url = new URL(window.location);
                url.searchParams.set('latitude', this.lat);
                url.searchParams.set('longitude', this.lng);
                url.searchParams.set('radius', this.radius);
                window.history.replaceState({}, '', url);
                
                // Also save to localStorage as backup
                LocalStorageGeoState.save(this.lat, this.lng, this.radius);
            }
        },

        applyFilter() {
            this.saveToUrl();
            if (typeof performSearch === 'function') {
                performSearch();
            }
        }
    }));
});


// =============================================================================
// EXAMPLE: SAFE AJAX SEARCH WITH STATE
// =============================================================================

async function performSearch() {
    const params = new URLSearchParams(window.location.search);
    
    // Get filters from URL
    const filters = {
        searchText: document.getElementById('searchText')?.value || '',
        latitude: params.get('latitude'),
        longitude: params.get('longitude'),
        radius: params.get('radius'),
        page: 1
    };

    // Validate before sending
    if (filters.latitude && filters.longitude) {
        const lat = parseFloat(filters.latitude);
        const lng = parseFloat(filters.longitude);
        
        // Skip geo filter if invalid
        if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
            filters.latitude = null;
            filters.longitude = null;
            filters.radius = null;
        }
    }

    try {
        const response = await fetch('/centers?' + new URLSearchParams(filters), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        if (!response.ok) throw new Error('Search failed');
        
        const data = await response.json();
        updateResults(data);
    } catch (error) {
        console.error('Search error:', error);
        // Clear invalid geo state
        LocalStorageGeoState.clear();
    }
}
