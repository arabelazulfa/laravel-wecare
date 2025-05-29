@props(['title', 'organizer', 'date', 'location', 'registrationDeadline', 'image', 'tags'])

<article class="bg-[#f7a9a9] rounded-lg p-3 flex flex-col select-none" role="article">
  <img src="{{ $image }}" alt="Event image" class="rounded-md mb-2" width="400" height="200" />
  <div class="flex space-x-2 mb-2">
    @foreach(explode(',', $tags) as $tag)
      <span class="bg-white text-[10px] text-black rounded-full px-2 py-0.5 font-normal">
        {{ $tag }}
      </span>
    @endforeach
  </div>
  <h3 class="text-xs font-semibold mb-1 text-black leading-tight">
    {{ $title }}
  </h3>
  <p class="text-[10px] text-black font-normal mb-1">
    {{ $organizer }}
  </p>
  <ul class="text-[9px] text-black font-normal space-y-0.5 mb-1 list-none">
    <li><i class="far fa-calendar-alt mr-1"></i>{{ $date }}</li>
    <li><i class="fas fa-map-marker-alt mr-1"></i>{{ $location }}</li>
    <li><i class="far fa-clock mr-1"></i>Batas registrasi : {{ $registrationDeadline }}</li>
  </ul>
</article>