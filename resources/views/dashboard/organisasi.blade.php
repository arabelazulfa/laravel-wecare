@extends('layouts.dashboardorg')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto pt-0 px-6 pb-6">
    <h1 class="text-2xl font-bold mt-0 mb-6 text-gray-800">Daftar Relawan per Event</h1>

    @php
        $success = session('success');
        $successEventId = session('event_id');
    @endphp

    @forelse ($groupedRegistrations as $group)
        <div class="mb-10 bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            <h2 class="text-lg font-semibold mb-4 text-black-500 border-b border-gray-300 pb-2">
                {{ $group->event_title }}
            </h2>

            @if ($success && $successEventId == $group->event_id)
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
                    {{ $success }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($group->registrations as $relawan)
                    <div class="bg-[#ffe4e6] rounded-xl shadow-sm p-6 hover:shadow-md transition text-center flex flex-col items-center">
                        {{-- Foto Profil --}}
                        <img src="{{ $relawan->profile_photo ? asset('storage/' . $relawan->profile_photo) : asset('images/default-user.png') }}"
                            alt="Foto Profil" class="w-20 h-20 rounded-full object-cover shadow mb-4 bg-white border border-gray-300">

                        {{-- Nama --}}
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">
                            {{ $relawan->name ?? '-' }}
                        </h3>

                        {{-- Kota --}}
                        <p class="text-sm text-gray-500 mb-3">
                            <i class="fas fa-map-marker-alt mr-1 text-pink-500"></i>
                            {{ $relawan->city ?? '-' }}
                        </p>

                        {{-- Alasan dan Divisi --}}
                        <div class="text-sm text-gray-700 mb-4 text-left w-full">
                            <p class="mb-1"><strong>Alasan:</strong> {{ $relawan->reason ?? '-' }}</p>
                            <p><strong>Divisi:</strong> {{ $relawan->division ?? '-' }}</p>
                        </div>

                        {{-- Tombol menyamping --}}
                        <div class="flex justify-center gap-2 w-full mt-2">
                            {{-- Tombol Hubungi --}}
                            <a href="{{ route('chat.show', ['id' => $relawan->id]) }}"
                                class="bg-green-200 hover:bg-green-300 text-gray-800 px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
                                <i class="fas fa-comments"></i> Hubungi
                            </a>

                            {{-- Tombol Profil --}}
                            <a href="{{ route('profildaftar', ['id' => $relawan->id]) }}"
                                class="bg-pink-200 hover:bg-pink-300 text-gray-800 px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
                                <i class="fas fa-user"></i> Profil
                            </a>

                            {{-- Tombol Terima/Diterima --}}
                            @php
                                $eventId = $group->event_id ?? null;
                                $accepted = \App\Models\Participation::where('user_id', $relawan->id)
                                    ->where('event_id', $eventId)
                                    ->where('verified', true)
                                    ->exists();
                            @endphp

                            <form method="POST" action="{{ route('participations.accept') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $relawan->id }}">
                                <input type="hidden" name="event_id" value="{{ $eventId }}">

                                <button type="submit"
                                    class="{{ $accepted ? 'bg-white text-gray-600 border' : 'bg-blue-200 hover:bg-blue-300 text-gray-800' }} px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
                                    <i class="fas {{ $accepted ? 'fa-check' : 'fa-handshake' }}"></i>
                                    {{ $accepted ? 'Diterima' : 'Terima' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic col-span-full">Belum ada relawan mendaftar untuk event ini.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded text-sm">
            Belum ada pendaftaran relawan untuk event apapun.
        </div>
    @endforelse
</div>
@endsection
