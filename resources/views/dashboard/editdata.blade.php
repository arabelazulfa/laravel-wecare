@extends('layouts.app')
@section('title', 'Edit Data Organisasi')
@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Data Organisasi</h1>
    
    <form action="{{ route('organisasi.update',$profile->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- contoh field -->
        <div class="mb-4">
            <label class="block mb-1">Nama Organisasi</label>
            <input type="text" name="nama_organisasi" class="w-full border rounded p-2" value="{{ $profile->nama_organisasi }}">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
