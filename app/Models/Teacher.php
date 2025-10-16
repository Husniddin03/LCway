<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = [
        'name',
        'about',
        'photo',
        'phone',
        'subject_id',
        'learning_centers_id',
    ];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
