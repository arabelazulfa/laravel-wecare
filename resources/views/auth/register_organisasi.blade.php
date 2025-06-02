@if ($errors->any())
  <div class="text-red-500 text-xs mb-2">
    <ul>
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
  <title>Daftar Organisasi - WeCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-[#FCE9E9] min-h-screen flex flex-col items-center pt-8 px-4">

  <!-- Header -->
  <div class="bg-[#F19494] rounded-lg w-full max-w-md text-white text-center py-3 font-semibold text-lg mb-6 shadow-md">
    WeCare
  </div>

  <!-- Form Registrasi Organisasi -->
  <form method="POST" action="{{ route('register.organisasi.step1') }}"
        class="bg-[#FDCACA] rounded-xl w-full max-w-md p-6 space-y-4 shadow-lg">
    @csrf

    <h2 class="text-center text-black text-2xl font-semibold mb-4">Daftar Organisasi</h2>

    <!-- Narahubung Section -->
    <div class="pt-1 pb-2 border-b border-pink-400">
      <p class="font-semibold text-lg">Narahubung</p>
    </div>

    <!-- Nama Narahubung -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Narahubung</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="text" name="contact_name" required placeholder="Nama Lengkap"
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

    <!-- Nomor Telepon -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
      <div class="bg-white p-3 rounded-lg shadow">
        <input type="tel" name="phone" required placeholder="08xxxxxxxxxx"
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
        <input type="password" name="password_confirmation" required placeholder="Ulangi Password"
               class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
      </div>
    </div>

    <!-- Tombol -->
    <button type="submit"
            class="w-full bg-[#4A7CFD] text-white font-semibold py-2 rounded-lg hover:bg-[#3a66d9] transition-colors mt-2">
      Selanjutnya
    </button>

    <!-- Link Login -->
    <p class="text-center text-xs text-black mt-2">
      Sudah punya akun organisasi?
      <a class="text-[#4A7CFD] font-semibold hover:underline" href="/login">Masuk</a>
    </p>
  </form>
</body>
</html>
