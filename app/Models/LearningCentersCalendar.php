<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCentersCalendar extends Model
{
    use HasFactory;

    protected $table = 'learning_centers_calendar';

    protected $fillable = ['learning_centers_id', 'calendar_id', 'open_time', 'close_time'];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }
}
