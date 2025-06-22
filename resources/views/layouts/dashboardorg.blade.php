<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WeCare - Aktivitas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

</head>

<body class="bg-[#fff0f0] h-auto flex items-start p-6 font-sans">

  
  <aside class="bg-[#f28b8b] text-white w-52 h-screen rounded-2xl p-4 flex flex-col shadow-md">
    <div class="text-xl font-bold mb-6">WeCare</div>
    <nav class="flex flex-col space-y-3 text-sm font-medium">

    
      <a href="{{ route('dashboard.organisasi') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg
        {{ request()->routeIs('dashboard.organisasi', 'profildaftar')
  ? 'bg-white text-[#f28b8b] shadow'
  : 'hover:bg-[#f49b9b] text-white transition' }}">
        <i class="fas fa-home text-base"></i> <span>Dashboard</span>
      </a>
      <a href="{{ route('aktivitas.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg
        {{ request()->is('aktivitas*') || request()->is('events*')
  ? 'bg-white text-[#f28b8b] shadow'
  : 'hover:bg-[#f49b9b] text-white transition' }}">
        <i class="fas fa-wave-square text-base"></i> <span>Aktivitas</span>
      </a>


      <a href="{{ route('sertifikasi.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg
        {{ request()->routeIs('sertifikasi.*')
  ? 'bg-white text-[#f28b8b] shadow'
  : 'hover:bg-[#f49b9b] text-white transition' }}">
        <i class="fas fa-certificate text-base"></i> <span>Sertifikasi</span>
      </a>

      @php
    use App\Models\OrganizationProfile;

    $profile = OrganizationProfile::where('user_id', auth()->id())->first();
    @endphp

      @if ($profile)
      <a href="{{ route('organisasi.edit', ['user_id' => $profile->user_id]) }}" class="flex items-center gap-3 px-4 py-2 rounded-lg
      {{ request()->routeIs('organisasi.edit')
    ? 'bg-white text-[#f28b8b] shadow'
    : 'hover:bg-[#f49b9b] text-white transition' }}">
      <i class="fas fa-user-edit text-base"></i> <span>Edit Data Organisasi</span>
      </a>
    @else
      <p class="text-sm text-red-500">Data organisasi tidak ditemukan.</p>
    @endif


    </nav>
  </aside>


 
  <main class="flex-1 ml-8">
    
    <header class="bg-[#f28b8b] text-white rounded-2xl px-6 py-4 flex items-center justify-between shadow-md">
      <div class="font-semibold text-xl">
        @yield('title')
      </div>
     
      <div class="flex space-x-6 text-white text-lg items-center">
        <a href="{{ route('chat.index') }}" title="Messages" class="relative">
          <i class="far fa-comment-alt fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
          @if (isset($unreadChatCount) && $unreadChatCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5">
        {{ $unreadChatCount }}
        </span>
      @endif
        </a>

        <div class="relative">
          <button id="notifButton" title="Notifikasi" class="relative focus:outline-none">
            <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
            @if(isset($unreadCount) && $unreadCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5">
          {{ $unreadCount }}
        </span>
      @endif
          </button>

          <div id="notifDropdown"
            class="hidden absolute right-0 mt-3 w-80 bg-white text-black rounded-lg shadow-xl z-50">
            <div class="p-4">
              <h4 class="font-bold text-sm mb-2">Notifikasi Terbaru</h4>
              <div class="max-h-64 overflow-y-auto space-y-2">
                @forelse($notifications ?? [] as $notif)
              @if(is_object($notif) && isset($notif->data))
            <a href="{{ route('notifications.read', $notif->id) }}" class="block p-3 rounded-md text-sm border
             {{ $notif->read_at ? 'bg-gray-100' : 'bg-pink-100 border-pink-200' }}">
              <div class="font-semibold">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
              <div class="text-sm">{!! $notif->data['message'] ?? '' !!}</div>
              <div class="text-xs text-gray-600">{{ $notif->created_at->diffForHumans() }}</div>
            </a>
          @else
            <div class="block p-3 rounded-md text-sm border bg-gray-100 border-gray-200">
            <div class="font-semibold">Notifikasi tidak valid</div>
            </div>
          @endif
        @empty
          <p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
        @endforelse
              </div>
              <div class="text-right mt-2">
                <button onclick="document.getElementById('notifFullModal').classList.remove('hidden')"
                  class="text-gray-600 text-sm hover:underline">
                  Lihat Semua
                </button>

              </div>
            </div>
          </div>
        </div>


     
        <div class="relative">
          <button id="profileButton" class="text-white hover:scale-110 transition-transform duration-200">
            <i class="far fa-user-circle fa-lg"></i>
          </button>
          <div id="profileMenu"
            class="hidden absolute right-0 mt-2 w-40 bg-[#f28b8b] text-white rounded-md shadow-lg z-50">
            <ul class="p-3 space-y-2 font-semibold text-sm">
              <li><a href="{{ route('dashboard.profile') }}" class="block hover:underline">Profile</a></li>
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


    <div id="notifFullModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
      <div class="bg-white w-[90%] max-w-lg max-h-[80vh] overflow-y-auto rounded-xl p-6 shadow-lg relative">
        <h2 class="text-lg font-bold mb-4">Semua Notifikasi</h2>

        <div id="notifFullList" class="space-y-3">
          @forelse ($notifications ?? [] as $notif)
          @if(is_object($notif))
        <div class="p-4 border rounded-lg {{ $notif->read_at ? 'bg-gray-100' : 'bg-pink-100 border-pink-200' }}">
        <div class="font-semibold">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
        <div class="text-sm">{{ $notif->data['message'] ?? '' }}</div>
        <div class="text-xs text-gray-600">{{ $notif->created_at->diffForHumans() }}</div>
        </div>
        @else
        <div class="p-4 border rounded-lg bg-gray-100 border-gray-200">
        <div class="font-semibold">Notifikasi tidak valid</div>
        </div>
        @endif
      @empty
        <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
      @endforelse
        </div>

        <button onclick="document.getElementById('notifFullModal').classList.add('hidden')"
          class="absolute top-3 right-4 text-xl font-bold text-gray-600 hover:text-black">&times;</button>
      </div>
    </div>
    <div class="mt-6"></div>
    @yield('content')
    </div>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const notifBtn = document.getElementById('notifButton');
      const notifDropdown = document.getElementById('notifDropdown');

      notifBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
      });

      window.addEventListener('click', function () {
        if (!notifDropdown.classList.contains('hidden')) {
          notifDropdown.classList.add('hidden');
        }
      });
    });
  </script>

  <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>