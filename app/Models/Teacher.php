<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $table = 'teachers';
    protected $fillable = [
        'name',
        'about',
        'photo',
        'phone',
        'learning_centers_id',
    ];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class, 'teacher_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectsOfLearningCenter::class, 'teacher_subjects', 'teacher_id', 'subject_id');
    }

    public function getCenterSubjects() {
        return $this->learningCenter->subjects();
    }
}
