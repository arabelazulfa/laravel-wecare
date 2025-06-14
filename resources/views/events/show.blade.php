@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')


@section('content')
<div class="mt-6 max-w-4xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
    @if ($event->photo)
    <img src="{{ asset('storage/' . $event->photo) }}" alt="Event Image" class="w-full h-64 object-cover">
    @endif

    <div class="p-6">
        <h2 class="text-2xl font-bold text-[#f28b8b] mb-1">{{ $event->title }}</h2>
        <p class="text-gray-600 font-semibold mb-2">{{ $event->organizer->organization_name ?? '-' }}</p>

        <div class="flex items-center text-sm text-gray-600 mb-2 space-x-6">
            <span><i class="far fa-calendar-alt mr-1 text-[#f28b8b]"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
            <span><i class="fas fa-map-marker-alt mr-1 text-[#f28b8b]"></i> {{ $event->location }}</span>
            <span><i class="far fa-clock mr-1 text-[#f28b8b]"></i> {{ $event->time }} WIB</span>
        </div>

        <p class="text-sm text-gray-500 mb-4">
            <i class="far fa-calendar-times mr-1 text-[#f28b8b]"></i>
            Batas registrasi: {{ \Carbon\Carbon::parse($event->registration_deadline)->format('d M Y') }}
        </p>

        <!-- Kategori -->
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $event->category }}</span>
            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $event->event_type }}</span>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="#" class="inline-block text-xs bg-[#4A90E2] text-white font-bold py-2 px-4 rounded-xl hover:bg-[#357ABD] transition">
                Edit
            </a>
            <a href="{{ route('events.participants', $event->id) }}" class="inline-block text-xs bg-sky-400 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-pink-500 transition">
                Daftar Peserta
            </a>
            <a href="{{ route('events.presentation', $event->id) }}" class="inline-block text-xs bg-violet-400 hover:bg-violet-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-pink-500 transition">
                Set Presentasi
            </a>
        </div>

        <hr class="my-6 border-gray-200">

        <h3 class="text-lg font-semibold text-[#f28b8b] mb-2">Deskripsi Event</h3>
        <p class="text-gray-700 text-sm leading-relaxed">
            {{ $event->description }}
        </p>
    </div>
</div>
@endsection
