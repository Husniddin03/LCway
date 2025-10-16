<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = ['users_id', 'learning_centers_id', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }
}
