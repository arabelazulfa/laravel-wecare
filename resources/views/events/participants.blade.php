@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Peserta - {{ $event->title }}</h2>

    <div class="bg-white p-6 rounded-xl shadow">
        @if($event->participants->count())
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                @foreach($event->participants as $participant)
                    <li>{{ $participant->name }} - {{ $participant->email }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada peserta terdaftar.</p>
        @endif
    </div>
</div>
@endsection
