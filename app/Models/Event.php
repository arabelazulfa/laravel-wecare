<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;

class Event extends Model
{
    use HasFactory;

  
    protected $table = 'events';

   
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

       
        'jenis_acara',
        'divisi',
        'tugas_relawan',
        'kriteria',
        'total_jam_kerja',
        'jumlah_relawan',
        'butuh_cv',
        'mode_darurat',
    ];


    
    protected $casts = [
        'date' => 'date',
        'registration_deadline' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
   

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
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    
    public function reviews()
    {
    return $this->hasMany(EventReview::class);
    }

    public function eventReviews()
    {
    return $this->hasMany(EventReview::class);
    }

}
