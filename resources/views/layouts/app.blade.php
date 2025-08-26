<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','DAMAR DCLASS') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="hidden md:block w-72 bg-white border-r">
      <div class="p-5 border-b">
        <div class="font-extrabold text-xl tracking-tight">DAMAR <span class="text-indigo-600">DCLASS</span></div>
        <div class="text-xs text-gray-500 mt-1">Sistem Akademik Sederhana</div>
      </div>

      @php
        function nav_active($names){ return request()->routeIs($names) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'; }
      @endphp

      <nav class="p-3 space-y-1 text-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded {{ nav_active('dashboard') }}">
          <span>🏠</span><span>Dashboard</span>
        </a>

        @role('mahasiswa')
        <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Mahasiswa</div>
        <a href="{{ route('mhs.krs') }}" class="block px-3 py-2 rounded {{ nav_active('mhs.krs') }}">📝 KRS</a>
        <a href="{{ route('mhs.tagihan') }}" class="block px-3 py-2 rounded {{ nav_active('mhs.tagihan') }}">💳 Tagihan UKT</a>
        @endrole

        @role('dosen')
        <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Dosen</div>
        <a href="{{ route('dsn.nilai') }}" class="block px-3 py-2 rounded {{ nav_active('dsn.nilai') }}">✍️ Input Nilai</a>
        @endrole

        @role('operator')
        <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Operator Prodi</div>
        <a href="{{ route('opr.master') }}" class="block px-3 py-2 rounded {{ nav_active('opr.master') }}">🧩 Master Data</a>
        @endrole

        @role('keuangan')
        <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Keuangan</div>
        <a href="{{ route('keu.tagihan') }}" class="block px-3 py-2 rounded {{ nav_active('keu.tagihan') }}">📄 Tagihan & Pembayaran</a>
        @endrole

        @role('admin')
        <div class="px-3 pt-4 text-[11px] uppercase tracking-wider text-gray-500">Admin</div>
        <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded {{ nav_active('users.*') }}">👥 Manajemen User</a>
        @endrole
      </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
      {{-- Topbar --}}
      <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
          <div class="md:hidden font-bold">DAMAR <span class="text-indigo-600">DCLASS</span></div>
          <div class="flex items-center gap-3">
            <div class="text-sm">
              <div class="font-semibold">{{ auth()->user()->name ?? 'Guest' }}</div>
              <div class="text-xs text-gray-500">
                @foreach(auth()->user()->getRoleNames() ?? [] as $r)
                  <span class="inline-flex items-center px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 mr-1">{{ $r }}</span>
                @endforeach
              </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="text-xs px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Logout</button>
            </form>
          </div>
        </div>
      </header>

      {{-- Content --}}
      <main class="max-w-7xl mx-auto w-full px-4 py-6">
        @if (session('ok'))
          <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('ok') }}</div>
        @endif
        @if (session('error'))
          <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
          <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
            <div class="font-semibold mb-1">Ada yang perlu diperbaiki:</div>
            <ul class="list-disc ml-5">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
