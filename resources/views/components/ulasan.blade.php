@props(['event_id'])

<div id="ulasan{{ $event_id }}"
     class="fixed inset-0 bg-black/50 z-50 hidden justify-center items-center">
  <div class="bg-white rounded-xl p-6 w-full max-w-md relative">
    <button onclick="closeUlasan('{{ $event_id }}')" class="absolute top-2 right-2">&times;</button>

    <h2 class="text-lg font-bold mb-4">Beri Ulasan</h2>

    <form action="{{ route('ulasan.store') }}" method="POST">
      @csrf
      <input type="hidden" name="event_id" value="{{ $event_id }}">

      <textarea name="review" rows="4" class="w-full border rounded-lg p-2" required
                placeholder="Tulis ulasanmu…"></textarea>

      <div class="text-right mt-4">
        <button type="button" onclick="closeUlasan('{{ $event_id }}')" class="bg-gray-300 px-4 py-2 rounded">
          Batal
        </button>
        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded">
          Kirim
        </button>
      </div>
    </form>
  </div>
</div>
