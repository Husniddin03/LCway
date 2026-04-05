<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'checked' => $this->checked,
            'phone' => $this->userData?->phone ?? null,
            'avatar' => $this->avatar,
            'google_id' => $this->google_id,
            'password_status' => $this->password_status,
            'last_login_at' => $this->last_login_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'centers_count' => $this->whenCounted('centers'),
            'ai_chats_count' => $this->whenCounted('aiChats'),
            'user_data' => $this->whenLoaded('userData', function () {
                return [
                    'phone' => $this->userData->phone,
                    'address' => $this->userData->address,
                    'bio' => $this->userData->bio,
                ];
            }),
        ];
    }
}
