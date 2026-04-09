/**
 * AJAX Usage Examples for SearchService
 * 
 * This file demonstrates how to use the SearchService with AJAX requests
 * for infinite scroll, map updates, and dynamic filtering.
 * 
 * Place this code in your JavaScript file or use as reference.
 */

// =============================================================================
// 1. INFINITE SCROLL IMPLEMENTATION
// =============================================================================

class CenterSearchManager {
    constructor() {
        this.currentPage = 1;
        this.isLoading = false;
        this.hasMore = true;
        this.filters = {};
        this.container = document.getElementById('centersGrid');
        this.mapInstance = null; // Your map instance
    }

    /**
     * Perform search with current filters
     * @param {Object} newFilters - Filter changes to apply
     * @param {boolean} resetPage - Reset to page 1 (for new searches)
     */
    async search(newFilters = {}, resetPage = true) {
        if (this.isLoading) return;

        // Merge new filters
        this.filters = { ...this.filters, ...newFilters };
        
        if (resetPage) {
            this.currentPage = 1;
            this.hasMore = true;
            this.container.innerHTML = ''; // Clear for new search
        }

        this.isLoading = true;
        this.showLoadingState();

        try {
            const response = await fetch('/centers?' + this.buildQueryString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                // Add credentials if using authentication
                credentials: 'same-origin',
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.success) {
                this.handleSuccess(data, resetPage);
            } else {
                this.handleError(new Error('Server returned unsuccessful response'));
            }
        } catch (error) {
            this.handleError(error);
        } finally {
            this.isLoading = false;
            this.hideLoadingState();
        }
    }

    /**
     * Load next page (infinite scroll)
     */
    async loadMore() {
        if (!this.hasMore || this.isLoading) return;
        
        this.currentPage++;
        await this.search({}, false);
    }

    /**
     * Build query string from filters
     */
    buildQueryString() {
        const params = new URLSearchParams();
        
        // Add all non-empty filters
        Object.entries(this.filters).forEach(([key, value]) => {
            if (value !== null && value !== undefined && value !== '') {
                params.append(key, value);
            }
        });
        
        // Always add page
        params.append('page', this.currentPage);
        
        return params.toString();
    }

    /**
     * Handle successful response
     */
    handleSuccess(data, isNewSearch) {
        // Update pagination state
        this.hasMore = data.pagination?.has_more_pages ?? false;

        // Append or replace HTML
        if (isNewSearch) {
            this.container.innerHTML = data.html;
        } else {
            // Append for infinite scroll
            const temp = document.createElement('div');
            temp.innerHTML = data.html;
            
            // Append new items (skip container wrappers)
            while (temp.firstElementChild) {
                this.container.appendChild(temp.firstElementChild);
            }
        }

        // Update map markers
        this.updateMapMarkers(data.centers);

        // Update result count display
        this.updateResultCount(data.pagination?.total ?? 0);
    }

    /**
     * Update map markers with new data
     */
    updateMapMarkers(centers) {
        if (!this.mapInstance || !centers) return;

        // Clear existing markers
        this.mapInstance.clearMarkers?.();

        // Add new markers
        centers.forEach(center => {
            if (center.lat && center.lng) {
                this.mapInstance.addMarker({
                    id: center.id,
                    lat: center.lat,
                    lng: center.lng,
                    title: center.name,
                    address: center.address,
                    image: center.image,
                    url: center.detail_url,
                });
            }
        });
    }

    /**
     * Update result count in UI
     */
    updateResultCount(total) {
        const countElement = document.getElementById('resultCount');
        if (countElement) {
            countElement.textContent = `${total} ta o'quv markazi topildi`;
        }
    }

    /**
     * Show loading state
     */
    showLoadingState() {
        document.getElementById('searchBtn')?.classList.add('loading');
        document.getElementById('loadingSpinner')?.classList.remove('hidden');
    }

    /**
     * Hide loading state
     */
    hideLoadingState() {
        document.getElementById('searchBtn')?.classList.remove('loading');
        document.getElementById('loadingSpinner')?.classList.add('hidden');
    }

    /**
     * Handle errors
     */
    handleError(error) {
        console.error('Search error:', error);
        // Optionally show user-friendly error message
    }
}

// =============================================================================
// 2. USAGE EXAMPLES
// =============================================================================

// Initialize search manager
const searchManager = new CenterSearchManager();

// Example 1: Text search
document.getElementById('searchText')?.addEventListener('input', debounce((e) => {
    searchManager.search({ searchText: e.target.value }, true);
}, 300));

