@extends('layouts.dashboardorg')

@section('title', 'Sertifikasi')

@section('content')
    <div class="mt-6 space-y-6">
        @forelse ($events as $event)
            <div class="bg-[#ffeaea] p-4 rounded-xl shadow-md">
                <h2 class="text-base font-semibold mb-3">{{ $event->title }}</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-[#f28b8b] bg-white rounded-xl overflow-hidden">
                        <thead class="bg-[#fffff] text-[#f28b8b]">
                            <tr>
                                <th class="border px-4 py-2 text-left font-medium">Nama</th>
                                <th class="border px-4 py-2 text-left font-medium">Kehadiran</th>
                                <th class="border px-4 py-2 text-left font-medium">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($event->presensis as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $p->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $p->status ?? 'Hadir' }}</td>
                                    <td class="border px-4 py-2">
                                        @php
                                            $cert = $event->certificates->firstWhere('user_id', $p->user_id);
                                        @endphp

                                        @if ($cert)
                                            <button class="bg-white border border-gray-300 text-gray-500 px-3 py-1 rounded shadow text-xs cursor-not-allowed" disabled>
                                                Terkirim
                                            </button>
                                        @else
                                            <form action="{{ route('sertifikat.upload', $p->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                                @csrf
                                                <input type="file" name="sertifikat" accept=".pdf,.jpg,.png" required onchange="previewSertifikat(event, {{ $p->id }})" class="text-sm text-gray-600">
                                                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1.5 rounded shadow text-sm">
                                                    Kirim
                                                </button>
                                            </form>
                                            <div id="preview-{{ $p->id }}" class="text-xs text-gray-500 mt-1"></div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 text-center text-gray-500 text-sm">Belum ada peserta</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 text-sm">Belum ada event dengan presensi peserta.</p>
        @endforelse
    </div>

    <script>
        function previewSertifikat(event, id) {
            const fileName = event.target.files[0]?.name || 'File belum dipilih';
            document.getElementById('preview-' + id).innerText = "File dipilih: " + fileName;
        }
    </script>
@endsection
