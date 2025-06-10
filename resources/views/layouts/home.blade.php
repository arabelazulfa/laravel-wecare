@php use Illuminate\Support\Facades\Auth; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WeCare Navbar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-[#fff0f0] min-h-screen">

  <!-- Navbar -->
  <nav class="bg-[#f28b8b] rounded-xl mx-4 mt-4 p-3 flex items-center justify-between">
    <!-- Logo -->
    <div class="text-white font-semibold text-xl">WeCare</div>

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
  </nav>

  <!-- Konten dari halaman lain bakal masuk di sini -->
  <section class="p-4">
    @yield('content')
  </section>

  <!-- Script untuk handle dropdown -->
  <script>
    const profileBtn = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');

    profileBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
      if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
        profileMenu.classList.add('hidden');
      }
    });
  </script>

</body>
</html>
