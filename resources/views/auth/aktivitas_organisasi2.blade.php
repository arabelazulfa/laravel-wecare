@extends('layouts.dashboardorg')

@section('title', 'Tambah Aktivitas')

@section('content')
<div class="bg-pink-100 min-h-screen py-6 px-10">
    <div class="bg-white bg-opacity-30 rounded-xl p-6 max-w-4xl mx-auto">
        <h2 class="text-center text-lg font-semibold mb-6">Info Utama</h2>

        <form action="{{ route('aktivitas.keLangkah2') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="title" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Masukkan Judul">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" required rows="3" class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Masukkan Deskripsi"></textarea>
            </div>

            <!-- Fokus Kegiatan -->
            <div>
                <label class="block text-sm font-medium mb-1">Fokus Kegiatan</label>
                <select name="category" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm">
                    <option disabled selected>Pilih</option>
                    <option value="sosial">Sosial</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="lingkungan">Lingkungan</option>
                </select>
            </div>

            <!-- Batas Pendaftaran -->
            <div>
                <label class="block text-sm font-medium mb-1">Batas Pendaftaran</label>
                <input type="date" name="registration_deadline" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm">
            </div>

            <!-- Tipe -->
            <div>
                <label class="block text-sm font-medium mb-1">Tipe</label>
                <select name="event_type" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm">
                    <option disabled selected>Pilih</option>
                    <option value="offline">Offline</option>
                    <option value="online">Online</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-medium mb-1">Lokasi</label>
                <input type="text" name="location" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Masukkan Lokasi">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Pelaksanaan</label>
                <input type="date" name="date" id="date" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Tanggal Pelaksanaan">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu Pelaksanaan</label>
                <div class="flex space-x-2">
                    <input type="time" name="start_time" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Waktu Mulai">
                    <span class="self-center text-sm text-gray-600">-</span>
                    <input type="time" name="end_time" required class="w-full rounded-lg border-none bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Waktu Selesai">
                </div>
            </div>

            <!-- Banner -->
            <div>
                <label class="block text-sm font-medium mb-1">Banner</label>
                <input type="file" name="photo" class="w-full rounded-lg bg-white bg-opacity-60 text-sm p-2">
            </div>

            <!-- Tombol Selanjutnya -->
            <div class="text-right pt-4">
                <button type="submit" class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700">Selanjutnya</button>
            </div>
        </form>
    </div>
</div>
@endsection
