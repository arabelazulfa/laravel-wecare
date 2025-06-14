@extends('layouts.dashboardorg')

@section('title', 'Kelola Galeri')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Galeri Organisasi</h2>

        <!-- Form Upload -->
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="mb-6 relative">
            @csrf

            <div class="flex justify-end mb-2">
                <button type="submit" class="px-2.5 py-1 bg-blue-500 text-white text-xs rounded shadow hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </div>

            <input type="file" name="image[]" accept="image/*" multiple required class="block w-full text-sm text-gray-500">
        </form>


        <!-- Galeri List -->
        <div class="grid grid-cols-4 gap-4">
            @forelse ($galleries as $gallery)
                <div class="relative">
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-32 object-cover rounded">
                    <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="absolute top-1 right-1">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 bg-white bg-opacity-70 rounded-full p-1">✕</button>
                    </form>
                </div>
            @empty
                <p class="col-span-4 text-gray-500">Belum ada gambar di galeri.</p>
            @endforelse
        </div>
    </div>
@endsection