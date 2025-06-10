<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'org_name',
        'org_type',
        'established_date',
        'location',
        'description',
        'focus_area',
        'province',
        'city',
        'postal_code',
        'org_phone',
        'website',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
