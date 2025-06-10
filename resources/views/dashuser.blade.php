{{-- resources/views/dashuser.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard User')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Halo, User 👋</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Aktivitas Terbaru</h2>
            <p class="text-gray-600">Belum ada aktivitas.</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Notifikasi</h2>
            <p class="text-gray-600">Kamu tidak punya notifikasi baru.</p>
        </div>
    </div>
@endsection
