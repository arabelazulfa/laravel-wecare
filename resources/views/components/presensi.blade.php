@props(['event', 'user'])

@php  // bikin suffix unik
  $overlayId = 'presensi-overlay-' . $event->id;
@endphp

<div id="{{ $overlayId }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-md relative">
    <button onclick="togglePresensi('{{ $overlayId }}', false)"
            class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>

    <h2 class="text-lg font-bold text-center text-pink-600 mb-4">Form Presensi</h2>

    <form method="POST" action="{{ route('presensi.store') }}" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <input type="hidden" name="event_id" value="{{ $event->id }}">

      <div>
        <label class="block text-sm font-semibold">Nama</label>
        <input type="text" class="w-full border rounded p-2 bg-gray-100"
               value="{{ $user->name }}" readonly>
      </div>

      <div>
        <label class="block text-sm font-semibold">Nama Event</label>
        <input type="text" class="w-full border rounded p-2 bg-gray-100"
               value="{{ $event->title }}" readonly>
      </div>

      <div>
        <label class="block text-sm font-semibold">Waktu Kehadiran</label>
        <input type="datetime-local" name="attendance_time"
               class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block text-sm font-semibold">Upload Bukti Kehadiran</label>
        <input type="file" name="attendance_photo" accept="image/*"
               class="w-full border p-1 rounded" required>
      </div>

      <button type="submit"
              class="w-full bg-pink-500 text-white font-semibold py-2 rounded hover:bg-pink-600">
        Kirim Presensi
      </button>
    </form>
  </div>
</div>
