@props(['event', 'user'])

@php
  $overlayId = 'presensi-overlay-' . $event->id;
@endphp

<div id="{{ $overlayId }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden" style="display: none;">
  <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-md relative">
    <button onclick="togglePresensi('{{ $overlayId }}', false)"
            class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>

    <h2 class="text-lg font-bold text-center text-black mb-4">Form Presensi</h2>

    <form 
      method="POST" 
      action="{{ route('presensi.store') }}" 
      enctype="multipart/form-data" 
      class="space-y-4"
      x-data="{ isSubmitting: false }"
      @submit.prevent="isSubmitting = true; $el.submit()"
    >
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
        <input type="file" name="attendance_photo" accept=".jpg,.jpeg,.png" class="w-full border p-1 rounded" required>
        <label class="block text-[15px] font-regular">file yang diterima: jpg, jpeg, png</label>
      </div>

      {{-- submit --}}
      <button type="submit" :disabled="isSubmitting" class="w-full py-3 px-4 rounded-lg font-semibold text-white text-base transition-all duration-200
                     bg-violet-600 hover:bg-violet-700
                     disabled:opacity-50 disabled:cursor-not-allowed">
      
        <template x-if="!isSubmitting">
          <span>Kirim Presensi</span>
        </template>
      
        <template x-if="isSubmitting">
          <span>Mengirim...</span>
        </template>
      </button>
    </form>
  </div>
</div>
