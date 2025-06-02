@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold mb-6 text-center text-black">Daftar Volunteer Event</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($events as $event)
    <div class="bg-white rounded overflow-hidden shadow hover:shadow-lg transition-shadow duration-300"></div>
    <a href="{{ route('events.show', $event->id) }}" 
         class="block rounded overflow-hidden shadow hover:shadow-lg hover:cursor-pointer transition-shadow duration-300">
        <x-event-card 
          title="{{ $event->title }}"
          organizer="{{ $event->organizer->organizationProfile->org_name ?? $event->organizer->name }}"
          date="{{ $event->date->format('d M Y') }}"
          location="{{ $event->location }}"
          registration-deadline="{{ $event->registration_deadline->format('d M Y') }}"
          image="{{ $event->photo }}"
          tags="{{ $event->category }}"
        />
    </a>

      {{-- Contoh tombol daftar cuma muncul buat volunteer yang sudah login --}}
    @auth
      @if(auth()->user()->role === 'volunteer')
        <div class="text-center mt-2 mb-6">
          <a href="{{ route('event-registrations.create', ['event_id' => $event->id]) }}"
             class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
             Daftar Volunteer
          </a>
        </div>
      @endif
    @endauth
  </div>
    @empty
      <p class="text-center col-span-full text-gray-500">Belum ada event relawan yang tersedia.</p>
    @endforelse
  </div>

  {{-- Kalau user belum login, bisa tampilkan pesan atau tombol login --}}
  @guest
    <div class="text-center mt-8">
      <p class="mb-4 text-gray-700">Mau daftar volunteer? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login dulu ya</a></p>
    </div>
  @endguest
</div>
@endsection
