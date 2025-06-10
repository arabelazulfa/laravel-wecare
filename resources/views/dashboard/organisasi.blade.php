@extends('layouts.dashboardorg')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Relawan yang Mendaftar Event</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($pendaftaranRelawan as $relawan)
        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold mb-1">{{ $relawan->nama }}</h2>
            <p class="text-sm text-gray-500 mb-2">{{ $relawan->lokasi }}</p>
            <p class="mb-2"><strong>Deskripsi:</strong> {{ $relawan->deskripsi }}</p>
            <p class="mb-4"><strong>Minat:</strong> {{ $relawan->minat }}</p>

            <div class="flex justify-between mt-4">
                <a href="{{ route('chat.show', ['id' => $relawan->id]) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                    Hubungi
                </a>
                <a href="{{ route('riwayat.show', ['id' => $relawan->id]) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg text-sm">
                    Riwayat
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
