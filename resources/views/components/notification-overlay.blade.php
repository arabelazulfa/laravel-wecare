@props(['notifications'])

<div class="fixed top-20 right-6 max-w-md w-full space-y-4 z-50">
    @foreach ($notifications as $notif)
        <div class="bg-[#F7E6E6] p-4 rounded shadow-md @if($notif->is_urgent) border-l-4 border-red-500 @endif">
            <p class="font-semibold text-sm leading-tight mb-1 {{ $notif->is_urgent ? 'text-red-600' : 'text-gray-800' }}">
                {{ $notif->title }}
            </p>
            <p class="text-xs leading-tight text-gray-700">{{ $notif->message }}</p>

            @if ($notif->link)
                <a href="{{ $notif->link }}" class="text-xs text-blue-500 underline mt-2 inline-block">Lihat detail</a>
            @endif

            <p class="text-xs text-right text-gray-500 mt-2">{{ $notif->created_at->format('Y.m.d H:i') }}</p>

            @if ($notif->is_urgent)
                <div class="mt-3 text-right">
                    <a href="{{ $notif->link ?? '#' }}" class="bg-red-500 text-white text-xs font-semibold rounded px-4 py-2 hover:bg-red-600 transition">
                        Gabung Sekarang!
                    </a>
                </div>
            @endif
        </div>
    @endforeach
</div>
