<?php

namespace App\Observers;

use App\Models\User;
use App\Services\ActivityService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityService::logUserCreated($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Log when user profile is updated
        if ($user->wasChanged('name') || $user->wasChanged('email')) {
            Activity::log(
                user: auth()->user(),
                type: 'user_updated',
                title: "Foydalanuvchi yangilandi: {$user->name}",
                description: "Foydalanuvchi ma'lumotlari yangilandi",
                subject: $user,
                metadata: [
                    'changes' => $user->getChanges(),
                ]
            );
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Activity::log(
            user: auth()->user(),
            type: 'user_deleted',
            title: "Foydalanuvchi o'chirildi: {$user->name}",
            description: "Foydalanuvchi o'chirildi",
            subject: $user,
        );
    }
}
