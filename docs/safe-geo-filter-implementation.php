<?php

/**
 * SAFE HAVERSINE GEO FILTER IMPLEMENTATION
 * 
 * This file documents the production-safe geo filter implementation
 * that prevents the SQLSTATE[HY093] "Invalid parameter number" error.
 * 
 * LOCATION: app/Services/SearchService.php
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

/**
 * PRODUCTION-SAFE GEO FILTER
 * 
 * Key Safety Features:
 * 1. Strict numeric validation before SQL generation
 * 2. Explicit type casting (no implicit conversions)
 * 3. Exact placeholder-to-binding count (3 for select, 4 for where)
 * 4. NULL handling (skips geo filter if coordinates invalid)
 * 5. Coordinate range validation (lat: -90 to 90, lng: -180 to 180)
 */
class SafeGeoFilterExample
{
    private const EARTH_RADIUS_KM = 6371;

    /**
     * Main entry point for applying geo filter
     * 
     * @param Builder $query The query builder instance
     * @param float|null $lat Latitude value
     * @param float|null $lng Longitude value  
     * @param int|null $radius Optional radius in km
     * @return Builder
     */
    public function applyGeoFilter(Builder $query, ?float $lat, ?float $lng, ?int $radius = null): Builder
    {
        // STEP 1: Defensive validation
        if (!$this->isValidCoordinate($lat, $lng)) {
            return $query; // Return unchanged if invalid
        }

        // STEP 2: Safe type casting
        $lat = (float) $lat;
        $lng = (float) $lng;
        $radius = is_numeric($radius) ? (int) $radius : null;

        // STEP 3: Haversine SQL with EXACTLY 3 placeholders
        $haversineSql = "(
            " . self::EARTH_RADIUS_KM . " * acos(
                cos(radians(?))
                * cos(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
                * cos(radians(CAST(SUBSTRING_INDEX(location, ',', -1) AS DECIMAL(10,6))) - radians(?))
                + sin(radians(?))
                * sin(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
            )
        )";

        // STEP 4: Add distance column (3 bindings: lat, lng, lat)
        $query->selectRaw("{$haversineSql} AS distance", [$lat, $lng, $lat]);

        // STEP 5: Apply radius filter (4 bindings: lat, lng, lat, radius)
        if ($radius !== null && $radius > 0) {
            $query->whereRaw("{$haversineSql} <= ?", [$lat, $lng, $lat, $radius]);
        }

        // STEP 6: Exclude centers without location data
        $query->whereNotNull('location')
              ->where('location', '!=', '');

        return $query;
    }

    /**
     * Strict coordinate validation
     */
    private function isValidCoordinate($lat, $lng): bool
    {
        // Must be numeric
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return false;
        }

        $latFloat = (float) $lat;
        $lngFloat = (float) $lng;

        // Range validation
        if ($latFloat < -90 || $latFloat > 90) {
            return false;
        }
        if ($lngFloat < -180 || $lngFloat > 180) {
            return false;
        }

        // Must be finite (not NaN or INF)
        if (!is_finite($latFloat) || !is_finite($lngFloat)) {
            return false;
        }

        return true;
    }
}

// =============================================================================
// EXAMPLE USAGE IN CONTROLLER
// =============================================================================

/*
public function search(Request $request, SearchService $service)
{
    $validated = $request->validate([
        'searchText' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'radius' => 'nullable|integer|min:1|max:100',
    ]);

    // Safe extraction with null coalescing
    $results = $service->search([
        'searchText' => $validated['searchText'] ?? null,
        'latitude' => isset($validated['latitude']) ? (float) $validated['latitude'] : null,
        'longitude' => isset($validated['longitude']) ? (float) $validated['longitude'] : null,
        'radius' => isset($validated['radius']) ? (int) $validated['radius'] : null,
    ]);

    return response()->json($results);
}
*/

// =============================================================================
// BINDING COUNT REFERENCE
// =============================================================================

/*
HAUVERSINE FORMULA BREAKDOWN:

SQL: 6371 * acos(
    cos(radians(?))           <- Placeholder #1 (lat)
    * cos(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
    * cos(radians(CAST(SUBSTRING_INDEX(location, ',', -1) AS DECIMAL(10,6))) - radians(?))  <- Placeholder #2 (lng)
    + sin(radians(?))         <- Placeholder #3 (lat again)
    * sin(radians(CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6))))
)

BINDING COUNTS:
- selectRaw():  3 bindings [lat, lng, lat]
- whereRaw():   4 bindings [lat, lng, lat, radius]

If count doesn't match placeholders → HY093 error!
*/
