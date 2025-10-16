<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo', 'name', 'type', 'about', 'province', 'region',
        'address', 'location', 'users_id', 'student_count'
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
}
