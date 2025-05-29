@extends('layouts.app')
@section('content')

<div class="text-center py-16">
    <h2 class="text-2xl font-semibold text-green-600 mb-4">Verifikasi Berhasil</h2>
    <p class="mb-6">Akun kamu berhasil diverifikasi. Silakan login untuk mulai menggunakan aplikasi.</p>
    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login Sekarang</a>
</div>
@endsection

