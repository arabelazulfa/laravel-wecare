@props([
    'field',          
    'value',          
    'label',          
    'icon'   => false,
    'options' => null
])

<div
    x-data="{
        editing      : false,
        newValue     : @js($value ?? ''),
        /* ==== toast ==== */
        showToast    : false,
        toastMessage : '',
        toastSuccess : true,

        startEdit()  { 
            this.editing = true; 
            this.$nextTick(() => this.$refs.input?.focus());
        },
        cancelEdit() { 
            this.editing = false; 
            this.newValue = @js($value ?? '');
        },

        async saveEdit() {
            try {
                const response = await fetch('{{ route('volunteer.profile.updateField') }}', {
                    method : 'PATCH',
                    headers: {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : document.querySelector('meta[name=csrf-token]').content,
                    },
                    body   : JSON.stringify({
                        field : '{{ $field }}',
                        value : this.newValue,
                    }),
                });

                /* -------- debug / parse -------- */
                const text = await response.text();           // string mentah
                let   data;
                try   { data = JSON.parse(text); }            // coba parse
                catch { throw new Error('Bukan JSON: '+text); }

                if (!response.ok) throw new Error(data.error ?? 'Gagal update');

                /* ======== sukses ======== */
                this.toast(true, 'Berhasil disimpan');
                this.editing = false;

            } catch (err) {
                this.toast(false, err.message);
            }
        },

        toast(ok, msg) {
            this.toastSuccess = ok;
            this.toastMessage = msg;
            this.showToast    = true;
            setTimeout(() => this.showToast = false, 2500);
        }
    }"
    class="flex flex-col mb-3 relative"
>
    
    <label class="text-sm text-gray-600 mb-1">{{ $label }}</label>

    <div class="flex items-center gap-2 bg-pink-100 px-4 py-2 rounded-xl shadow-sm">
        
        <template x-if="!editing">
            <span class="flex-1 text-gray-900 display-value" x-text="newValue || '-'"></span>
        </template>

        <template x-if="editing">
            @if($options)
                <select x-ref="input" x-model="newValue"
                        class="flex-1 text-sm bg-white border border-gray-300 rounded px-2 py-1">
                    <option value="" disabled>Pilih {{ strtolower($label) }}</option>
                    @foreach($options as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            @else
                <input  x-ref="input" x-model="newValue" type="text"
                        class="flex-1 text-sm bg-white border border-gray-300 rounded px-2 py-1"/>
            @endif
        </template>

        
        <template x-if="!editing">
            <button @click="startEdit"
                    class="text-gray-500 hover:text-pink-500 transition"
                    :title="'Edit '+ '{{ $label }}'">
                @if($icon)
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11 5H6a2 2 0 00-2 2v11c0 1.1.9 2 2 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                @else Edit @endif
            </button>
        </template>

        <template x-if="editing">
            <div class="flex gap-1">
                <button @click="saveEdit"   class="text-green-600 hover:text-green-800 text-sm">✔</button>
                <button @click="cancelEdit" class="text-red-600   hover:text-red-800   text-sm">✖</button>
            </div>
        </template>
    </div>

   
    <div x-show="showToast" x-transition
         class="absolute top-full mt-2 left-0 bg-white border rounded px-4 py-2 text-sm shadow"
         :class="toastSuccess ? 'border-green-500 text-green-600'
                              : 'border-red-500 text-red-600'">
        <span x-text="toastMessage"></span>
    </div>
</div>
