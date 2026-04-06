<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityService
{
    /**
     * Log user registration activity
     */
    public static function logUserCreated(User $user): Activity
    {
        return Activity::log(
            type: 'user_created',
            title: 'Yangi foydalanuvchi',
            description: $user->name,
            subject: $user,
            userId: $user->id,
            metadata: [
                'email' => $user->email,
                'role' => $user->role,
            ]
        );
    }

    /**
     * Log learning center creation
     */
    public static function logCenterCreated(LearningCenter $center): Activity
    {
        return Activity::log(
            type: 'center_created',
            title: "Yangi o'quv markazi",
            description: $center->name,
            subject: $center,
            userId: $center->user_id,
            metadata: [
                'center_name' => $center->name,
                'location' => $center->address,
            ]
        );
    }

    /**
     * Log teacher creation
     */
    public static function logTeacherAdded(Teacher $teacher): Activity
    {
        return Activity::log(
            type: 'teacher_added',
            title: "Yangi o'qituvchi",
            description: $teacher->full_name,
            subject: $teacher,
            metadata: [
                'teacher_name' => $teacher->full_name,
            ]
        );
    }

    /**
     * Log comment creation
     */
    public static function logCommentAdded(LearningCentersComment $comment): Activity
    {
        return Activity::log(
            type: 'comment_added',
            title: 'Yangi izoh',
            description: substr($comment->comment, 0, 50) . '...',
            subject: $comment,
            userId: $comment->user_id,
            metadata: [
                'rating' => $comment->rating,
            ]
        );
    }

    /**
     * Log generic activity
     */
    public static function log(
        string $type,
        string $title,
        ?string $description = null,
        ?Model $subject = null,
        ?int $userId = null,
        ?array $metadata = null
    ): Activity {
        return Activity::log($type, $title, $description, $subject, $userId, $metadata);
    }

    /**
     * Get contribution data formatted for heatmap
     */
    public static function getContributionDataForYear(int $year): array
    {
        $activityCounts = Activity::getContributionData($year);
        
        $data = [];
        $startDate = \Carbon\Carbon::create($year, 1, 1);
        $endDate = \Carbon\Carbon::create($year, 12, 31);
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $data[] = [
                'date' => $dateStr,
                'count' => $activityCounts[$dateStr] ?? 0,
            ];
            $currentDate->addDay();
        }
        
        return $data;
    }
}
