@extends('layouts.dashboardorg') 
@section('title', 'Edit Profile')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md max-w-xl mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-4 text-[#f28b8b]">Edit Profil</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password Baru (opsional)</label>
            <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
    Simpan Perubahan
</button>

    @endsection
