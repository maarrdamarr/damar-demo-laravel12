<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','DAMAR DCLASS') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
  <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b">
    <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
      <a href="{{ route('home') }}" class="font-black text-lg tracking-tight">
        DAMAR <span class="text-indigo-600">DCLASS</span>
      </a>
      <nav class="hidden md:flex items-center gap-6 text-sm">
        <a href="#fitur" class="hover:text-indigo-600">Fitur</a>
        <a href="#roles" class="hover:text-indigo-600">Roles</a>
        <a href="#demo" class="hover:text-indigo-600">Demo</a>
      </nav>
      <div class="flex items-center gap-2">
        @auth
          <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded bg-gray-100 hover:bg-gray-200 text-sm">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="px-3 py-1.5 rounded text-sm">Masuk</a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="px-3 py-1.5 rounded bg-indigo-600 text-white text-sm hover:bg-indigo-700">Daftar</a>
          @endif
        @endauth
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="mt-16 border-t">
    <div class="max-w-7xl mx-auto px-4 py-8 text-sm text-gray-500 flex items-center justify-between">
      <div>© {{ date('Y') }} DAMAR DCLASS — Sistem Akademik Sederhana</div>
      <div class="space-x-4">
        <a class="hover:text-indigo-600" href="#fitur">Fitur</a>
        <a class="hover:text-indigo-600" href="#roles">Roles</a>
        <a class="hover:text-indigo-600" href="#demo">Demo</a>
      </div>
    </div>
  </footer>
</body>
</html>
