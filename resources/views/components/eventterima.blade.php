@props([
  'title', 'organizer', 'date', 'location',
  'registrationDeadline', 'image', 'tags',
  'presensiUrl' => '#', 'ulasanUrl' => '#'
])

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
    <a href="{{ $presensiUrl }}"
      class="bg-white text-black text-xs font-semibold px-3 py-1 rounded-md hover:bg-pink-300 transition">
      Presensi
    </a>
    <a href="{{ $ulasanUrl }}"
      class="bg-white text-black text-xs font-semibold px-3 py-1 rounded-md hover:bg-pink-300 transition">
      Ulasan
    </a>
  </div>
</article>
