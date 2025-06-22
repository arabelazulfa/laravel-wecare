@extends('layouts.dashboard')

@section('content')
  <h2 class="text-xl font-semibold mb-4">Event yang Kamu Ikuti</h2>

  @if($registeredEvents->isEmpty())
    <p class="text-gray-500">Belum ada event yang kamu ikuti</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($registeredEvents as $event)
    @php
    $review = \App\Models\EventReview::where('user_id', auth()->id())
      ->where('event_id', $event->id)
      ->first();
    @endphp
  
    <x-eventterima :eventId="$event->id" :review="$review" :title="$event->title"
    :organizer="$event->organizer->organizationProfile->org_name ?? $event->organizer->name" :date="$event->start_date . ' - ' . $event->end_date" :location="$event->location" :registrationDeadline="$event->registration_deadline"
    :image="asset('storage/' . ($event->photo ?? 'images/default-event.jpg'))" :tags="$event->category"
    presensiUrl="javascript:togglePresensi('presensi-overlay-{{ $event->id }}', true);" />

    <x-presensi :event="$event" :user="auth()->user()" />
    @endforeach
    </div>
  @endif
@endsection

@push('scripts')
  <script>
  function togglePresensi(id, show) {
  const el = document.getElementById(id);
  if (!el) return;

  if (show) {
    el.classList.remove('hidden');
    el.style.display = 'flex'; 
  } else {
    el.classList.add('hidden');
    el.style.display = 'none';
  }
  }

    function openReview(eventId) {
    const el = document.getElementById('ulasan-show-' + eventId); 
    if (el) {
    el.classList.remove('hidden');
    el.classList.add('flex');
    }
    }

    function closeReview(eventId) {
    const el = document.getElementById('ulasan-show-' + eventId);
    if (el) {
    el.classList.add('hidden');
    el.classList.remove('flex');
    }
    }

    function openUlasan(eventId) {
      const el = document.getElementById('ulasan' + eventId);
      if (el) {
      el.classList.remove('hidden');
      el.classList.add('flex');
      }
    }

    function closeUlasan(eventId) {
      const el = document.getElementById('ulasan' + eventId);
      if (el) {
      el.classList.add('hidden');
      el.classList.remove('flex');
      }
    }
  @stack('scripts')
  </script>
@endpush