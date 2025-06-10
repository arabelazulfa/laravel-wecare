<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WeCare - Aktivitas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-[#fff0f0] min-h-screen flex items-start p-6 font-sans">

  <!-- Sidebar -->
  <aside class="bg-[#f28b8b] text-white w-52 min-h-[90vh] rounded-2xl p-4 flex flex-col shadow-md">
    <div class="text-xl font-bold mb-6">WeCare</div>
    <nav class="flex flex-col space-y-3 text-sm font-medium">
      <a href="/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition">
        <i class="fas fa-home text-base"></i> <span>Dashboard</span>
      </a>
      <a href="/aktivitas" class="flex items-center gap-3 bg-white text-[#f28b8b] rounded-lg px-4 py-2 shadow hover:brightness-95">
        <i class="fas fa-wave-square text-base"></i> <span>Aktivitas</span>
      </a>
      <a href="/sertifikat" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition">
        <i class="fas fa-certificate text-base"></i> <span>Sertifikat</span>
      </a>
      <a href="/edit-organisasi" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition">
        <i class="fas fa-user-edit text-base"></i> <span>Edit Data Organisasi</span>
      </a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 ml-8">
    <!-- Header -->
    <header class="bg-[#f28b8b] text-white rounded-2xl px-6 py-4 flex items-center justify-between shadow-md">
      <div class="font-semibold text-xl">
        Aktivitas
      </div>
      <!-- Icons & Profile Dropdown -->
      <div class="flex space-x-6 text-white text-lg items-center">
        <a href="/messages" title="Messages">
          <i class="far fa-comment-alt fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
        </a>
        <a href="/notifications" title="Notifications">
          <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
        </a>
      
        <!-- Profile button with dropdown -->
        <div class="relative">
          <button id="profileButton" class="text-white hover:scale-110 transition-transform duration-200">
            <i class="far fa-user-circle fa-lg"></i>
          </button>
          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-40 bg-rose-400 text-white rounded-md shadow-lg z-50">
            <ul class="p-3 space-y-2 font-semibold text-sm">
              <li><a href="/dashboard" class="block hover:underline">Dashboard</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left hover:underline">Log Out</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <!-- Content: Tambah Aktivitas -->
    @yield('content')
    </main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profileBtn = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');

    profileBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      profileMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', function () {
      if (!profileMenu.classList.contains('hidden')) {
        profileMenu.classList.add('hidden');
      }
    });
  });
</script>

</body>
</html>
