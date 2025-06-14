@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')


@section('content')
    <div class="mt-6 w-full bg-white rounded-2xl shadow-md overflow-hidden">

        @if ($event->photo)
            <img src="{{ asset('storage/' . $event->photo) }}" alt="Event Image" class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <h2 class="text-2xl font-bold text-black-500 mb-1">{{ $event->title }}</h2>
            <p class="text-gray-600 font-semibold mb-2">{{ $event->organizerProfile->org_name ?? '-' }}</p>

            <div class="flex items-center text-sm text-gray-600 mb-2 space-x-6">
                <span><i class="far fa-calendar-alt mr-1 text-blue-500"></i>
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                <span><i class="fas fa-map-marker-alt mr-1 text-red-500"></i> {{ $event->location }}</span>
                <span><i class="far fa-clock mr-1 text-gray-500"></i> {{ $event->time }} WIB</span>
            </div>

            <p class="text-sm text-gray-500 mb-4">
                <i class="far fa-calendar-times mr-1 text-gray-500"></i>
                Batas registrasi: {{ \Carbon\Carbon::parse($event->registration_deadline)->format('d M Y') }}
            </p>

            <!-- Kategori -->
            <div class="flex flex-wrap gap-2 mb-4">
                <span
                    class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $event->category }}</span>
                <span
                    class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $event->jenis_acara }}</span>
                <span
                    class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $event->event_type }}</span>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a href="#"
                    class="inline-block text-xs bg-[#4A90E2] text-white font-bold py-2 px-4 rounded-xl hover:bg-[#357ABD] transition">
                    Edit
                </a>
                <a href="{{ route('events.participants', $event->id) }}"
                    class="inline-block text-xs bg-sky-400 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-pink-500 transition">
                    Daftar Peserta
                </a>
                <a href="{{ route('events.presentation', $event->id) }}"
                    class="inline-block text-xs bg-green-100 text-green-800 font-bold py-2 px-4 rounded-xl hover:bg-green-200 transition">
                    Presensi
                </a>
            </div>

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold text-black-500 mb-2">Deskripsi Event</h3>
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $event->description }}
            </p>

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold text-black-500 mb-4">Detail Kebutuhan Relawan</h3>

            <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
                <!-- Item 1 -->
                <div class="flex items-start gap-3 bg-[#FFF0F3] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-users text-pink-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Jumlah Relawan Dibutuhkan</p>
                        <p>{{ $event->jumlah_relawan ?? '-' }}</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start gap-3 bg-[#E6FFFA] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-clock text-teal-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Total Jam Kerja</p>
                        <p>{{ $event->jam_kerja ?? '-' }} jam</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start gap-3 bg-[#F0F4FF] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-layer-group text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Divisi yang Dicari</p>
                        <p>{{ $event->divisi ?? '-' }}</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start gap-3 bg-[#F3F0FF] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-user-check text-indigo-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Kriteria Relawan</p>
                        <p>{{ $event->kriteria ?? '-' }}</p>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="flex items-start gap-3 bg-[#FFF7ED] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-tasks text-yellow-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Tugas Relawan</p>
                        <p>{{ $event->tugas ?? '-' }}</p>
                    </div>
                </div>
    
            </div>


        </div>
    </div>
@endsection