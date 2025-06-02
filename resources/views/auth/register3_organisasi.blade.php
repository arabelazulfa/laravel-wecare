@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Preview Pendaftaran Organisasi</h2>

    <div class="card p-4">
        <h4 class="mb-3">Informasi Kontak</h4>
        <p><strong>Nama Kontak:</strong> {{ $step1['name'] }}</p>
        <p><strong>Email:</strong> {{ $step1['email'] }}</p>
        <p><strong>No. Telepon:</strong> {{ $step1['phone'] }}</p>

        <hr>

        <h4 class="mb-3">Detail Organisasi</h4>
        <p><strong>Nama Organisasi:</strong> {{ $step2['nama_organisasi'] }}</p>
        <p><strong>Tipe Organisasi:</strong> {{ $step2['tipe_organisasi'] }}</p>
        <p><strong>Tanggal Berdiri:</strong> {{ $step2['tanggal_berdiri'] }}</p>
        <p><strong>Lokasi:</strong> {{ $step2['lokasi'] }}</p>
        <p><strong>Deskripsi Singkat:</strong> {{ $step2['deskripsi_singkat'] ?? '-' }}</p>
        <p><strong>Fokus Utama:</strong> {{ $step2['fokus_utama'] ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $step2['alamat'] }}</p>
        <p><strong>Provinsi:</strong> {{ $step2['provinsi'] }}</p>
        <p><strong>Kabupaten/Kota:</strong> {{ $step2['kabupaten_kota'] }}</p>
        <p><strong>Kode Pos:</strong> {{ $step2['kodepos'] }}</p>
        <p><strong>No. Telepon Organisasi:</strong> {{ $step2['no_telp'] }}</p>
        <p><strong>Website:</strong> {{ $step2['website'] ?? '-' }}</p>

        @if(isset($step2['logo_path']))
            <p><strong>Logo:</strong></p>
            <img src="{{ asset('storage/' . $step2['logo_path']) }}" alt="Logo Organisasi" width="150">
        @endif

        <form method="POST" action="{{ route('register.organisasi.konfirmasi') }}" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-success">Konfirmasi & Daftar</button>
        </form>
    </div>
</div>
@endsection
