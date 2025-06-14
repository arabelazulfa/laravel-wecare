<div id="suksesGabungOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
  <div class="w-full max-w-sm bg-white border border-gray-200 rounded-md shadow-md p-6 text-center relative">

    {{-- tombol close --}}
    <button type="button"
            class="absolute top-3 right-3 text-black text-lg font-bold focus:outline-none"
            onclick="toggleSuksesGabungOverlay(false)">
      <i class="fas fa-times"></i>
    </button>

    <div class="text-green-600 text-4xl mb-3">
      <i class="fas fa-check-circle"></i>
    </div>

    <h2 class="text-lg font-semibold text-gray-900 mb-2">Pendaftaran Berhasil!</h2>
    <p class="text-gray-600 mb-4">Kamu sudah terdaftar di event ini. Kami akan segera menghubungi kamu.</p>

    <button class="bg-violet-500 hover:bg-violet-600 text-white font-semibold py-2 px-4 rounded-md w-full"
            onclick="toggleSuksesGabungOverlay(false)">
      Tutup
    </button>
  </div>
</div>

<script>
  /*  helper untuk show / hide */
  function toggleGabungOverlay(show) {
    document.getElementById('gabungOverlay')
            .classList.toggle('hidden', !show);
  }
  function toggleSuksesGabungOverlay(show) {
    document.getElementById('suksesGabungOverlay')
            .classList.toggle('hidden', !show);
  }

  /*  listen event sukses dari Alpine  */
  window.addEventListener('pendaftaran-berhasil', () => {
    toggleGabungOverlay(false);      // tutup form
    toggleSuksesGabungOverlay(true); // buka overlay berhasil
  });
</script>
