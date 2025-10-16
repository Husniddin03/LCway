<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['usersId', 'learning_center_id', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_center_id');
    }
}
