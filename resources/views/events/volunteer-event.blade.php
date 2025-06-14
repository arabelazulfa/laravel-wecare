@extends('layouts.home')

@section('content')
    <div class="container mx-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      {{-- Kolom search + tombol filter --}}
      <div class="flex items-center w-full md:w-1/2 mb-4 md:mb-0">
      <div class="relative w-full">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        {{-- ICON SEARCH --}}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5 text-gray-400">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        </span>
        <input type="text" placeholder="Cari event..."
        class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-300">
        {{-- ICON FILTER --}}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
        </svg>
      </button>
      </div>

      {{-- Judul di kanan --}}
      <h1 class="text-xl md:text-2xl font-bold text-black text-right w-full md:w-auto">Temukan Kegiatan, Tebarkan Manfaat
      </h1>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse ($events as $event)
      <div class="bg-white rounded overflow-hidden shadow hover:shadow-lg transition-shadow duration-300">
      <a href="{{ route('events.detail.volunteer', $event->id) }}"
      class="block rounded overflow-hidden hover:cursor-pointer transition-shadow duration-300">
      <x-event-card 
        title="{{ $event->title }}"
        organizer="{{ $event->organizer->organizationProfile->org_name ?? $event->organizer->name }}"
        date="{{ $event->date?->format('d M Y') ?? '-' }}"
        location="{{ $event->location }}"
        registration-deadline="{{ $event->registration_deadline?->format('d M Y') ?? '-' }}"
        image="{{ asset('storage/' . $event->photo) }}"
        tags="{{ $event->category }}" />
      </a>
      </div>
      @empty
      <p class="text-center col-span-full text-gray-500">Belum ada event relawan yang tersedia.</p>
      @endforelse
    </div>

    {{-- Kalau user belum login, bisa tampilkan pesan atau tombol login --}}
    @guest
      <div class="text-center mt-8">
      <p class="mb-4 text-gray-700">Mau daftar volunteer? <a href="{{ route('login') }}"
      class="text-blue-600 hover:underline">Login dulu ya</a></p>
      </div>
    @endguest
    </div>
@endsection
