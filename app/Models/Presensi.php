<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Presensi extends Model
{   
    use HasFactory;

    protected $table = 'presensi';
    protected $fillable = [
        'user_id',
        'event_id',
        'attendance_time',
        'attendance_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'user_id', 'user_id')->whereColumn('event_id','event_id');
    }

}