// Example 2: Type filter
document.getElementById('typeFilter')?.addEventListener('change', (e) => {
    searchManager.search({ type: e.target.value }, true);
});

// Example 3: Subject filter
document.getElementById('subjectFilter')?.addEventListener('change', (e) => {
    searchManager.search({ subject_name: e.target.value }, true);
});

// Example 4: Price range filter
function applyPriceFilter(min, max) {
    searchManager.search({ min_price: min, max_price: max }, true);
}

// Example 5: Geo search with radius
function searchByLocation(lat, lng, radius = 10) {
    searchManager.search({
        latitude: lat,
        longitude: lng,
        radius: radius
    }, true);
}

// Example 6: Sorting
function changeSort(sortField, order = 'asc') {
    searchManager.search({
        sort: sortField,      // 'name', 'distance', 'favorites', 'rating', 'created'
        order: order,         // 'asc', 'desc'
        // Legacy support for old sort parameters
        [sortField]: order,
    }, true);
}

// Example 7: Clear all filters
function clearAllFilters() {
    searchManager.filters = {};
    document.getElementById('searchForm')?.reset();
    searchManager.search({}, true);
}

// Example 8: Infinite scroll setup
function setupInfiniteScroll() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !searchManager.isLoading) {
                searchManager.loadMore();
            }
        });
    }, { rootMargin: '100px' });

    // Observe sentinel element at bottom of list
    const sentinel = document.getElementById('scrollSentinel');
    if (sentinel) observer.observe(sentinel);
}

// =============================================================================
// 3. UTILITY FUNCTIONS
// =============================================================================

/**
 * Debounce function for search inputs
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function for scroll events
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// =============================================================================
// 4. EXAMPLE FILTER UI INTEGRATION
// =============================================================================

/**
 * Map filter integration example
 */
function setupMapFilter() {
    // Get user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                searchByLocation(
                    position.coords.latitude,
                    position.coords.longitude,
                    5 // 5km radius
                );
            },
            (error) => {
                console.warn('Geolocation error:', error);
                // Fallback to default location (Tashkent)
                searchByLocation(41.2995, 69.2401, 10);
            }
        );
    }
}

/**
 * Example: Preserve filters in URL for shareable searches
 */
function updateUrlWithFilters(filters) {
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([key, value]) => {
        if (value) params.set(key, value);
    });
    
    window.history.replaceState(
        {}, 
        '', 
        `${window.location.pathname}?${params.toString()}`
    );
}

/**
 * Example: Load filters from URL on page load
 */
function loadFiltersFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const filters = {};
    
    params.forEach((value, key) => {
        filters[key] = value;
    });
    
    return filters;
}

// =============================================================================
// 5. ADVANCED: CUSTOM JSON ENDPOINT (if you need raw data)
// =============================================================================

/**
 * Example API controller method for raw JSON:
 * 
 * // Add to routes/api.php
 * Route::get('/centers/search', [SearchController::class, 'search']);
 * 
 * // SearchController.php
 * class SearchController extends Controller
 * {
 *     public function search(Request $request, SearchService $service)
 *     {
 *         $validated = $request->validate([
 *             'searchText' => 'nullable|string',
 *             'type' => 'nullable|string',
 *             // ... other filters
 *         ]);
 * 
 *         $results = $service->search($validated);
 * 
 *         return response()->json([
 *             'data' => $results->items(),
 *             'meta' => [
 *                 'current_page' => $results->currentPage(),
 *                 'last_page' => $results->lastPage(),
 *                 'per_page' => $results->perPage(),
 *                 'total' => $results->total(),
 *             ]
 *         ]);
 *     }
 * }
 */

// =============================================================================
// 6. PERFORMANCE NOTES
// =============================================================================

/**
 * Best practices for production:
 * 
 * 1. DEBOUNCE text inputs (300ms recommended) - reduces server load
 * 2. ABORT previous requests - prevents race conditions
 * 3. CACHE results locally - use sessionStorage for back button support
 * 4. LAZY LOAD images - use loading="lazy" for off-screen images
 * 5. MINIMIZE DOM updates - use virtual scrolling for very long lists
 * 
 * Example abort controller usage:
 */
let currentAbortController = null;

async function searchWithAbort(filters) {
    // Abort previous request
    if (currentAbortController) {
        currentAbortController.abort();
    }
    
    currentAbortController = new AbortController();
    
    try {
        const response = await fetch('/centers?' + params, {
            signal: currentAbortController.signal,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        // ... handle response
    } catch (error) {
        if (error.name === 'AbortError') {
            // Request was cancelled, ignore
            return;
        }
        throw error;
    }
}
