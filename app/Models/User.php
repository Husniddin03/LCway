<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'password_status',
        'checked',
        'role',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function userData(): HasOne
    {
        return $this->hasOne(UserData::class, 'user_id');
    }
    
    public function aiChats()
    {
        return $this->hasMany(AiChat::class, 'user_id');
    }
    
    public function riasecResults()
    {
        return $this->hasMany(RiasecResult::class, 'user_id');
    }

    public function centers() : HasMany {
        return $this->hasMany(LearningCenter::class, 'users_id');
    }

    public function comments() : HasMany {
        return $this->hasMany(LearningCentersComment::class, 'user_id');
    }

    public function favorites() : HasMany {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Check if user is currently online (active within last 5 minutes)
     */
    public function isOnline(int $minutes = 5): bool
    {
        if (!$this->last_login_at) {
            return false;
        }
        return $this->last_login_at->diffInMinutes(now()) < $minutes;
    }

    /**
     * Check if user was recently online (within specified minutes)
     */
    public function wasRecentlyOnline(int $minutes = 30): bool
    {
        if (!$this->last_login_at) {
            return false;
        }
        return $this->last_login_at->diffInMinutes(now()) < $minutes;
    }

    /**
     * Check if user has been inactive for a long time (more than specified days)
     */
    public function isLongInactive(int $days = 30): bool
    {
        if (!$this->last_login_at) {
            return true;
        }
        return $this->last_login_at->diffInDays(now()) > $days;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }
}
