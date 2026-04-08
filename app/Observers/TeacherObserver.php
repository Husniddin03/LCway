<?php

namespace App\Observers;

use App\Models\Teacher;
use App\Services\ActivityService;

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     */
    public function created(Teacher $teacher): void
    {
        ActivityService::logTeacherAdded($teacher);
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updated(Teacher $teacher): void
    {
        ActivityService::log(
            userId: auth()->id(),
            type: 'teacher_updated',
            title: "O'qituvchi yangilandi: {$teacher->name}",
            description: "O'qituvchi ma'lumotlari yangilandi",
            subject: $teacher,
            metadata: [
                'changes' => $teacher->getChanges(),
            ]
        );
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        ActivityService::log(
            userId: auth()->id(),
            type: 'teacher_deleted',
            title: "O'qituvchi o'chirildi: {$teacher->name}",
            description: "O'qituvchi o'chirildi",
            subject: $teacher,
        );
    }
}
