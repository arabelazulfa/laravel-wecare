@extends('layouts.app')

@section('title', 'Daftar Akun - WeCare')

@section('content')
<div class="mx-auto bg-white rounded-2xl shadow-xl p-8 max-w-3xl">
    <!-- Judul -->
    <h2 class="text-center text-3xl font-bold mb-10 text-gray-800 tracking-wide">
        <i class="fas fa-user-plus text-pink-400 me-2"></i>
        Pilih Tipe Akun
    </h2>

    <!-- Pilihan Akun -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Volunteer Card -->
        <a href="{{ url('/register/volunteer') }}"
           class="group border border-gray-200 rounded-xl p-8 bg-pink-50 hover:bg-pink-100 shadow-md hover:shadow-lg transition-all duration-300 text-center">
            <i class="fas fa-hands-helping text-pink-600 text-5xl mb-4 group-hover:scale-110 transition-transform"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Volunteer</h3>
            <p class="text-sm text-gray-600">Jadilah bagian dari gerakan sosial sebagai relawan yang aktif.</p>
        </a>

        <!-- Organisasi Card -->
        <a href="{{ url('/register/organisasi') }}"
           class="group border border-gray-200 rounded-xl p-8 bg-pink-50 hover:bg-pink-100 shadow-md hover:shadow-lg transition-all duration-300 text-center">
            <i class="fas fa-building text-pink-600 text-5xl mb-4 group-hover:scale-110 transition-transform"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Organisasi</h3>
            <p class="text-sm text-gray-600">Buat kegiatan sosial dan temukan relawan yang tepat.</p>
        </a>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-10">
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 bg-gray-400 hover:bg-gray-700 text-white font-medium px-6 py-2 rounded-full transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
