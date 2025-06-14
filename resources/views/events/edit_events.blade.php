@extends('layouts.dashboardorg')

@section('title', 'Edit Aktivitas')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded-lg p-8">
    <h2 class="text-2xl font-bold text-[#f28b8b] mb-6">Edit Aktivitas</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="edit-form" action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="organizer_id" value="{{ old('organizer_id', $event->organizer_id) }}">

        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Fokus Kegiatan</label>
                <select name="category" class="w-full border px-3 py-2 rounded">
                    <option value="Sosial" {{ old('category', $event->category) == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="Pendidikan" {{ old('category', $event->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Lingkungan" {{ old('category', $event->category) == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Tipe Event</label>
                <select name="event_type" class="w-full border px-3 py-2 rounded">
                    <option value="Online" {{ old('event_type', $event->event_type) == 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Offline" {{ old('event_type', $event->event_type) == 'Offline' ? 'selected' : '' }}>Offline</option>
                    <option value="Hybrid" {{ old('event_type', $event->event_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Jenis Acara</label>
                <input type="text" name="jenis_acara" value="{{ old('jenis_acara', $event->jenis_acara) }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-semibold mb-1">Divisi</label>
                <input type="text" name="divisi" value="{{ old('divisi', $event->divisi) }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d')) }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-semibold mb-1">Jam Mulai</label>
                <input type="time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-semibold mb-1">Jam Selesai</label>
                <input type="time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Batas Registrasi</label>
            <input type="date" name="registration_deadline" value="{{ old('registration_deadline', \Carbon\Carbon::parse($event->registration_deadline)->format('Y-m-d')) }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tugas Relawan</label>
                <textarea name="tugas_relawan" rows="4" class="w-full border rounded-lg px-4 py-2 text-sm" required>{{ old('tugas_relawan', $event->tugas_relawan ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kriteria</label>
                <textarea name="kriteria" rows="4" class="w-full border rounded-lg px-4 py-2 text-sm" required>{{ old('kriteria', $event->kriteria ?? '') }}</textarea>
            </div>
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Total Jam Kerja</label>
                <input type="number" name="total_jam_kerja" value="{{ old('total_jam_kerja', $event->total_jam_kerja) }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-semibold mb-1">Jumlah Relawan</label>
                <input type="number" name="jumlah_relawan" value="{{ old('jumlah_relawan', $event->jumlah_relawan) }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Butuh CV?</label>
                <select name="butuh_cv" class="w-full border px-3 py-2 rounded">
                    <option value="ya" {{ old('butuh_cv', $event->butuh_cv) == 'ya' ? 'selected' : '' }}>Ya</option>
                    <option value="tidak" {{ old('butuh_cv', $event->butuh_cv) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Mode Darurat</label>
                <select name="mode_darurat" class="w-full border px-3 py-2 rounded">
                        <option value="ya" {{ old('mode_darurat', $event->mode_darurat) == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('mode_darurat', $event->mode_darurat) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border px-3 py-2 rounded">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Foto Event</label>
            @if ($event->photo)
                <img src="{{ asset('storage/' . $event->photo) }}" alt="Foto Event" class="w-32 h-32 object-cover mb-2">
            @endif
            <input type="file" name="photo" class="w-full border px-3 py-2 rounded">
        </div>
    </form>

        {{-- Tombol Simpan --}}
        <div class="flex justify-between items-center mt-6">
            <button type="submit" form="edit-form" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded shadow">
                Simpan Perubahan
            </button>
        
            <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py- rounded shadow">
                    Hapus Event
                </button>
            </form>
        </div>
</div>
@endsection
