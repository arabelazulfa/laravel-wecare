<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function organisasi()
{
    $pendaftaranRelawan = EventRegistration::with('relawan')->get()->map(function ($reg) {
        return (object)[
            'id' => $reg->relawan->id,
            'nama' => $reg->relawan->name,
            'lokasi' => $reg->relawan->lokasi,
            'deskripsi' => $reg->relawan->deskripsi,
            'minat' => $reg->relawan->minat,
        ];
    });

    return view('dashboard.organisasi', compact('pendaftaranRelawan'));
}

}
