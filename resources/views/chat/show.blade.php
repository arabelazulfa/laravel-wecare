@extends('layouts.homeorg')

@section('title', 'Chat')

@section('content')
    <div class="flex h-[600px] rounded-2xl overflow-hidden shadow bg-[#ffdada]">
        {{-- Sidebar Kontak --}}
        <div class="w-1/3 bg-[#f5baba] p-4 overflow-y-auto">
            {{-- Search Box --}}
            <div class="mb-4">
                <input type="text" placeholder="Search"
                    class="w-full px-4 py-2 rounded-full text-sm bg-white placeholder-gray-500 focus:outline-none">
            </div>

            {{-- Daftar Chat --}}
            @foreach ($chatList as $contact)
                <a href="{{ route('chat.show', $contact->id) }}" class="flex items-center justify-between p-3 rounded-xl mb-2 
                           {{ $contact->id === $user->id ? 'bg-white' : 'hover:bg-[#f5baba]' }}">

                    {{-- Kiri: Foto + Nama + Preview --}}
                    <div class="flex items-center gap-3">
                        {{-- Foto Profil --}}
                        <img src="{{ $contact->profile_photo_url ?? asset('default-avatar.png') }}" alt="{{ $contact->name }}"
                            class="w-10 h-10 rounded-full object-cover">

                        {{-- Nama dan Pesan --}}
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">
                                {{ $contact->name }}
                            </p>
                            <p class="text-xs text-gray-600 truncate w-40">
                                {{ \Illuminate\Support\Str::limit($contact->last_message, 40, '...') }}
                            </p>

                        </div>
                    </div>

                    {{-- Kanan: Badge Unread --}}
                    @if ($contact->unread_count > 0)
                        <span class="text-xs bg-red-500 text-white rounded-full px-2 py-0.5">
                            {{ $contact->unread_count }}
                        </span>
                    @endif
                </a>
            @endforeach

        </div>

        {{-- Panel Chat --}}
        <div class="flex-1 bg-[#fff0f0] flex flex-col">
            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-[#f0cfcf] bg-[#ffdada]">
                <img src="{{ $user->profile_photo_url ?? asset('default-avatar.png') }}"
                    class="w-10 h-10 rounded-full object-cover">
                <h1 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h1>
            </div>

            {{-- Kotak Pesan --}}
            <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-4 scroll-smooth">
                @php
                    $lastDate = null;
                @endphp

                @forelse ($messages as $msg)
                    {{-- Tampilkan tanggal jika berbeda --}}
                    @php $msgDate = $msg->sent_at->format('d/m/Y'); @endphp
                    @if ($msgDate !== $lastDate)
                        <div class="text-center text-xs font-semibold text-gray-500 my-2">
                            {{ $msgDate }}
                        </div>
                        @php $lastDate = $msgDate; @endphp
                    @endif

                    {{-- Bubble chat --}}
                    <div class="flex {{ $msg->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="max-w-[70%] px-4 py-2 rounded-xl text-sm shadow
                                        {{ $msg->sender_id === Auth::id() ? 'bg-[#ffdddd] text-gray-800' : 'bg-white text-gray-800' }}">
                            <p class="break-words">{!! $msg->message !!}</p>

                            <span class="block mt-1 text-xs text-right text-gray-500">
                                {{ $msg->sent_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400">Belum ada pesan.</p>
                @endforelse
            </div>

            {{-- Form Kirim --}}
            <form action="{{ route('chat.send') }}" method="POST" class="p-4 bg-[#ffdada] flex gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                <input type="text" name="message" required placeholder="Ketik Pesan Anda"
                    class="flex-1 rounded-full px-4 py-2 text-sm bg-white focus:outline-none border-none">
                <button type="submit" title="Kirim" class="text-pink-600 hover:text-pink-700 text-xl px-3 transition">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
@endpush