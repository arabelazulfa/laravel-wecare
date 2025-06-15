<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;

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
        'start_time',
        'end_time',
        'registration_deadline',
        'description',
        'event_type',
        'photo',
        'status',
        'rejection_reason',

        // Tambahkan kolom baru yang sudah kamu buat
        'jenis_acara',
        'divisi',
        'tugas_relawan',
        'kriteria',
        'total_jam_kerja',
        'jumlah_relawan',
        'butuh_cv',
        'mode_darurat',
    ];


    // Jika kolom created_at dan updated_at sudah ada, maka model otomatis akan menggunakan timestamp

    // Jika kamu ingin atur tipe data tertentu
    protected $casts = [
        'date' => 'date',
        'registration_deadline' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Contoh relasi: Event punya organizer (user)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    // public function participants()
    // {
    //     return $this->belongsToMany(User::class, 'event_registrations')->withTimestamps();
    // }

    public function organizerProfile()
    {
        return $this->belongsTo(\App\Models\OrganizationProfile::class, 'organizer_id', 'user_id');
    }
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }


    public function participants()
    {
        return $this->belongsToMany(User::class, 'participations', 'event_id', 'user_id')->withTimestamps();
    }

    public function participations()
    {
    return $this->hasMany(\App\Models\Participation::class);
    }

    public function presensis()
    {
    return $this->hasMany(Presensi::class);
    }
    
}
