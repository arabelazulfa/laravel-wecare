@props([
  'eventId',
  'title',
  'organizer',
  'date',
  'location',
  'registrationDeadline',
  'image',
  'tags',
  'review' => null
])

@php
$udahPresensi = \App\Models\Presensi::where('user_id', auth()->id())
  ->where('event_id', $eventId)
  ->exists();
@endphp

<article class="bg-[#f7a9a9] rounded-lg p-3 flex flex-col select-none shadow" role="article">
  <img src="{{ $image }}" onerror="this.src='{{ asset('images/default-event.jpg') }}'" alt="Event image"
    class="rounded-md mb-2 w-full h-48 object-cover" />

  <div class="flex flex-wrap gap-1 mb-2">
    @foreach(explode(',', $tags) as $tag)
      <span class="bg-white text-[12px] text-black rounded-full px-2 py-0.5 font-normal">
        {{ $tag }}
      </span>
    @endforeach
  </div>

  <h3 class="text-base font-bold mb-1 text-black leading-tight">{{ $title }}</h3>
  <p class="text-sm text-black font-semibold mb-1">{{ $organizer }}</p>
  <ul class="text-[12px] text-black font-normal space-y-0.5 mb-2 list-none">
    <li><i class="far fa-calendar-alt mr-1"></i>{{ $date }}</li>
    <li><i class="fas fa-map-marker-alt mr-1"></i>{{ $location }}</li>
    <li><i class="far fa-clock mr-1"></i>Batas registrasi: {{ $registrationDeadline }}</li>
  </ul>

  <div class="flex justify-between pt-2">
    {{-- Tombol Presensi --}}
    @if ($udahPresensi)
  <span class="text-base font-semibold text-gray-600">
    Sudah Presensi
  </span>
@else
  <a href="javascript:togglePresensi('presensi-overlay-{{ $eventId }}', true);"
    class="bg-sky-200 text-sky-900 text-xs font-semibold px-5 py-2 rounded-md hover:bg-sky-300 transition">

    Presensi
  </a>
@endif


    {{-- Tombol Ulasan --}}
    @if ($review)
      <button onclick="openReview('{{ $eventId }}')"
              class="bg-gray-500 text-white text-xs font-semibold px-5 py-2 rounded-md">
        Lihat Ulasan
      </button>
      @include('components.lihatulasan', ['event_id' => $eventId, 'review' => $review->review])
    @else
      <button onclick="openUlasan('{{ $eventId }}')"
              class="bg-purple-200 text-purple-900 text-xs font-semibold px-5 py-2 rounded-md hover:bg-purple-300 transition">

        Beri Ulasan
      </button>
      @include('components.ulasan', ['event_id' => $eventId])
    @endif
  </div>
</article>
