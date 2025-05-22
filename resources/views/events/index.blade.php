<h1>Daftar Event</h1>

@foreach($events as $event)
    <div>
        <h2>{{ $event->title }}</h2>
        <p>{{ $event->description }}</p>
        <a href="/events/{{ $event->id }}">Lihat Detail</a>
    </div>
@endforeach
