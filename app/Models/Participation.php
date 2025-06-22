<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $table = 'participations';

    protected $fillable = [
        'user_id',
        'event_id',
        'attendance_time',
        'attendance_photo',
        'verified',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
