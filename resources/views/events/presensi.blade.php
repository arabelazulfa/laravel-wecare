@extends('layouts.dashboardorg')

@section('title', 'Presensi')

@section('content')
<div class="max-w-6xl mx-auto mt-6">
    <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Presensi - {{ $event->title }}</h2>

        @if($event->presensis->count())
        <table class="min-w-full table-auto text-sm text-left border border-gray-200">
            <thead class="bg-pink-200 text-gray-800 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Waktu Presensi</th>
                    <th class="px-4 py-2 border">Foto Presensi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($event->presensis as $presensi)
                <tr class="hover:bg-pink-50">
                    <td class="px-4 py-2 border">{{ $presensi->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($presensi->attendance_time)->format('d M Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        @if ($presensi->attendance_photo)
                            <img src="{{ asset('storage/' . $presensi->attendance_photo) }}"
                                 alt="Foto Presensi"
                                 class="h-16 w-16 object-cover rounded-md border">
                        @else
                            <span class="text-gray-400 italic">Belum ada foto</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="text-gray-500">Belum ada data presensi.</p>
        @endif
    </div>
</div>
@endsection
