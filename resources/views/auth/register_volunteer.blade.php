@if ($errors->any())
  <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
    <ul class="text-sm pl-5 list-disc">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Volunteer - WeCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<script>
  document.querySelector("form").addEventListener("submit", function(e) {
    const password = document.querySelector("input[name='password']");
    const confirmPassword = document.querySelector("input[name='password_confirmation']");
    const phone = document.querySelector("input[name='phone']");

    // Cek panjang password
    if (password.value.length < 6) {
      alert("Password minimal 6 karakter");
      password.focus();
      e.preventDefault(); // stop submit
      return;
    }

    // Cek konfirmasi password
    if (password.value !== confirmPassword.value) {
      alert("Konfirmasi password tidak sama");
      confirmPassword.focus();
      e.preventDefault();
      return;
    }

    // Cek no HP: hanya angka dan minimal 10 digit
    const phoneRegex = /^[0-9]{10,}$/;
    if (!phoneRegex.test(phone.value)) {
      alert("Nomor HP harus angka dan minimal 10 digit");
      phone.focus();
      e.preventDefault();
      return;
    }
  });
</script>

<body class="bg-[#FCE9E9] min-h-screen flex flex-col items-center pt-8 px-4">

  <!-- Header -->
  <div class="bg-[#F19494] rounded-lg w-full max-w-md text-white text-center py-3 font-semibold text-lg mb-6 shadow-md">
    WeCare
  </div>

  <!-- Form -->
  <form method="POST" action="{{ route('register.volunteer') }}" enctype="multipart/form-data"
        class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6 space-y-4 shadow-lg">
    @csrf
    <h2 class="text-center text-black text-2xl font-semibold mb-4">Daftar Volunteer</h2>

    <!-- Nama -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="text" name="name" required placeholder="Nama lengkap"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <!-- Email -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="email" name="email" required placeholder="Email aktif"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <!-- No Telp -->
     <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="text" name="phone" required placeholder="08xxxxxxxxxx"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <!-- Password -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="password" name="password" required placeholder="Password"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <!-- Konfirmasi Password -->
     <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="password" name="password_confirmation" required placeholder="Ulangi password"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <div class="pt-3 border-t border-pink-400">
        <p class="font-semibold text-xl mb-2">Data Diri</p>
    </div>

    <!-- Gender -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
        <div class="flex items-center gap-6">
          <label class="inline-flex items-center text-sm font-medium text-gray-700 mb-2">
            <input type="radio" name="gender" required class="form-radio text-pink-400">
            <span class="ml-1">Laki-Laki</span>
          </label>
          <label class="inline-flex items-center text-sm font-medium text-gray-700 mb-2">
            <input type="radio" name="gender" required class="form-radio text-pink-400">
            <span class="ml-1">Perempuan</span>
          </label>
        </div>
      </div>

    <!-- Tanggal Lahir -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
        <div class="bg-white p-3 rounded-lg shadow">
          <input type="date" name="birthdate" required
                 class="w-full text-sm text-gray-700 focus:outline-none">
        </div>
      </div>

    <!-- Minat -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="minat1" class="block text-sm font-medium text-gray-700 mb-1">Minat 1</label>
          <select id="minat1" name="minat1" required class="w-full rounded-md px-3 py-2 text-sm text-gray-700">
            <option disabled selected>Pilih Minat</option>
            <option>Kemanusiaan</option>
            <option>Kesehatan</option>
            <option>Kepemimpinan</option>
            <option>Ketenagakerjaan</option>
            <option>Lingkungan</option>
            <option>Bencana Alam</option>
          </select>
        </div>
        <div>
          <label for="minat2" class="block text-sm font-medium text-gray-700 mb-1">Minat 2</label>
          <select id="minat2" name="minat2" required class="w-full rounded-md px-3 py-2 text-sm text-gray-700">
            <option disabled selected>Pilih Minat</option>
            <option>Kemanusiaan</option>
            <option>Kesehatan</option>
            <option>Kepemimpinan</option>
            <option>Ketenagakerjaan</option>
            <option>Lingkungan</option>
            <option>Bencana Alam</option>
          </select>
        </div>
      </div>


    <!-- Provinsi -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
        <div class="bg-white p-3 rounded-lg shadow">
          <input type="text" name="province" required placeholder="Contoh: Jawa Barat"
                 class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
        </div>
      </div>

    <!-- Kota -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
        <div class="bg-white p-3 rounded-lg shadow">
          <input type="text" name="city" required placeholder="Contoh: Bandung"
                 class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
        </div>
      </div>

    <!-- Profesi -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Profesi</label>
        <div class="bg-white p-3 rounded-lg shadow">
          <input type="text" name="profession" required placeholder="Contoh: Mahasiswa"
                 class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
        </div>
      </div>

    <!-- Upload KTP -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Upload KTP</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="file" name="ktp" required
             class="block w-full text-sm text-gray-700 file:border file:rounded-lg file:px-3 file:py-1 file:bg-[#FCE9E9] file:text-gray-700 file:cursor-pointer">
      </div>
    </div>

    <!-- Submit -->
    <button type="submit"
            class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg hover:bg-[#3a66d9] transition-colors mt-2">
      Daftar
    </button>

    <!-- Link Login -->
    <p class="text-center text-xs text-black mt-2">
      Sudah punya akun?
      <a class="text-[#4A7CFD] font-semibold hover:underline" href="/login">Masuk</a>
    </p>
  </form>
</body>
</html>
