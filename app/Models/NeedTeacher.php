<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeedTeacher extends Model
{
    use HasFactory;
    protected $table = 'need_teacher';

    protected $fillable = ['learning_center_id', 'subject_name', 'subject_type', 'description'];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_center_id');
    }
}
