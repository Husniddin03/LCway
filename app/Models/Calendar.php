<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendar';

    protected $fillable = ['weekdays'];

    public function learningCenters()
    {
        return $this->hasMany(LearningCentersCalendar::class, 'calendar_id');
    }
}
