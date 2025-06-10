@extends('layouts.dashboard')

@section('title', 'Wecare Sertifikat')

@section('page-title', 'Sertifikat')

@section('content')
  <h2 class="text-pink-900 font-semibold text-sm mb-3 select-none">
    Sertifikat dimiliki
  </h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    {{-- Ulangi komponen card sertifikat sebanyak yang dibutuhkan --}}
    @for ($i = 0; $i < 6; $i++)
    <article class="bg-pink-100 rounded-lg p-3 flex flex-col space-y-2 {{ $i == 0 ? 'border-4 border-blue-400' : '' }}">
      <img src="https://storage.googleapis.com/a1aa/image/540fae5b-9a71-4e03-f5e5-8a95f84221e9.jpg"
           alt="Certificate image" class="rounded" width="200" height="120" />
      <div class="text-pink-900 font-bold text-xs leading-tight select-none">Gerakan Bersih Semarang Tengah</div>
      <div class="text-pink-900 font-semibold text-xs select-none">PeduliBangsa</div>
      <div class="text-pink-900 text-[8px] select-none">No. Sertifikat : ABC125GHLJ00</div>
      <div class="text-pink-900 text-[8px] select-none">Tanggal Berlaku : 29 Maret 2020</div>
      <div class="flex space-x-3 pt-1">
        <button class="bg-white text-pink-900 text-xs font-semibold rounded px-3 py-1 select-none">Preview</button>
        <button class="bg-white text-pink-900 text-xs font-semibold rounded px-3 py-1 select-none">Unduh</button>
      </div>
    </article>
    @endfor
  </div>
@endsection
