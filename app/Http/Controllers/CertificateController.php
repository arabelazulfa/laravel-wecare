<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        // nanti bisa kirim data sertifikat dari database ke view, sekarang dummy dulu
        return view('sertifikat');
    }
}
