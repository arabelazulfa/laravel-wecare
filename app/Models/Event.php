<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai dengan default plural dari nama model (optional jika tabel bernama 'events')
    protected $table = 'events';

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'organizer_id',
        'title',
        'category',
        'location',
        'date',
        'time',
        'registration_deadline',
        'description',
        'event_type',
        'photo',
        'status',
        'rejection_reason',
    ];

    // Jika kolom created_at dan updated_at sudah ada, maka model otomatis akan menggunakan timestamp

    // Jika kamu ingin atur tipe data tertentu
    protected $casts = [
        'date' => 'date',
        'registration_deadline' => 'date',
        'time' => 'datetime:H:i', // kalau pakai time, bisa disesuaikan
    ];

    // Contoh relasi: Event punya organizer (user)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

}
