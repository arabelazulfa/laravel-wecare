<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registrations'; // pastikan sesuai nama tabel di DB

    protected $fillable = [
        'event_id',
        'user_id',
        'division',
        'reason',
        'why_you',
        'cv_file',
        'status', // kalau ada kolom status (misal: pending, approved, dll)
        'registered_at',
        // tambahin field lain kalau ada
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke User (si volunteer yang daftar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
