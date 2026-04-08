<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use Livewire\Component;

class Map extends Component
{
    public string $search = '';
    public string $province = '';
    public int $perPage = 100;

    public function updatingSearch(): void
    {
        $this->dispatch('centersUpdated', $this->getCentersData());
    }

    public function updatingProvince(): void
    {
        $this->dispatch('centersUpdated', $this->getCentersData());
    }

    public function getCentersData(): array
    {
        $query = LearningCenter::query()
            ->whereNotNull('location')
            ->where('location', '!=', '');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->province) {
            $query->where('province', $this->province);
        }

        $centers = $query->select('id', 'name', 'location', 'address', 'province', 'region', 'type', 'phone_number')
                         ->limit($this->perPage)
                         ->get();

        return $centers->map(function ($center) {
            $coords = explode(',', $center->location);
            return [
                'id' => $center->id,
                'name' => $center->name,
                'lat' => isset($coords[0]) ? (float) trim($coords[0]) : null,
                'lng' => isset($coords[1]) ? (float) trim($coords[1]) : null,
                'address' => $center->address,
                'province' => $center->province,
                'region' => $center->region,
                'type' => $center->type,
                'phone' => $center->phone_number,
            ];
        })->filter(fn($c) => $c['lat'] && $c['lng'])->toArray();
    }

    /**
     * Get centers by map bounds and zoom level for dynamic loading
     * Returns limited results based on zoom level to maintain performance
     */
    public function getCentersByBounds(float $north, float $south, float $east, float $west, int $zoom): array
    {
        // Dynamic limit based on zoom level
        $limit = match (true) {
            $zoom < 8 => 100,
            $zoom < 11 => 300,
            $zoom < 14 => 1000,
            default => 2000,
        };

        $query = LearningCenter::query()
            ->whereNotNull('location')
            ->where('location', '!=', '');

        // Filter by map bounds using haversine formula approximation
        // We split location string and filter by lat/lng range
        $query->whereRaw(
            "CAST(SUBSTRING_INDEX(location, ',', 1) AS DECIMAL(10,6)) BETWEEN ? AND ?",
            [$south, $north]
        )->whereRaw(
            "CAST(SUBSTRING_INDEX(location, ',', -1) AS DECIMAL(10,6)) BETWEEN ? AND ?",
            [$west, $east]
        );

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        // Apply province filter
        if ($this->province) {
            $query->where('province', $this->province);
        }

        // Get centers with limit
        $centers = $query->select('id', 'name', 'location', 'address', 'province', 'region', 'type', 'phone_number')
                         ->limit($limit)
                         ->get();

        return $centers->map(function ($center) {
            $coords = explode(',', $center->location);
            return [
                'id' => $center->id,
                'name' => $center->name,
                'lat' => isset($coords[0]) ? (float) trim($coords[0]) : null,
                'lng' => isset($coords[1]) ? (float) trim($coords[1]) : null,
                'address' => $center->address,
                'province' => $center->province,
                'region' => $center->region,
                'type' => $center->type,
                'phone' => $center->phone_number,
            ];
        })->filter(fn($c) => $c['lat'] && $c['lng'])->values()->toArray();
    }

    public function mount(): void
    {
        //
    }

    public function render()
    {
        $centers = $this->getCentersData();

        // Get unique provinces for filter
        $provinces = LearningCenter::whereNotNull('province')
            ->distinct()
            ->pluck('province')
            ->sort()
            ->values();

        return view('livewire.admin.center.map', [
            'centers' => $centers,
            'provinces' => $provinces,
        ])->layout('layouts.admin.app', ['title' => 'Markazlar xaritada']);
    }
}
