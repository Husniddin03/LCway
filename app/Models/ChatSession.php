<?php
// app/Models/ChatSession.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['user_id', 'title', 'status', 'message_count'];

    const MAX_MESSAGES = 15; // Bitta sessiondagi maksimal xabar soni

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(AiChat::class, 'session_id')->orderBy('created_at');
    }

    public function lastMessage()
    {
        return $this->hasOne(AiChat::class, 'session_id')->latestOfMany();
    }

    public function isFull(): bool
    {
        return $this->message_count >= self::MAX_MESSAGES;
    }
}