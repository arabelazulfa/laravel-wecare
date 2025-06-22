@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')

@section('content')


<div class="flex items-center justify-between max-w-5xl mx-auto mt-8 mb-2 px-2">
    <h2 class="font-bold text-black text-xl">Aktivitas saya</h2>
    <a href="{{ route('aktivitas.tambah') }}">
        <button class="bg-green-600 text-white text-xs font-semibold rounded-full px-4 py-2 flex items-center space-x-2 hover:bg-green-700 transition">
            <i class="fas fa-plus text-xs"></i>
            <span>Tambah Aktivitas</span>
        </button>
    </a>
</div>

<section class="bg-white rounded-xl shadow px-6 py-5 max-w-5xl mx-auto">

    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($events) && $events->count())
        @foreach($events as $activity)
            <a href="{{ route('events.show', $activity->id) }}" class="block hover:no-underline">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 p-4 flex items-center space-x-4 hover:shadow-md transition">
                    
                    <div class="w-24 h-24 overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/' . $activity->photo) }}" alt="Banner" class="w-full h-full object-cover">
                    </div>

                   
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-gray-800">{{ $activity->title }}</h3>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>{{ $activity->location }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                            {{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-clock mr-2 text-gray-500"></i>
                            {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }} WIB
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    @else
        <p class="text-sm text-gray-600">Belum ada aktivitas yang ditambahkan.</p>
    @endif
</section>
@endsection
