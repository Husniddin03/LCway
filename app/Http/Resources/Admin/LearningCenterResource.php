<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'telegram' => $this->telegram,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'checked' => $this->checked,
            'premium' => $this->premium,
            'premium_until' => $this->premium_until?->toDateTimeString(),
            'views' => $this->views,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'subjects' => $this->whenLoaded('subjects', function () {
                return $this->subjects->map(fn ($subject) => [
                    'id' => $subject->id,
                    'name' => $subject->name,
                ]);
            }),
            'teachers' => $this->whenLoaded('teachers', function () {
                return $this->teachers->map(fn ($teacher) => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ]);
            }),
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(fn ($image) => [
                    'id' => $image->id,
                    'url' => $image->image,
                ]);
            }),
            'comments_count' => $this->whenCounted('comments'),
        ];
    }
}
