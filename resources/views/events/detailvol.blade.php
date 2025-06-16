@extends('layouts.home')

@section('title', 'Detail Event')

@section('content')
    <div class="mt-6 max-w-4xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
        @if ($event->photo)
            <img src="{{ asset('storage/' . $event->photo) }}" alt="Event Image" class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <h2 class="text-2xl font-bold text-black-500 mb-1">{{ $event->title }}</h2>
            <p class="text-gray-600 font-semibold mb-2">{{ $event->organizerProfile->org_name ?? '-' }}</p>

        <div class="flex items-center text-sm text-gray-600 mb-2 space-x-6">
            <span><i class="far fa-calendar-alt mr-1 text-[#f28b8b]"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
            <span><i class="fas fa-map-marker-alt mr-1 text-[#f28b8b]"></i> {{ $event->location }}</span>
            <span>
                <i class="far fa-clock mr-1 text-[#f28b8b]"></i>
                {{ \Carbon\Carbon::parse($event->start_time)->format('H.i') }}
                –
                {{ \Carbon\Carbon::parse($event->end_time)->format('H.i') }} WIB
            </span>

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
                            <a href="{{ route('volunteer.chat.show', $event->organizer->id) }}"
                                class="inline-block bg-pink-100 text-pink-600 hover:bg-pink-200 font-semibold py-2 px-6 rounded-xl text-sm transition mt-3 sm:mt-0">
                                <i class="fas fa-comments mr-2"></i>Hubungi Organisasi
                            </a>
                        </div>
                    @endif
                @endif
            @else
                <div class="mt-6">
                    <p class="text-gray-600 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a> dulu untuk
                        gabung ke
                        event ini.
                    </p>
                </div>
            @endauth

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold text-black-500 mb-2">Deskripsi Event</h3>
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $event->description }}
            </p>
        </div>
        <hr class="my-6 border-gray-200">

        <h3 class="text-lg font-semibold text-black-500 mb-4 px-6">Detail Kebutuhan Relawan</h3>
        <div class="px-6 pb-6">
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
                        <p>{{ $event->total_jam_kerja ?? '-' }} jam</p>
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

                <!-- Item 4 - Kriteria Relawan -->
                <div class="flex items-start gap-3 bg-[#F3F0FF] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-user-check text-indigo-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Kriteria Relawan</p>
                        <p>{!! nl2br(e($event->kriteria ?? '-')) !!}</p>
                    </div>
                </div>

                <!-- Item 5 - Tugas Relawan -->
                <div class="flex items-start gap-3 bg-[#FFF7ED] p-4 rounded-xl shadow-sm">
                    <i class="fas fa-tasks text-yellow-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-black">Tugas Relawan</p>
                        <p>{!! nl2br(e($event->tugas_relawan ?? '-')) !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200">

        <div class="px-6 pb-10">
            <h3 class="font-semibold mb-3 text-lg text-black">Ulasan Relawan</h3>

            @forelse ($event->eventReviews as $review)
                <div class="bg-[#FFF5F7] p-4 rounded-md shadow mb-3">
                    <p class="font-bold text-[#f28b8b]">{{ $review->user->name ?? 'Anonim' }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $review->review }}</p>
                    <p class="text-xs text-gray-500 text-right mt-3">
                        {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y, H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada ulasan untuk event ini.</p>
            @endforelse
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