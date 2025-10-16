<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCentersComment extends Model
{
    use HasFactory;

    protected $fillable = ['learning_centers_id', 'users_id', 'comment'];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
