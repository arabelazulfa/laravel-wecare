@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')

@section('content')
<section class="bg-white rounded-xl shadow px-6 py-5 max-w-5xl mt-8">

    {{-- Alert jika ada pesan sukses dari session --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-black text-sm">Aktivitas saya</h2>

        <a href="{{ route('aktivitas.tambah') }}">
            <button class="bg-green-600 text-white text-xs font-semibold rounded-full px-3 py-1 flex items-center space-x-1" type="button">
                <i class="fas fa-plus text-[10px]"></i>
                <span>Tambah Aktivitas</span>
            </button>
        </a>
    </div>

    @if(isset($events) && $events->count())
        @foreach($events as $activity)
            <div class="bg-white rounded-lg shadow-sm p-4 flex items-start space-x-4 mb-4 border border-gray-200">
                <img src="{{ asset('storage/' . $activity->photo) }}" alt="Banner" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 class="text-base font-semibold">{{ $activity->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $activity->location }}</p>
                    <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($activity->date)->format('d M Y') }} — {{ $activity->time }}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-sm text-gray-600">Belum ada aktivitas yang ditambahkan.</p>
    @endif
</section>
@endsection
