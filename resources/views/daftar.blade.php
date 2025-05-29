@extends('layouts.app')

@section('title', 'Daftar Akun - WeCare')

@section('content')
<div class="form-container mx-auto bg-white rounded-xl shadow-lg p-6 max-w-lg">
    <!-- Judul -->
    <h2 class="text-center text-2xl font-semibold mb-6 text-black-500">Daftar Sebagai:</h2>

    <!-- Pilihan Akun -->
    <div class="flex gap-6 justify-center">
        <!-- Volunteer -->
        <a href="{{ url('/register/volunteer') }}"
           class="flex flex-col items-center flex-1 border border-gray-400 rounded-lg p-6 text-gray-700 hover:bg-gray-100 hover:scale-105 transition-transform duration-200">
            <i class="fas fa-user fa-3x mb-3 text-gray-600"></i>
            <span class="text-lg font-medium">Volunteer</span>
        </a>

        <!-- Organisasi -->
        <a href="{{ url('/register/organisasi') }}"
           class="flex flex-col items-center flex-1 border border-gray-400 rounded-lg p-6 text-gray-700 hover:bg-gray-100 hover:scale-105 transition-transform duration-200">
            <i class="fas fa-users fa-3x mb-3 text-gray-600"></i>
            <span class="text-lg font-medium">Organisasi</span>
        </a>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-8">
        <a href="{{ url('/') }}"
           class="bg-gray-400 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg transition">Kembali</a>
    </div>
</div>
@endsection
