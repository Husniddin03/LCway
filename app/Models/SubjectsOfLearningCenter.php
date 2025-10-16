<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectsOfLearningCenter extends Model
{
    use HasFactory;

    protected $table = 'subjects_of_learning_centers';

    protected $fillable = ['learning_centers_id', 'subject_id', 'price'];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
