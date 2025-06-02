<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'WeCare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-[#FCE9E9] to-[#FDCACA] min-h-screen flex flex-col px-4 py-6">
  {{-- Header --}}
  <div class="w-full">
    <div class="bg-[#F19494] text-white text-center py-4 rounded-xl shadow-md w-full mb-6">
      <h1 class="text-4xl font-bold tracking-wider uppercase">WeCare</h1>
    </div>
  </div>

  {{-- Content --}}
  <div class="flex justify-center px-4">
    <main class="w-full max-w-xl bg-white shadow-md rounded-xl px-6 py-8">
      @yield('content')
    </main>
  </div>
  {{-- Footer --}}
  <footer class="mt-auto text-xs text-gray-500 text-center">
    &copy; {{ date('Y') }} WeCare. All rights reserved.
  </footer>
</body>

</html>
