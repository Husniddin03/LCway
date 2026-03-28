<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo', 'name', 'type', 'about', 'country', 'province', 'region',
        'address', 'location', 'status', 'users_id', 
        'student_count', 'total_reyting', 'rating', 'ratings_total',
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

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'learning_centers_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'learning_centers_id');
    }

    public function connections()
    {
        return $this->hasMany(LearningCentersConnect::class, 'learning_centers_id');
    }

    public function needTeachers()
    {
        return $this->hasMany(NeedTeacher::class, 'learning_center_id');
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
        $this->loadMissing(['subjects.subject', 'teachers']);

        // Fanlar ro'yxati (qidiruvda ishlashi uchun)
        $subjects = $this->subjects->map(function ($s) {
            return [
                'name'  => $s->subject?->name ?? '',
                'price' => (int) ($s->price ?? 0),
            ];
        })->toArray();

        // O'qituvchilar
        $teachers = $this->teachers->map(function ($t) {
            return [
                'name'    => $t->name ?? '',
                'subject' => $t->subject?->name ?? '',
            ];
        })->toArray();

        // Qidiruv uchun birlashtirilgan matnlar
        $subjectsText = $this->subjects->map(function ($s) {
            return $s->subject?->name;
        })->filter()->join(', ');
        
        $teachersText = $this->teachers->map(function ($t) {
            return $t->name;
        })->filter()->join(', ');

        return [
            'id'            => $this->id,
            'name'          => $this->name ?? '',
            'type'          => $this->type ?? '',
            'about'         => $this->about ?? '',
            'province'      => $this->province ?? '',
            'region'        => $this->region ?? '',
            'address'       => $this->address ?? '',
            'student_count' => (int) ($this->student_count ?? 0),
            'location'      => $this->location ?? '',

            // Qidiruv uchun birlashtirilgan matn
            'subjects_text' => $subjectsText,
            'teachers_text' => $teachersText,
            'full_address'  => trim(($this->province ?? '') . ' ' . ($this->region ?? '') . ' ' . ($this->address ?? '')),

            // Filterlash uchun
            'subjects'      => $subjects,
            'teachers'      => $teachers,
            'min_price'     => $this->subjects->min('price') ?? 0,
            'max_price'     => $this->subjects->max('price') ?? 0,

            // Timestamp (sort uchun)
            'created_at_ts' => $this->created_at?->timestamp ?? 0,
        ];
    }


}
