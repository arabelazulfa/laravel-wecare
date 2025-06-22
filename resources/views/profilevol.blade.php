@extends('layouts.dashboard')

@section('title', 'Profile Volunteer')
@section('header', 'Profile')

@section('content')
    <h2 class="text-xl font-semibold mb-2">Profile Saya</h2>
        
        <div class="flex flex-col items-center mb-4">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil"
                    class="w-40 h-40 rounded-full object-cover shadow">
            @else
                <div class="w-40 h-40 rounded-full bg-pink-100 flex items-center justify-center text-gray-500 text-sm shadow">
                    No Photo
                </div>
            @endif

            <form method="POST" action="{{ route('volunteer.profile.updatePhoto') }}" enctype="multipart/form-data" class="mt-2">
                @csrf
                <label class="cursor-pointer text-sm text-blue-500 hover:underline">
                    Ganti Foto
                    <input type="file" name="photo" class="hidden" onchange="this.form.submit()" />
                </label>
            </form>
        </div>

        <div class="text-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <x-inline-editvol field="phone" :value="$user->phone ?? '-'" label="Nomor Telepon" icon="true" />
            <x-inline-passwordvol icon="true" />
            <x-inline-editvol field="interest1" :value="$volProfile->interest1 ?? '-'" label="Minat 1" icon="true"
                :options="$validInterests" />
            <x-inline-editvol field="interest2" :value="$volProfile->interest2 ?? '-'" label="Minat 2" icon="true"
                :options="$validInterests" />
            <x-inline-editvol field="city" :value="$volProfile->city ?? '-'" label="Domisili" icon="true" />
            <x-inline-editvol field="profession" :value="$volProfile->profession ?? '-'" label="Profesi" icon="true" />
        </div>

@endsection
