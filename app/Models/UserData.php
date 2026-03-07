<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'gander',
        'birthday',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFormattedBirthdayAttribute(): string
    {
        return $this->birthday ? $this->birthday->format('d.m.Y') : '';
    }

    public function getGenderUzbekAttribute(): string
    {
        return match($this->gander) {
            'male' => 'Erkak',
            'female' => 'Ayol',
            default => $this->gander,
        };
    }
}
