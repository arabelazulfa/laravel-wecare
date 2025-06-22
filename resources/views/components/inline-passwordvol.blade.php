<div x-data="{ open: false }" class="flex flex-col mb-3">
    <label class="text-sm text-gray-600 mb-1">Password</label>
    <div class="flex items-center gap-2 bg-pink-100 px-4 py-2 rounded-xl shadow-sm">
        <span class="flex-1 text-gray-900">********</span>
        <button @click="open = true"
            class="text-gray-500 hover:text-pink-500 transition"
            title="Edit Password">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11 5H6a2 2 0 00-2 2v11c0 1.1.9 2 2 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </button>
    </div>


    <div x-show="open" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div @click.outside="open = false" class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Ubah Password</h3>
            <form method="POST" action="{{ route('volunteer.profile.updatePassword') }}">
                @csrf
                <input type="hidden" name="type" value="password">

                <div class="mb-3">
                    <label class="text-sm text-gray-700">Password Lama</label>
                    <input type="password" name="old_password" required class="w-full px-3 py-2 rounded border mt-1" />
                </div>

                <div class="mb-3">
                    <label class="text-sm text-gray-700">Password Baru</label>
                    <input type="password" name="new_password" required class="w-full px-3 py-2 rounded border mt-1" />
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="new_password_confirmation" required class="w-full px-3 py-2 rounded border mt-1" />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-pink-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div x-show="showToast" x-transition
     class="absolute top-full mt-2 left-0 bg-white border rounded px-4 py-2 text-sm shadow"
     :class="toastSuccess ? 'border-green-500 text-green-600' : 'border-red-500 text-red-600'">
    <span x-text="toastMessage"></span>
</div>
