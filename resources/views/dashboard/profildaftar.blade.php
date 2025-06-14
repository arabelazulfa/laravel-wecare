@extends('layouts.dashboardorg')

@section('title', 'Profil Relawan')

@section('content')
<div class="container mx-auto pt-0 px-6 pb-6">
    <h1 class="text-2xl font-bold mt-0 mb-6">Profil Relawan</h1>

    <div class="bg-white rounded-2xl shadow p-6">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>No HP:</strong> {{ $user->phone }}</p>

        @if ($user->volunteerProfile)
            <p><strong>Lokasi:</strong> {{ $user->volunteerProfile->location }}</p>
            <p><strong>Deskripsi:</strong> {{ $user->volunteerProfile->description }}</p>
            <p><strong>Minat:</strong> {{ $user->volunteerProfile->interests }}</p>
        @else
            <p class="text-gray-500 italic">Belum ada profil relawan lengkap.</p>
        @endif
    </div>
</div>
@endsection
