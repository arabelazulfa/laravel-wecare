@extends('layouts.dashboardorg')

@section('title', 'Your Profile')

@section('content')
    <div class="bg-[#ffeaea] rounded-2xl p-6 mx-auto max-w-5xl mt-8">
        <!-- Header Profile -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-6">
                <img src="{{ asset('storage/logos/' . $profile->logo) }}" alt="Logo"
                    class="w-28 h-28 rounded-full bg-white object-cover shadow">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $profile->org_name }}</h2>
                    <p class="text-sm text-gray-600">{{ $profile->org_type }}</p>
                </div>
            </div>

            <!-- Tombol Edit Profil -->
            <a href="{{ route('dashboard.editprofile') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded shadow">
                Edit Profil
            </a>
        </div>

        <!-- Detail Box -->
        <div class="grid grid-cols-2 gap-6 mt-6">
            <div class="bg-[#ffcfcf] p-4 rounded-xl">
                <p class="font-semibold mb-2"><i class="fas fa-users"></i> Fokus: {{ $profile->focus_area }}</p>
                <p><i class="fas fa-map-marker-alt"></i> {{ $profile->city ?? '-' }}, {{ $profile->province }}</p>
                <p><i class="fas fa-calendar"></i> Bergabung sejak
                    {{ \Carbon\Carbon::parse($profile->established_date)->format('d M Y') }}</p>
            </div>
            <div class="bg-[#ffcfcf] p-4 rounded-xl">
                <p class="font-semibold mb-2">Deskripsi Organisasi</p>
                <p class="text-sm">{{ $profile->description ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>

        <!-- Galeri Placeholder -->
        <div class="mt-8">
            <h3 class="font-semibold mb-3 text-lg text-gray-700">Galeri Organisasi</h3>
            <div class="flex gap-4">
                {{-- Tambahkan data dari galeri jika sudah ada --}}
                <img src="{{ asset('images/sample1.jpg') }}" class="w-32 h-20 rounded object-cover">
                <img src="{{ asset('images/sample2.jpg') }}" class="w-32 h-20 rounded object-cover">
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="mt-8">
            <h3 class="font-semibold mb-3 text-lg text-gray-700">Aktivitas Organisasi</h3>
            @forelse($events as $event)
                <div class="bg-white p-4 rounded shadow-sm mb-3">
                    <h4 class="font-bold text-[#f28b8b]">{{ $event->title }}</h4>
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
            <h3 class="font-semibold mb-3 text-lg text-gray-700">Ulasan Relawan</h3>
            @forelse($reviews as $review)
                <div class="bg-white p-3 rounded shadow-sm mb-2">
                    <p class="font-bold text-[#f28b8b]">{{ $review->user->name ?? 'Anonim' }}</p>
                    <p class="text-sm">"{{ $review->review }}"</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>
@endsection