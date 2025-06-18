@extends('layouts.dashboardorg')

@section('title', 'Profil Organisasi')

@section('content')
    <!-- Header Profile -->
    <div class="text-center mt-8 mb-8">
        <!-- Logo -->
        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo"
            class="w-40 h-40 rounded-full bg-white object-cover shadow mx-auto">

        <h2 class="text-3xl font-bold mt-3 text-gray-800">
            {{ $profile->org_name ?? 'Nama Organisasi Belum Diisi' }}
        </h2>


        <!-- Label "Ganti Foto" -->
        <label for="logoUpload" class="text-xs text-blue-500 hover:underline mt-2 inline-block cursor-pointer">
            Ganti Foto
        </label>

        <!-- Form Upload Logo -->
        <form id="logoForm" action="{{ route('dashboard.updateLogo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="logo" id="logoUpload" accept="image/*" class="hidden"
                onchange="document.getElementById('logoForm').submit();">
        </form>
    </div>


    <!-- Detail Box -->
    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="bg-[#ffcfcf] p-4 rounded-xl text-sm md:text-base text-black-500">
            <p class="font-semibold mb-2 flex items-center gap-2">
                <i class="fas fa-bullseye text-pink-600"></i>
                Fokus Utama:
                <span class="font-normal">{{ $profile->focus_area ?? 'Belum ditentukan' }}</span>
            </p>
            <p class="flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-red-600"></i>
                <span class="font-semibold">Lokasi:</span>
                <span>{{ $profile->city ?? '-' }}, {{ $profile->province ?? '-' }}</span>
            </p>
            <p class="flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-500"></i>
                <span class="font-semibold">Bergabung sejak:</span>
                <span>
                    {{ $profile->established_date ? \Carbon\Carbon::parse($profile->established_date)->translatedFormat('d F Y') : 'Tanggal tidak tersedia' }}
                </span>
            </p>
        </div>


        <div class="bg-[#ffcfcf] p-4 rounded-xl">
            <p class="font-semibold mb-2">Deskripsi Organisasi</p>
            <p class="text-sm">{{ $profile->description ?? 'Belum ada deskripsi.' }}</p>
        </div>
    </div>

    <!-- Galeri Placeholder -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-lg text-black">Galeri Organisasi</h3>
            <a href="{{ route('dashboard.gallery') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded shadow">
                Kelola Galeri
            </a>
        </div>

        <div class="flex gap-4 flex-wrap">
            @forelse($galleries as $gallery)
                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-32 h-20 rounded object-cover">
            @empty
                <p class="text-sm text-gray-500 italic">Belum ada gambar di galeri.</p>
            @endforelse
        </div>
    </div>


    <!-- Aktivitas Terbaru -->
    <div class="mt-8">
        <h3 class="font-semibold mb-3 text-lg text-black">Aktivitas Organisasi</h3>
        @forelse($events as $event)
            <div class="bg-white p-4 rounded shadow-sm mb-3">
                <h4 class="font-semibold text-black">{{ $event->title }}</h4>
                <p class="text-sm text-gray-600">
                    📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} |
                    📍 {{ $event->location }}
                </p>
                <p class="text-sm mt-1">{{ Str::limit($event->description, 100) }}</p>
                <a href="{{ route('events.show', $event->id) }}" class="text-sm text-blue-500 hover:underline">
                    Lihat Selengkapnya
                </a>
            </div>
        @empty
            <p class="text-sm text-gray-500 italic">Belum ada aktivitas organisasi.</p>
        @endforelse
    </div>


    <!-- Ulasan Relawan -->
    <div class="mt-8">
        <h3 class="font-semibold mb-3 text-lg text-black">Ulasan Relawan</h3>
        @forelse($reviews as $review)
            <div class="bg-white p-3 rounded shadow-sm mb-2">
                <p class="font-bold text-[#f28b8b]">{{ $review->user->name ?? 'Anonim' }}</p>
                <p class="text-xs text-gray-500 mb-1 italic">Event: {{ $review->event->title ?? '-' }}</p>
                <p class="text-sm">{{ $review->review }}</p>
                <p class="text-xs text-gray-500 text-right mt-3">
                    {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y, H:i') }}
                </p>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada ulasan.</p>
        @endforelse
    </div>
    </div>
@endsection