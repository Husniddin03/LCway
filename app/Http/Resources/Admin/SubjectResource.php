<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'price' => $this->price,
            'duration' => $this->duration,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'learning_center' => $this->whenLoaded('learningCenter', function () {
                return [
                    'id' => $this->learningCenter->id,
                    'name' => $this->learningCenter->name,
                ];
            }),
            'teachers' => $this->whenLoaded('teachers', function () {
                return $this->teachers->map(fn ($teacher) => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                ]);
            }),
        ];
    }
}
