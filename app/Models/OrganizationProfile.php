<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'tipe_organisasi',
        'tanggal_berdiri',
        'lokasi',
        'deskripsi_singkat',
        'fokus_utama',
        'alamat',
        'provinsi',
        'kabupaten_kota',
        'kodepos',
        'no_telp',
        'website',
        'logo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
