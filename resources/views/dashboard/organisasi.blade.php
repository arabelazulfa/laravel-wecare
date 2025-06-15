@extends('layouts.dashboardorg')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto pt-0 px-6 pb-6">
        <h1 class="text-2xl font-bold mt-0 mb-6">Daftar Relawan per Event</h1>
        @php
            $success = session('success');
            $successEventId = session('event_id');
        @endphp

        @foreach ($groupedRegistrations as $group)
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 border-b pb-1 border-gray-300">
                    {{ $group->event_title }}
                </h2>
                
                @if ($success && $successEventId == $group->event_id)
                    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
                        {{ $success }}
                    </div>
                @endif


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    @foreach ($group->registrations as $relawan)
                        <div class="bg-white rounded-2xl shadow p-4">
                            <div class="flex items-center mb-4 gap-3">
                                <img src="{{ $relawan->profile_photo ? asset('storage/' . $relawan->profile_photo) : asset('images/default-user.png') }}"
                                    alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
                                <div>
                                    <h2 class="text-xl font-semibold mb-1">
                                        {{ $relawan->name ?? '-' }}
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        {{ $relawan->city ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <p class="mb-2"><strong>Alasan:</strong> {{ $relawan->reason ?? '-' }}</p>
                            <p class="mb-4"><strong>Divisi:</strong> {{ $relawan->division ?? '-' }}</p>

                            <div class="flex justify-between items-center gap-2 mt-4">
                                {{-- Tombol Hubungi --}}
                                <a href="{{ route('chat.show', ['id' => $relawan->id]) }}"
                                    class="flex-1 bg-green-200 hover:bg-green-300  px-4 py-2 rounded-lg text-sm text-center">
                                    Hubungi
                                </a>

                                {{-- Tombol Profil --}}
                                <a href="{{ route('profildaftar', ['id' => $relawan->id]) }}"
                                    class="flex-1 bg-pink-200 hover:bg-pink-300 px-4 py-2 rounded-lg text-sm text-center">
                                    Profil
                                </a>

                                {{-- Tombol Terima/Diterima --}}
                                @php
                                    $eventId = $group->event_id ?? null;
                                    $accepted = \App\Models\Participation::where('user_id', $relawan->id)
                                        ->where('event_id', $eventId)
                                        ->where('verified', true)
                                        ->exists();
                                @endphp

                                <form method="POST" action="{{ route('participations.accept') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $relawan->id }}">
                                    <input type="hidden" name="event_id" value="{{ $eventId }}">

                                    <button type="submit"
                                        class="{{ $accepted ? 'bg-white text-gray-700' : 'bg-blue-200 hover:bg-blue-300' }} w-full px-4 py-2 rounded-lg text-sm text-center hover:opacity-80">
                                        {{ $accepted ? 'Diterima' : 'Terima' }}
                                    </button>
                                </form>

                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection