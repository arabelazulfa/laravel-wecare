<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $fillable = [
        'user_id',
        'profession',
        'city',
        'interest1',
        'interest2',
        'ktp_file',
        
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
