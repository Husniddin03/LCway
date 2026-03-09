<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiasecResult extends Model
{
    protected $fillable = [
        'user_id',
        'r_score', 'i_score', 'a_score',
        's_score', 'e_score', 'c_score',
        'ai_recommendation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}