@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Peserta - {{ $event->title }}</h2>

        @if($event->participants->count())
        <table class="min-w-full table-auto text-sm text-left border border-gray-200">
            <thead class="bg-pink-200 text-gray-800 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">No. Telepon</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($event->participants as $participant)
                <tr class="hover:bg-pink-50">
                    <td class="px-4 py-2 border">{{ $participant->name }}</td>
                    <td class="px-4 py-2 border">{{ $participant->email }}</td>
                    <td class="px-4 py-2 border">{{ $participant->gender }}</td>
                    <td class="px-4 py-2 border">{{ $participant->phone }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="text-gray-500">Belum ada peserta terdaftar.</p>
        @endif
    </div>
</div>
@endsection
