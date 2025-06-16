<div id="ulasan-show-{{ $event_id }}"
     class="fixed inset-0 bg-black/50 z-50 hidden justify-center items-center">
  <div class="bg-white rounded-xl p-6 w-full max-w-md relative">
    <button onclick="closeReview('{{ $event_id }}')" class="absolute top-2 right-2">&times;</button>

    <h2 class="text-lg font-bold mb-4">Ulasan Kamu</h2>
    <p class="whitespace-pre-line text-gray-800">{{ $review }}</p>

    <div class="text-right mt-4">
      <button onclick="closeReview('{{ $event_id }}')" class="bg-violet-500 text-white px-4 py-2 rounded">
        Tutup
      </button>
    </div>
  </div>
</div>
