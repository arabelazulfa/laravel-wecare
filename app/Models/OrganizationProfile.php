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
        'address',
        'logo',
        // tambahin field lain yang ada di tabel lo
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
