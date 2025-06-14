@extends('layouts.home')

@section('title', 'Detail Event')

@section('content')
    <div class="mt-6 max-w-4xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
        @if ($event->photo)
            <img src="{{ asset('storage/' . $event->photo) }}" alt="Event Image" class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <h2 class="text-2xl font-bold text-[#f28b8b] mb-1">{{ $event->title }}</h2>
            <p class="text-gray-600 font-semibold mb-2">
                {{ $event->organizer->organizationProfile->org_name ?? $event->organizer->name }}
            </p>

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

            <!-- Tombol Daftar untuk Volunteer -->
            @auth
                @if (auth()->user()->role === 'volunteer')
                                @php
        $hasRegistered = $event->participants->contains(auth()->user()->id);
        $isDeadlinePassed = now()->gt($event->registration_deadline);
                                @endphp

                                @if ($hasRegistered)
                                    <div class="mb-6">
                                        <p class="text-sm text-yellow-600 font-medium">Kamu sudah terdaftar di event ini.</p>
                                    </div>
                                @elseif ($isDeadlinePassed)
                                    <div class="mb-6">
                                        <p class="text-sm text-red-500 font-medium">Batas registrasi telah berakhir.</p>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <button onclick="toggleGabungOverlay(true)"
                                            class="inline-block bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-6 rounded-xl text-sm transition">
                                            GABUNG SEKARANG!
                                        </button>
                                    </div>
                                @endif
                @endif
            @else
                <div class="mt-6">
                    <p class="text-gray-600 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a> dulu untuk gabung ke
                        event ini.
                    </p>
                </div>
            @endauth

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold text-[#f28b8b] mb-2">Deskripsi Event</h3>
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $event->description }}
            </p>
        </div>
    </div>
    <x-gabungevent :event-id="$event->id" />
    <x-suksesgabung />

    <script>
        // Dengerin custom event dari Alpine setelah sukses submit form
        window.addEventListener('pendaftaran-berhasil', () => {
            // Tutup form gabung (optional)
            toggleGabungOverlay(false);

            // Tampilkan overlay sukses
            const overlay = document.getElementById('suksesGabungOverlay');
            overlay.classList.remove('hidden');
        });
    </script>

@endsection

<script>
    function toggleGabungOverlay(show) {
        const overlay = document.getElementById('gabungOverlay');
        overlay.classList.toggle('hidden', !show);
    }

    function showSuccessOverlay() {
        const overlay = document.getElementById('suksesGabungOverlay');
        overlay.classList.remove('hidden');
    }

    @if (session('success'))
        showSuccessOverlay();
    @endif
</script>