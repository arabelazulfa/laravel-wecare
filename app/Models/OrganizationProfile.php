<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'org_name',
        'org_type',
        'established_date',
        'location',
        'province',
        'website',
        'logo',
        'city',
        'postal_code',
        'org_phone',
        'description',
        'focus_area',
        'status',
        'rejection_reason',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organization_id');
    }

    public function reviews()
    {
        return $this->hasMany(EventReview::class, 'organization_id');
    }

}
