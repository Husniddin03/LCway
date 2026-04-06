<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'subject_type',
        'subject_id',
        'metadata',
        'activity_date',
    ];

    protected $casts = [
        'metadata' => 'array',
        'activity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Log a new activity
     */
    public static function log(
        string $type,
        string $title,
        ?string $description = null,
        ?Model $subject = null,
        ?int $userId = null,
        ?array $metadata = null
    ): self {
        $activity = new self([
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'user_id' => $userId ?? auth()->id(),
            'activity_date' => now()->toDateString(),
            'metadata' => $metadata,
        ]);

        if ($subject) {
            $activity->subject()->associate($subject);
        }

        $activity->save();

        return $activity;
    }

    /**
     * Get activity counts grouped by date for contribution graph
     */
    public static function getContributionData(int $year): array
    {
        return self::whereYear('activity_date', $year)
            ->selectRaw('activity_date as date, COUNT(*) as count')
            ->groupBy('activity_date')
            ->pluck('count', 'date')
            ->toArray();
    }
}
