@extends('layouts.home') 

@section('title', 'Percakapan')

@section('content')
    <div class="flex h-[600px] rounded-2xl overflow-hidden shadow bg-[#ffdada]">
        {{-- Sidebar Kontak --}}
        <div class="w-full md:w-1/3 bg-[#f5baba] p-4 overflow-y-auto">
            {{-- Search Box --}}
            <div class="mb-4">
                <input type="text" placeholder="Search"
                    class="w-full px-4 py-2 rounded-full text-sm bg-white placeholder-gray-500 focus:outline-none">
            </div>

            {{-- Daftar Chat --}}
            @forelse ($chatList as $contact)
                <a href="{{ route('volunteer.chat.show', $contact->id) }}"
                    class="flex items-center justify-between p-3 rounded-xl mb-2 hover:bg-[#fcdede] transition">

                    {{-- Kiri: Foto + Nama + Preview --}}
                    <div class="flex items-center gap-3">
                        {{-- Foto Profil --}}
                        @if ($contact->profile_photo)
                            <img src="{{ asset('storage/' . $contact->profile_photo) }}" alt="{{ $contact->name }}"
                                class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-pink-100 text-pink-600 flex items-center justify-center rounded-full font-bold text-sm">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- Nama dan preview pesan --}}
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
                            <p class="text-xs text-gray-600 truncate w-40">
                                {{ \Illuminate\Support\Str::limit($contact->last_message, 40, '...') }}
                            </p>
                        </div>
                    </div>

                    {{-- Badge jumlah pesan belum dibaca --}}
                    @if ($contact->unread_count > 0)
                        <span class="text-xs bg-red-500 text-white rounded-full px-2 py-0.5">
                            {{ $contact->unread_count }}
                        </span>
                    @endif
                </a>
            @empty
                <p class="text-gray-500 text-center mt-8">Belum ada percakapan dengan pengguna lain.</p>
            @endforelse
        </div>
    </div>
@endsection
