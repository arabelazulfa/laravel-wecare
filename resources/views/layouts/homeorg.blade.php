@php
  use Illuminate\Support\Facades\Auth;

  $notifications = $notifications ?? (Auth::check() ? Auth::user()->notifications()->take(5)->get() : collect());
  $unreadCount = $unreadCount ?? (Auth::check() ? Auth::user()->unreadNotifications->count() : 0);
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WeCare Event</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="bg-[#fff0f0] min-h-screen">

  
  <nav class="bg-[#f28b8b] rounded-xl mx-4 mt-4 p-3 flex items-center justify-between">
  
    <a href="{{ route('volunteer.events') }}" class="text-xl font-bold text-white hover:text-gray-200">WeCare</a>

    
    @auth
    <div class="flex space-x-6 text-white text-lg items-center">
      <a href="{{ route('volunteer.chat.index') }}" title="Chat">
      <i class="far fa-comment-alt fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
      </a>
    @endauth

@auth

  <div class="relative">
    <button id="notifButton" title="Notifikasi" class="relative focus:outline-none">
    <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
    @if(isset($unreadCount) && $unreadCount > 0)
    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5">
      {{ $unreadCount }}
    </span>
    @endif
    </button>

    <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white text-black rounded-lg shadow-xl z-50">
    <div class="p-4">
      <h4 class="font-bold text-sm mb-2">Notifikasi Terbaru</h4>
      <div class="max-h-64 overflow-y-auto space-y-2">
      @forelse($notifications ?? [] as $notif)
      @isset($notif)
      <a href="{{ route('notifications.read', $notif->id ?? '') }}"
      class="block p-3 rounded-md text-sm border {{ $notif->read_at ? 'bg-gray-100' : 'bg-pink-100 border-pink-200' }}">
      <div class="font-semibold">{{ $notif->data['title'] ?? 'Notifikasi' }}</div>
      <div class="text-sm">{!! $notif->data['message'] ?? '' !!}</div>
      <div class="text-xs text-gray-600">{{ $notif->created_at?->diffForHumans() ?? '' }}</div>
      </a>
      @endisset
    @empty
      <p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
    @endforelse
      </div>
      <div class="text-right mt-2">
      <button onclick="document.getElementById('notifFullModal').classList.remove('hidden')"
        class="text-pink-600 text-sm hover:underline">
        Lihat Semua
      </button>
      </div>
    </div>
    </div>
  </div>
@endauth


   
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
  </nav>

  <section class="p-4">
    @yield('content')
  </section>

 
  <div id="notifFullModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-[90%] max-w-lg max-h-[80vh] overflow-y-auto rounded-xl p-6 shadow-lg relative">
      <h2 class="text-lg font-bold mb-4">Semua Notifikasi</h2>
      @forelse ($notifications ?? [] as $notif)
        @php
  $data = is_array($notif->data ?? null) ? $notif->data : [];
  $title = $data['title'] ?? 'Notifikasi';
  $message = $data['message'] ?? '';
      @endphp
        <div class="p-4 mb-3 border rounded-lg {{ $notif->read_at ? 'bg-gray-100' : 'bg-pink-100 border-pink-200' }}">
        <div class="font-semibold">{{ $title }}</div>
        <div class="text-sm">{!! $message !!}</div>
        <div class="text-xs text-gray-600">{{ $notif->created_at->diffForHumans() ?? '' }}</div>
        </div>
    @empty
      <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
    @endforelse
      <button onclick="document.getElementById('notifFullModal').classList.add('hidden')"
        class="absolute top-3 right-4 text-xl font-bold text-gray-600 hover:text-black">&times;</button>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const profileBtn = document.getElementById('profileButton');
      const profileMenu = document.getElementById('profileMenu');
      
      profileBtn.addEventListener('click', function (e) {
        e.stopPropagation(); 
        profileMenu.classList.toggle('hidden');
      });

     
      window.addEventListener('click', function (e) {
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


</body>

</html>