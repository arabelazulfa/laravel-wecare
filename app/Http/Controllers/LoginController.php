<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role user yang login
            $user = Auth::user();
            if ($user->role === 'volunteer') {
                return redirect()->route('volunteer.events');
            } elseif ($user->role === 'organizer') {
                return redirect()->route('dashboard.organisasi');
            } else {
                return redirect('/');
            }
        }


        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
}