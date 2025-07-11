@extends('layouts.app')

@section('title', 'Registrasi Akun Organisasi - WeCare')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger text-sm text-red-600 mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-[#FCE9E9] min-h-screen flex flex-col items-center pt-8 px-4">

  
  <div class="bg-[#F19494] rounded-lg w-full max-w-md text-white text-center py-3 font-semibold text-lg mb-6 shadow-md">
    WeCare
  </div>

  <main class="w-full max-w-md bg-[#FDCACA] rounded-xl p-6 shadow-lg">

    <h1 class="text-center text-black text-2xl font-semibold mb-6">Registrasi Akun Organisasi</h1>

    <form method="POST" action="{{ route('register.organisasi.detail.store') }}" enctype="multipart/form-data" class="space-y-5 text-black text-sm font-normal">
      @csrf

      <div>
        <label for="nama-organisasi" class="block mb-1 font-semibold text-gray-700">Nama Organisasi</label>
        <input id="nama-organisasi" name="org_name" type="text" placeholder="Masukkan Nama"
          class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
      </div>

      <div>
        <label for="tipe-organisasi" class="block mb-1 font-semibold text-gray-700">Tipe Organisasi</label>
        <select id="tipe-organisasi" name="org_type"
          class="w-full rounded-lg px-4 py-3 bg-white shadow text-black focus:outline-none focus:ring-2 focus:ring-[#F19494]">
          <option value="" disabled selected>Pilih</option>
          <option value="Komunitas">Komunitas</option>
          <option value="NGO">NGO</option>
          <option value="Perusahaan">Perusahaan</option>
        </select>
      </div>

      <div>
        <label for="tanggal-berdiri" class="block mb-1 font-semibold text-gray-700">Tanggal Berdiri</label>
        <input id="tanggal-berdiri" name="established_date" type="date"
          class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
      </div>

      <div>
        <label for="lokasi" class="block mb-1 font-semibold text-gray-700">Lokasi</label>
        <input id="lokasi" name="location" type="text" placeholder="Masukkan Detail Lokasi"
          class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
      </div>

      <div>
        <label for="deskripsi-singkat" class="block mb-1 font-semibold text-gray-700">Deskripsi Singkat</label>
        <textarea id="deskripsi-singkat" name="description" rows="3" placeholder="Masukkan Deskripsi Singkat"
          class="w-full rounded-lg px-4 py-3 bg-white shadow resize-none focus:outline-none focus:ring-2 focus:ring-[#F19494]"></textarea>
      </div>

      <div>
        <label for="fokus-utama" class="block mb-1 font-semibold text-gray-700">Fokus Utama</label>
        <select id="fokus-utama" name="focus_area"
          class="w-full rounded-lg px-4 py-3 bg-white shadow text-black focus:outline-none focus:ring-2 focus:ring-[#F19494]">
          <option value="" disabled selected>Pilih</option>
          <option value="Pendidikan">Pendidikan</option>
          <option value="Kesehatan">Kesehatan</option>
          <option value="Lingkungan">Lingkungan</option>
        </select>
      </div>



      <div class="flex space-x-4">
        <div class="flex-1">
          <label for="provinsi" class="block mb-1 font-semibold text-gray-700">Provinsi</label>
          <input id="provinsi" name="province" type="text" placeholder="Masukkan"
            class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
        </div>
        <div class="flex-1">
          <label for="kabupaten-kota" class="block mb-1 font-semibold text-gray-700">Kabupaten/Kota</label>
          <input id="kabupaten-kota" name="city" type="text" placeholder="Masukkan"
            class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
        </div>
        <div class="flex-[0.8]">
          <label for="kodepos" class="block mb-1 font-semibold text-gray-700">Kodepos</label>
          <input id="kodepos" name="postal_code" type="text" placeholder="Masukkan"
            class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
        </div>
      </div>

      <div>
        <label for="no-telp" class="block mb-1 font-semibold text-gray-700">No. Telp Organisasi</label>
        <input id="no-telp" name="org_phone" type="text" placeholder="Masukkan Nomor Telepon"
          class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
      </div>

      <div>
        <label for="website" class="block mb-1 font-semibold text-gray-700">Website</label>
        <input id="website" name="website" type="text" placeholder="Masukkan Website Organisasi"
          class="w-full rounded-lg px-4 py-3 bg-white shadow focus:outline-none focus:ring-2 focus:ring-[#F19494]" />
      </div>

      <div>
        <label for="logo" class="block mb-1 font-semibold text-gray-700">Logo</label>
        <div class="bg-white p-3 rounded-lg shadow">
          <input type="file" id="logo" name="logo" class="w-full text-sm text-black" />
        </div>
      </div>

      
      <button type="submit"
              class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg hover:bg-[#3a66d9] transition-colors mt-2">
        Selanjutnya
      </button>
    </form>
  </main>
</div>

@endsection
