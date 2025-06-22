@extends('layouts.home')

@section('content')
    <div class="container mx-4 py-8">

  <form method="GET" action="{{ route('volunteer.events') }}"
    class="space-y-4 md:space-y-0 md:flex md:items-end md:flex-wrap gap-4 mb-6">
    
    <div class="relative w-full md:w-[250px]">
    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
      stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
      </svg>
    </span>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event / organisasi..."
      class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>


    <input type="text" name="location" value="{{ request('location') }}" placeholder="Lokasi event..."
    class="rounded-xl px-3 py-2 border w-full md:w-[200px]">

    <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl px-3 py-2 border w-full md:w-[180px]">


    <select name="event_type" class="rounded-xl px-3 py-2 border w-full md:w-[200px]">
    <option value="">Tipe Kegiatan</option>
    @foreach ($eventTypes as $type)
    <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
    @endforeach
    </select>

    <select name="interest" class="rounded-xl px-3 py-2 border w-full md:w-[200px]">
    <option value="">Kategori</option>
    @foreach ($category as $cat)
    <option value="{{ $cat }}" {{ request('interest') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
    @endforeach
    </select>

    <button type="submit"
    class="bg-blue-600 text-white rounded-xl px-4 py-2 text-sm hover:bg-blue-700 w-full md:w-auto">Cari</button>
  </form>


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


    @guest
      <div class="text-center mt-8">
      <p class="mb-4 text-gray-700">Mau daftar volunteer? <a href="{{ route('login') }}"
      class="text-blue-600 hover:underline">Login dulu ya</a></p>
      </div>
    @endguest
    </div>
@endsection
