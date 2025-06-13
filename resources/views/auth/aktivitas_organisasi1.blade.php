@extends('layouts.dashboardorg')

@section('title', 'Aktivitas')

@section('content')
  <section class="bg-white rounded-xl shadow px-6 py-5 max-w-5xl mt-8">
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-bold text-black text-sm">Aktivitas saya</h2>

      <!-- Tombol Tambah Aktivitas yang diarahkan ke route -->
      <a href="{{ route('aktivitas.tambah') }}">
        <button class="bg-green-600 text-white text-xs font-semibold rounded-full px-3 py-1 flex items-center space-x-1" type="button">
          <i class="fas fa-plus text-[10px]"></i>
          <span>Tambah Aktivitas</span>
        </button>
      </a>
    </div>
    <p class="text-sm text-gray-600">Belum ada aktivitas yang ditambahkan.</p>
  </section>
@endsection
