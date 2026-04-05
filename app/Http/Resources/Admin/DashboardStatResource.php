<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'users' => [
                'total' => $this['users']['total'] ?? 0,
                'active' => $this['users']['active'] ?? 0,
                'inactive' => $this['users']['inactive'] ?? 0,
                'new_today' => $this['users']['new_today'] ?? 0,
                'new_this_week' => $this['users']['new_this_week'] ?? 0,
            ],
            'learning_centers' => [
                'total' => $this['learning_centers']['total'] ?? 0,
                'verified' => $this['learning_centers']['verified'] ?? 0,
                'pending' => $this['learning_centers']['pending'] ?? 0,
                'premium' => $this['learning_centers']['premium'] ?? 0,
            ],
            'teachers' => [
                'total' => $this['teachers']['total'] ?? 0,
            ],
            'subjects' => [
                'total' => $this['subjects']['total'] ?? 0,
            ],
            'comments' => [
                'total' => $this['comments']['total'] ?? 0,
                'pending' => $this['comments']['pending'] ?? 0,
            ],
            'ai_chats' => [
                'total' => $this['ai_chats']['total'] ?? 0,
                'today' => $this['ai_chats']['today'] ?? 0,
            ],
            'riasec_tests' => [
                'total' => $this['riasec_tests']['total'] ?? 0,
                'today' => $this['riasec_tests']['today'] ?? 0,
            ],
        ];
    }
}
