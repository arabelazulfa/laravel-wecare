<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>WeCare Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-[#fff0f0] min-h-screen flex items-start p-6 font-sans">

  <!-- Sidebar -->
  <aside class="bg-[#f28b8b] text-white w-52 min-h-[90vh] rounded-2xl p-4 flex flex-col shadow-md">
    <a href="{{ route('volunteer.events') }}" class="text-xl font-bold text-white hover:text-gray-200 mb-6">WeCare</a>
    <nav class="flex flex-col space-y-3 text-sm font-medium">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition
          {{ request()->routeIs('dashboard') ? 'bg-white text-[#f28b8b] shadow' : '' }}">
        <i class="fas fa-home text-base"></i> <span>Dashboard</span>
      </a>

      <a href="{{ route('certificates.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition
          {{ request()->routeIs('certificates.index') ? 'bg-white text-[#f28b8b] shadow' : '' }}">
        <i class="fas fa-certificate text-base"></i> <span>Sertifikat</span>
      </a>

      <a href="{{ route('volunteer.profile.show') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#f49b9b] transition">
        <i class="fas fa-user text-base"></i> <span>Profile</span>
      </a>
    </nav>

  </aside>

  <!-- Main Content -->
  <main class="flex-1 ml-8">
    <!-- Header -->
    <header class="bg-[#f28b8b] text-white rounded-2xl px-6 py-4 flex items-center justify-between shadow-md">
      <div class="font-semibold text-xl">
        @yield('header', 'Dashboard')
      </div>

        <!-- Icons & Profile Dropdown -->
        <div class="flex space-x-6 text-white text-lg items-center">
          <a href="/messages" title="Messages">
            <i class="far fa-comment-alt fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
          </a>
        
          <!-- Notifikasi -->
          <div class="relative">
            <button id="notifButton">
              <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
            </button>
          
            <div id="notifOverlay" class="hidden absolute top-8 right-0 z-50">
              @if($notifications->isEmpty())
          <p class="bg-white text-gray-500 text-sm px-20 py-10 rounded shadow whitespace-nowrap">
          Belum ada notifikasi
          </p>
        @else
          <x-notification-overlay :notifications="$notifications" />
        @endif
            </div>
          </div>


          <!-- Profile button with dropdown -->
          <div class="relative">
            <button id="profileButton" class="text-white hover:scale-110 transition-transform duration-200">
              <i class="far fa-user-circle fa-lg"></i>
            </button>
            <div id="profileMenu" class="hidden absolute right-0 mt-5 w-40 bg-[#f28b8b] text-white rounded-md shadow-lg z-50">
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
        </nav>
    </header>

    <!-- Content -->
    <section class="mt-8 bg-white rounded-xl shadow px-6 py-5 w-full">
      @yield('content')
    </section>
    </main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profileBtn = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');
    const notifBtn = document.getElementById('notifButton');
    const notifOverlay = document.getElementById('notifOverlay');

    profileBtn.addEventListener('click', function (e) {
      e.stopPropagation(); // biar klik di luar bisa nutup
      profileMenu.classList.toggle('hidden');
    });
    notifBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      notifOverlay.classList.toggle('hidden');
    });

    // Klik di luar menu nutup dropdown
    window.addEventListener('click', function (e) {
      if (!profileMenu.classList.contains('hidden')) {
        profileMenu.classList.add('hidden');
      }

      if (!notifOverlay.classList.contains('hidden')) {
        notifOverlay.classList.add('hidden');
      }
    });
  });
</script>

</body>
</html>
