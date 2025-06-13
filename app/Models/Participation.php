<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $table = 'participations'; // Nama tabel jika tidak mengikuti default (optional)

    protected $fillable = [
        'user_id',
        'event_id',
        'attendance_time',
        'attendance_photo',
        'verified',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
