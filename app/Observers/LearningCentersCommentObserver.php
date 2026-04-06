<?php

namespace App\Observers;

use App\Models\LearningCentersComment;
use App\Services\ActivityService;

class LearningCentersCommentObserver
{
    /**
     * Handle the LearningCentersComment "created" event.
     */
    public function created(LearningCentersComment $comment): void
    {
        ActivityService::logCommentAdded($comment);
    }

    /**
     * Handle the LearningCentersComment "updated" event.
     */
    public function updated(LearningCentersComment $comment): void
    {
        // Only log if content changed
        if ($comment->wasChanged('comment')) {
            ActivityService::log(
                user: $comment->user,
                type: 'comment_updated',
                title: "Izoh yangilandi",
                description: "Foydalanuvchi izohni yangiladi",
                subject: $comment,
                metadata: [
                    'center_id' => $comment->learning_center_id,
                ]
            );
        }
    }

    /**
     * Handle the LearningCentersComment "deleted" event.
     */
    public function deleted(LearningCentersComment $comment): void
    {
        ActivityService::log(
            user: auth()->user(),
            type: 'comment_deleted',
            title: "Izoh o'chirildi",
            description: "Izoh o'chirildi",
            subject: $comment,
            metadata: [
                'center_id' => $comment->learning_center_id,
            ]
        );
    }
}
