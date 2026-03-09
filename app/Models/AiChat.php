<?php
// app/Models/AiChat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiChat extends Model
{
    protected $fillable = ['user_id', 'role', 'content', 'model'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}