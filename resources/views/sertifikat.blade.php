@extends('layouts.dashboard')

@section('title', 'Wecare Sertifikat')

@section('header', 'Sertifikat')

@section('content')
    <h2 class="text-xl font-semibold mb-2">Sertifikat dimiliki</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

    @forelse ($certificates as $cert)
    <article class="bg-pink-100 rounded-lg p-3 flex flex-col space-y-2">
      <div class="w-full flex justify-center">
      <img src="{{ asset('storage/' . $cert->file_path) }}" alt="Certificate image" class="rounded" width="200"
      height="120" />
      </div>

      <div class="text-pink-900 font-bold text-xs leading-tight select-none">{{ $cert->title }}</div>
      <div class="text-pink-900 font-semibold text-xs select-none">{{ $cert->organizer }}</div>
      <div class="text-pink-900 text-[15px] select-none">Event : {{ $cert->event->title ?? '-' }}</div>
      <div class="text-pink-900 text-[15px] select-none">Tanggal Berlaku :
      {{ \Carbon\Carbon::parse($cert->issued_at)->format('d M Y') }}
      </div>
      <div class="flex space-x-3 pt-1">
      <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank"
      class="bg-white text-pink-900 text-xs font-semibold rounded px-3 py-1 select-none">Preview</a>

      <a href="{{ asset('storage/' . $cert->file_path) }}" download
      class="bg-white text-pink-900 text-xs font-semibold rounded px-3 py-1 select-none">Unduh</a>

      </div>
    </article>
    @empty
    <p class="text-gray-600">Belum ada sertifikat</p>
    @endforelse

    </div>
@endsection