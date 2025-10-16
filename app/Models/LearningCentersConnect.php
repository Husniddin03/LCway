<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCentersConnect extends Model
{
    use HasFactory;

    protected $table = 'learning_centers_connect';

    protected $fillable = ['learning_centers_id', 'connection_id', 'url'];

    public function learningCenter()
    {
        return $this->belongsTo(LearningCenter::class, 'learning_centers_id');
    }

    public function connection()
    {
        return $this->belongsTo(Connection::class, 'connection_id');
    }
}
