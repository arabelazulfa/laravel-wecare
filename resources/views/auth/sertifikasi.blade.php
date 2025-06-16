@extends('layouts.dashboardorg')

@section('title', 'Sertifikasi')

@section('content')
    <div class="mt-6 bg-[#ffeaea] p-6 rounded-2xl shadow-md">
        <h2 class="text-lg font-semibold mb-4">Daftar Peserta</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl overflow-hidden">
                <thead class="bg-white text-[#f28b8b] border-b-2 border-[#f28b8b]">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Nama</th>
                        <th class="text-left px-6 py-3 font-semibold">Kehadiran</th>
                        <th class="text-left px-6 py-3 font-semibold">Sertifikat</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($peserta as $p)
                        <tr class="border-t border-gray-200">
                            <td class="px-6 py-4">{{ $p->user->name }}</td>
                            <td class="px-6 py-4">Hadir</td>
                            <td class="px-6 py-4">
                                @if ($p->certificate)
                                    {{-- Tombol "Terkirim" --}}
                                    <button class="bg-white border border-gray-300 text-gray-500 px-4 py-2 rounded shadow cursor-not-allowed" disabled>
                                        Terkirim
                                    </button>
                                @else
                                    {{-- Form Upload Sertifikat --}}
                                    <form action="{{ route('sertifikat.upload', $p->id) }}" method="POST"
                                        enctype="multipart/form-data" class="flex flex-col space-y-2">
                                        @csrf
                                        <div class="flex items-center space-x-2">
                                            <input type="file" name="sertifikat" accept=".pdf,.jpg,.png" required
                                                onchange="previewSertifikat(event, {{ $p->id }})"
                                                class="text-sm text-gray-600">
                                            <button type="submit"
                                                class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-1.5 rounded shadow text-sm">
                                                Kirim
                                            </button>
                                        </div>
                                        <div id="preview-{{ $p->id }}" class="text-sm text-gray-500"></div>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada peserta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function previewSertifikat(event, id) {
            const fileName = event.target.files[0]?.name || 'File belum dipilih';
            document.getElementById('preview-' + id).innerText = "File dipilih: " + fileName;
        }
    </script>
@endsection
