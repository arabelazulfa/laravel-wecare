@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@extends('layouts.dashboardorg')

@section('title', 'Tambah Aktivitas - Langkah 2')

@section('content')
<div class="bg-pink-100 min-h-screen py-6 px-10">
    <div class="bg-white bg-opacity-30 rounded-xl p-6 max-w-4xl mx-auto">
        <h2 class="text-center text-lg font-semibold mb-6">Tipe Aktivitas dan Divisi</h2>

        <form action="{{ route('aktivitas.simpan') }}" method="POST">
            @csrf

         
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Jenis Acara</label>
                <input type="text" name="jenis_acara" required class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Jenis Acara">
            </div>

            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Divisi yang Dicari</label>
                <textarea name="divisi" rows="4" required
                    class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm"
                    placeholder="Tuliskan divisi. Gunakan Enter untuk membuat baris baru."></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tugas Relawan</label>
                <textarea name="tugas_relawan" rows="4" required
                    class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm"
                    placeholder="Tuliskan detail tugas. Gunakan Enter untuk membuat baris baru."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kriteria</label>
                <textarea name="kriteria" rows="4" required
                    class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm"
                    placeholder="Tuliskan Kriteria. Gunakan Enter untuk membuat baris baru."></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Total Jam Kerja</label>
                <input type="number" name="total_jam_kerja" required class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Tuliskan Total Jam Kerja">
            </div>

           
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Jumlah Relawan</label>
                <input type="number" name="jumlah_relawan" required class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm" placeholder="Tuliskan Jumlah Relawan yang Dicari">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Relawan Memerlukan CV?</label>
                <select name="butuh_cv" required class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm">
                    <option disabled selected>Pilih</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
            </div>


      
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Mode Darurat</label>
                <select name="mode_darurat" required class="w-full rounded-lg bg-white bg-opacity-60 px-4 py-2 text-sm">
                    <option disabled selected>Pilih</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
            </div>

     
            <p class="text-xs text-gray-600 mb-6">NB: Mode Darurat diutamakan untuk event yang membutuhkan relawan se-segera mungkin, seperti bencana alam atau donor darah.</p>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
