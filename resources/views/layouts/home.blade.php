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

    <!-- Icons with links -->
    <div class="flex space-x-6 text-white text-lg">
      <a href="/messages" title="Messages">
        <i class="far fa-comment-alt fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
      </a>
      <a href="/notifications" title="Notifications">
        <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
      </a>
      <a href="/profile" title="Profile">
        <i class="far fa-user-circle fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
      </a>
    </div>
  </nav>

  <!-- Konten dari halaman lain bakal masuk di sini -->
  <section class="p-4">
    @yield('content')
  </section>
</body>
</html>
