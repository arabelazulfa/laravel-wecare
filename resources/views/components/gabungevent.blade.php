<div id="gabungOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
  <div class="w-full max-w-md bg-white border border-gray-200 rounded-md shadow-md p-6 relative">

   
    <button type="button"
            class="absolute top-3 right-3 text-black text-lg font-bold focus:outline-none"
            onclick="toggleGabungOverlay(false)">
      <i class="fas fa-times"></i>
    </button>

    <h2 class="font-semibold text-gray-900 mb-4 text-base">Formulir Pendaftaran</h2>

   
    <form x-data="{
              form: {
                event_id : '{{ $eventId }}',
                reason   : '',
                why_you  : '',
                division : '',
                cv_file  : null
              },
              isSubmitting: false, // << ini buat cegah submit dobel
              async submitForm () {
                if (this.isSubmitting) return;
                this.isSubmitting = true;
    
                const fd = new FormData();
                fd.append('event_id', this.form.event_id);
                fd.append('reason',   this.form.reason);
                fd.append('why_you',  this.form.why_you);
                fd.append('division', this.form.division);
                fd.append('cv_file',  this.form.cv_file);
    
                try {
                  const res = await fetch('{{ route('event.register') }}', {
                    method : 'POST',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body   : fd,
                    credentials: 'same-origin'
                  });
    
                  if (res.ok) {
                    window.dispatchEvent(new CustomEvent('pendaftaran-berhasil'));
                  } else {
                    alert('Gagal mendaftar, coba lagi.');
                  }
                } catch (e) {
                  alert('Terjadi kesalahan saat mengirim data!');
                } finally {
                  this.isSubmitting = false;
                }
              }
            }" x-on:submit.prevent="submitForm" enctype="multipart/form-data">

      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Alasan bergabung</label>
        <textarea x-model="form.reason" required
                  class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm"></textarea>
      </div>

  
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Mengapa Organisasi harus memilih Anda?</label>
        <textarea x-model="form.why_you" required
                  class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm"></textarea>
      </div>

 
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Divisi yang dipilih</label>
        <textarea x-model="form.division" required
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm"></textarea>
    </div>

   
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">Upload CV (PDF)</label>
        <input type="file" accept="application/pdf" required
               @change="form.cv_file = $event.target.files[0]"
               class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm">
      </div>

      
      <button type="submit" :disabled="isSubmitting" class="w-full py-3 px-4 rounded-lg font-semibold text-white text-base transition-all duration-200
                     bg-violet-600 hover:bg-violet-700
                     disabled:opacity-50 disabled:cursor-not-allowed">
      
        <template x-if="!isSubmitting">
          <span>Gabung Sekarang</span>
        </template>
      
        <template x-if="isSubmitting">
          <span>Mengirim...</span>
        </template>
      </button>


    </form>
  </div>
</div>
