@extends('layouts.app')

@section('title', 'Daftar Organisasi - WeCare')

@section('content')
<div class="flex justify-center items-center min-h-screen px-4">
  <form method="POST" action="{{ route('register.organisasi.step1') }}"
        class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6 space-y-4 shadow-lg">
    @csrf

    <h2 class="text-center text-black text-2xl font-semibold mb-4">Daftar Organisasi</h2>

    <div class="pt-1 pb-2 border-b border-pink-400">
      <p class="font-semibold text-lg">Narahubung</p>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Narahubung</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="text" name="contact_name" required placeholder="Nama Lengkap"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="email" name="email" required placeholder="Email aktif"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="tel" name="phone" required placeholder="08xxxxxxxxxx"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="password" name="password" required placeholder="Password"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="password" name="password_confirmation" required placeholder="Ulangi Password"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <button type="submit"
            class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg hover:bg-[#3a66d9] transition-colors mt-2">
      Selanjutnya
    </button>

    <p class="text-center text-xs text-black mt-2">
      Sudah punya akun organisasi?
      <a class="text-[#4A7CFD] font-semibold hover:underline" href="/login">Masuk</a>
    </p>
  </form>
</div>
@endsection
