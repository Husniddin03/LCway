<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name'];

    public function centers()
    {
        return $this->hasMany(SubjectsOfLearningCenter::class, 'subject_id');
    }

    public function needTeachers()
    {
        return $this->hasMany(NeedTeacher::class, 'subject_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'subject_id');
    }
}
