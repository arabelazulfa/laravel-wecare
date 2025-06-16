<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('event')
            ->where('user_id', Auth::id())
            ->get();

        return view('sertifikat', compact('certificates'));
    }

}
