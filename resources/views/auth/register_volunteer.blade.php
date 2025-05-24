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
    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="text" name="name" required placeholder="Nama lengkap"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Email -->
    <label class="block text-sm font-medium text-gray-700">Email</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="email" name="email" required placeholder="Email aktif"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- No Telp -->
    <label class="block text-sm font-medium text-gray-700">No Telepon</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="text" name="phone" required placeholder="08xxxxxxxxxx"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Password -->
    <label class="block text-sm font-medium text-gray-700">Password</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="password" name="password" required placeholder="Password"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Konfirmasi Password -->
    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="password" name="password_confirmation" required placeholder="Ulangi password"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Gender -->
    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <div class="flex gap-4 text-sm text-gray-700">
        <label><input type="radio" name="gender" value="Laki-laki" required> Laki-laki</label>
        <label><input type="radio" name="gender" value="Perempuan"> Perempuan</label>
      </div>
    </div>

    <!-- Tanggal Lahir -->
    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="date" name="birthdate" required
             class="w-full text-sm text-gray-700 focus:outline-none">
    </div>

    <!-- Minat -->
    <label class="block text-sm font-medium text-gray-700">Minat</label>
    <div class="bg-white p-3 rounded-lg shadow text-sm text-gray-700">
      <label class="block"><input type="checkbox" name="interests[]" value="Kemanusiaan"> Kemanusiaan</label>
      <label class="block"><input type="checkbox" name="interests[]" value="Lingkungan"> Lingkungan</label>
      <label class="block"><input type="checkbox" name="interests[]" value="Ketenagakerjaan"> Ketenagakerjaan</label>
    </div>

    <!-- Provinsi -->
    <label class="block text-sm font-medium text-gray-700">Provinsi</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="text" name="province" required placeholder="Contoh: Jawa Barat"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Kota -->
    <label class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="text" name="city" required placeholder="Contoh: Bandung"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Profesi -->
    <label class="block text-sm font-medium text-gray-700">Profesi</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="text" name="profession" required placeholder="Contoh: Mahasiswa"
             class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
    </div>

    <!-- Upload KTP -->
    <label class="block text-sm font-medium text-gray-700">Upload KTP</label>
    <div class="bg-white p-3 rounded-lg shadow">
      <input type="file" name="ktp" required
             class="block w-full text-sm text-gray-700 file:border file:rounded-lg file:px-3 file:py-1 file:bg-[#FCE9E9] file:text-gray-700 file:cursor-pointer">
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
