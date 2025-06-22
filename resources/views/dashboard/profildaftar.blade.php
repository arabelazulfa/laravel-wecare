@extends('layouts.dashboardorg')

@section('title', 'Profil Relawan')
@section('header', 'Profil Relawan')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-lg mx-auto mt-6 px-6 md:px-10">
        
        <div class="flex flex-col items-center mb-6">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil"
                    class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-[#ffeaea]">
            @else
                <div class="w-40 h-40 rounded-full bg-pink-100 flex items-center justify-center text-gray-500 text-sm shadow">
                    No Photo
                </div>
            @endif
        </div>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-black-500">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                <p class="font-semibold text-gray-800">Nomor Telepon:</p>
                <p>{{ $user->phone ?? '-' }}</p>
            </div>

            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                <p class="font-semibold text-gray-800">Domisili:</p>
                <p>{{ $volProfile->city ?? '-' }}</p>
            </div>

            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                <p class="font-semibold text-gray-800">Minat 1:</p>
                <p>{{ $volProfile->interest1 ?? '-' }}</p>
            </div>

            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                <p class="font-semibold text-gray-800">Minat 2:</p>
                <p>{{ $volProfile->interest2 ?? '-' }}</p>
            </div>

            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                <p class="font-semibold text-gray-800">Profesi:</p>
                <p>{{ $volProfile->profession ?? '-' }}</p>
            </div>

          
            @if($eventRegistration && $eventRegistration->cv_file)
                <div class="bg-[#ffeaea] p-4 rounded-xl shadow-sm">
                    <p class="font-semibold text-gray-800">CV Relawan:</p>
                    <a href="{{ asset('storage/' . $eventRegistration->cv_file) }}" target="_blank"
                        class="text-blue-500 hover:underline">
                        Lihat CV
                    </a>
                    <img src="{{ asset('storage/' . $eventRegistration->cv_file) }}" 
                        class="mt-2 max-w-full max-h-60 object-contain rounded-lg shadow">
                </div>
            @endif


        </div>
    </div>
@endsection