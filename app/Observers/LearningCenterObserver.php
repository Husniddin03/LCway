<?php

namespace App\Observers;

use App\Models\LearningCenter;
use App\Services\ActivityService;

class LearningCenterObserver
{
    /**
     * Handle the LearningCenter "created" event.
     */
    public function created(LearningCenter $learningCenter): void
    {
        ActivityService::logCenterCreated($learningCenter);
    }

    /**
     * Handle the LearningCenter "updated" event.
     */
    public function updated(LearningCenter $learningCenter): void
    {
        ActivityService::log(
            user: auth()->user(),
            type: 'center_updated',
            title: "Markaz yangilandi: {$learningCenter->name}",
            description: "O'quv markazi ma'lumotlari yangilandi",
            subject: $learningCenter,
            metadata: [
                'changes' => $learningCenter->getChanges(),
            ]
        );
    }

    /**
     * Handle the LearningCenter "deleted" event.
     */
    public function deleted(LearningCenter $learningCenter): void
    {
        ActivityService::log(
            user: auth()->user(),
            type: 'center_deleted',
            title: "Markaz o'chirildi: {$learningCenter->name}",
            description: "O'quv markazi o'chirildi",
            subject: $learningCenter,
        );
    }
}
