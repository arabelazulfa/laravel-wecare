@extends('layouts.dashboardorg')

@section('title', 'Edit Data Organisasi')

@section('content')
<div x-data="{ openPassword: false }">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-md mt-6">

        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-2xl font-bold text-black mb-6">Edit Data Organisasi</h2>

        <form action="{{ route('organisasi.update', $profile->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

           
            <div>
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Informasi Kontak</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">Nama Kontak</label>
                        <input type="text" name="name" class="input-field" value="{{ old('name', $profile->user->name ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email', $profile->user->email ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">No. Telepon</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $profile->user->phone ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Password</label>
                        <div class="flex items-center justify-between input-field bg-gray-100">
                            <span class="text-gray-500 italic text-sm">********</span>
                            <button type="button" @click="openPassword = true"
                                class="text-blue-500 hover:text-blue-700 text-sm ml-4">
                                <i class="fas fa-pen mr-1"></i> Ubah
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Detail Organisasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">Nama Organisasi</label>
                        <input type="text" name="org_name" class="input-field" value="{{ old('org_name', $profile->org_name ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Tipe Organisasi</label>
                        <input type="text" name="org_type" class="input-field" value="{{ old('org_type', $profile->org_type ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Tanggal Berdiri</label>
                        <input type="date" name="established_date" class="input-field" value="{{ old('established_date', $profile->established_date ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Lokasi</label>
                        <input type="text" name="location" class="input-field" value="{{ old('location', $profile->location ?? '') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">Deskripsi Singkat</label>
                        <textarea name="description" class="input-field" rows="3">{{ old('description', $profile->description ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Fokus Utama</label>
                        <input type="text" name="focus_area" class="input-field" value="{{ old('focus_area', $profile->focus_area ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Provinsi</label>
                        <input type="text" name="province" class="input-field" value="{{ old('province', $profile->province ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Kota/Kabupaten</label>
                        <input type="text" name="city" class="input-field" value="{{ old('city', $profile->city ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Kode Pos</label>
                        <input type="text" name="postal_code" class="input-field" value="{{ old('postal_code', $profile->postal_code ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">No. Telepon Organisasi</label>
                        <input type="text" name="org_phone" class="input-field" value="{{ old('org_phone', $profile->org_phone ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Website</label>
                        <input type="url" name="website" class="input-field" value="{{ old('website', $profile->website ?? '') }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Logo</label>
                        <input type="file" name="logo" accept="image/*" class="input-field">
                        @if ($profile->logo)
                            <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Organisasi"
                                class="mt-2 w-24 h-24 object-cover rounded-md border">
                        @endif
                    </div>
                </div>
            </div>

           
            <div class="pt-6 text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

   
    <div
        x-show="openPassword"
        x-cloak
        class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center"
    >
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Ubah Password</h2>
            <form method="POST" action="{{ route('organisasi.updatePassword', $profile->user_id ?? auth()->id()) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                <label for="current_password" class="block font-medium mb-1">Password Lama</label>
                <input type="password" name="current_password" id="current_password" class="input-field" required>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block font-medium mb-1">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" class="input-field">
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="input-field">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openPassword = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-sm rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<style>
    .input-field {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@endsection
