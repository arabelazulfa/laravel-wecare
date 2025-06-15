{{-- resources/views/dashuser.blade.php --}}
@extends('layouts.dashboard')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Event yang Kamu Ikuti</h2>

    @if($registeredEvents->isEmpty())
        <p class="text-gray-500">Belum ada event yang kamu ikuti atau belum ada yang diterima.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($registeredEvents as $event)
                <x-eventterima :title="$event->title" :organizer="$event->organizer->organizationProfile->org_name ?? $event->organizer->name" :date="$event->start_date . ' - ' . $event->end_date" :location="$event->location"
                    :registrationDeadline="$event->registration_deadline" :image="asset('storage/' . ($event->photo ?? 'images/default-event.jpg'))" :tags="$event->category" :presensiUrl="route('presensi.show', $event->id)"
                    :ulasanUrl="route('ulasan.create', $event->id)" />
            @endforeach
        </div>
    @endif
@endsection