<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LearningCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'slug',
        'type',
        'about',
        'country',
        'province',
        'region',
        'address',
        'location',
        'status',
        'users_id',
        'student_count',
        'total_reyting',
        'rating',
        'ratings_total',
        'checked',
        'status',
        'premium',
        'premium_until',
        'tin',
        'legal_address',
        'territory',
        'license_number',
        'license_registration_date',
        'license_validity_period',
        'manager_name',
        'phone_number',
        'email',
        'ifut_code',
        'active'
    ];

    protected $casts = [
        'total_reyting' => 'float',
        'rating' => 'float',
        'premium' => 'boolean',
        'premium_until' => 'datetime',
        'license_registration_date' => 'date',
        'license_validity_period' => 'date',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function images()
    {
        return $this->hasMany(LearningCentersImage::class, 'learning_centers_id');
    }

    public function subjects()
    {
        return $this->hasMany(SubjectsOfLearningCenter::class, 'learning_centers_id');
    }

    public function comments()
    {
        return $this->hasMany(LearningCentersComment::class, 'learning_centers_id');
    }

    public function calendar()
    {
        return $this->hasMany(LearningCentersCalendar::class, 'learning_centers_id');
    }

    public function weekdays()
    {
        return $this->hasMany(LearningCentersCalendar::class, 'learning_centers_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'learning_centers_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'learning_centers_id');
    }

    // Markaz saqlanayotganda avtomatik slug yasash uchun
    public static function boot()
    {
        parent::boot();

        static::creating(function ($center) {
            if (empty($center->slug)) {
                $center->slug = static::generateUniqueSlug($center->name);
            } else {
                // Agar seederdan slug kelgan bo'lsa ham uning unikalligini tekshiramiz
                $center->slug = static::generateUniqueSlug($center->slug, true);
            }
        });
    }

    /**
     * Noyob slug generatsiya qilish
     */
    public static function generateUniqueSlug($name, $isAlreadySlug = false)
    {
        $slug = $isAlreadySlug ? $name : Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    // Laravel-ga ID o'rniga slug orqali qidirishni aytamiz
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Dynamic attribute for average user rating
    public function getUserAverageRatingAttribute()
    {
        if ($this->relationLoaded('favorites') && $this->favorites) {
            // If favorites are already loaded, use them
            return $this->favorites->avg('rating') ?? 0;
        } else {
            // Otherwise query the database
            return $this->favorites()->avg('rating') ?? 0;
        }
    }

    // Dynamic attribute for total user ratings count
    public function getUserRatingsTotalAttribute()
    {
        if ($this->relationLoaded('favorites') && $this->favorites) {
            // If favorites are already loaded, use them
            return $this->favorites->count();
        } else {
            // Otherwise query the database
            return $this->favorites()->count();
        }
    }

    // Dynamic attribute for calculated total_reyting
    public function getCalculatedTotalReytingAttribute()
    {
        $userAverage = $this->user_average_rating;
        $userCount = $this->user_ratings_total;

        if ($userCount == 0) {
            return $this->rating; // Return original Google rating if no user ratings
        }

        // Calculate weighted average: 50% Google rating, 50% user ratings
        if ($this->rating > 0) {
            return round(($this->rating + $userAverage) / 2, 2);
        } else {
            return round($userAverage, 2);
        }
    }

    public function connections()
    {
        return $this->hasMany(LearningCentersConnect::class, 'learning_centers_id');
    }

    /* ═══════════════════════════════════════════════
     |  MEILISEARCH — Index nomi
     ═══════════════════════════════════════════════ */


    public function searchableAs(): string
    {
        return 'learning_centers';
    }

    /* ═══════════════════════════════════════════════
     |  MEILISEARCH — Qaysi maydonlar indexlansin
     ═══════════════════════════════════════════════ */

    public function toSearchableArray(): array
    {
        // Relationlarni eager load qilish
        $this->loadMissing(['subjects', 'teachers']);

        // Fanlar ro'yxati (qidiruvda ishlashi uchun)
        $subjects = $this->subjects->map(function ($s) {
            return [
                'name' => $s->subject_name ?? '',
                'price' => (int) ($s->price ?? 0),
            ];
        })->toArray();

        // O'qituvchilar
        $teachers = $this->teachers->map(function ($t) {
            return [
                'name' => $t->name ?? '',
                'subject' => $t->subject_name ?? '',
            ];
        })->toArray();

        // Qidiruv uchun birlashtirilgan matnlar
        $subjectsText = $this->subjects->map(function ($s) {
            return $s->subject_name;
        })->filter()->join(', ');

        $teachersText = $this->teachers->map(function ($t) {
            return $t->name;
        })->filter()->join(', ');

        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'type' => $this->type ?? '',
            'about' => $this->about ?? '',
            'province' => $this->province ?? '',
            'region' => $this->region ?? '',
            'address' => $this->address ?? '',
            'student_count' => (int) ($this->student_count ?? 0),
            'location' => $this->location ?? '',

            // Qidiruv uchun birlashtirilgan matn
            'subjects_text' => $subjectsText,
            'teachers_text' => $teachersText,
            'full_address' => trim(($this->province ?? '') . ' ' . ($this->region ?? '') . ' ' . ($this->address ?? '')),

            // Filterlash uchun
            'subjects' => $subjects,
            'teachers' => $teachers,
            'min_price' => $this->subjects->min('price') ?? 0,
            'max_price' => $this->subjects->max('price') ?? 0,

            // Timestamp (sort uchun)
            'created_at_ts' => $this->created_at?->timestamp ?? 0,
        ];
    }


}
