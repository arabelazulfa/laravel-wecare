@extends('layouts.homeorg')

@section('title', 'Chat')

@section('content')
    <div class="flex h-[600px] rounded-2xl overflow-hidden shadow bg-[#ffdada]">
        {{-- Sidebar Kontak --}}
        <div class="w-full md:w-1/3 bg-[#f5baba] p-4 overflow-y-auto">
            {{-- Search Box --}}
            <form method="GET" action="{{ route('chat.index') }}" class="mb-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari"
                    class="w-full px-4 py-2 rounded-full text-sm bg-white placeholder-gray-500 focus:outline-none">
            </form>

            {{-- Daftar Chat --}}
            @forelse ($chatList as $contact)
                <a href="{{ route('chat.show', $contact->id) }}" class="flex items-center justify-between p-3 rounded-xl mb-2 hover:bg-[#fcdede] transition">
                    {{-- Kiri: Foto + Nama + Preview --}}
                    <div class="flex items-center gap-3">
                        {{-- Foto Profil --}}
                        <img src="{{ $contact->profile_photo_url ?? asset('default-avatar.png') }}" alt="{{ $contact->name }}"
                            class="w-10 h-10 rounded-full object-cover">

                        {{-- Nama dan Pesan --}}
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
                            <p class="text-xs text-gray-600 truncate w-40">{{ \Illuminate\Support\Str::limit($contact->last_message, 40, '...') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Badge Unread --}}
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
