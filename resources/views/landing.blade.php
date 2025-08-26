@extends('layouts.public')

@section('content')
{{-- HERO --}}
<section class="relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-cyan-50"></div>
  <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-24">
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h1 class="text-3xl md:text-5xl font-black leading-tight">
          Portal Akademik <span class="text-indigo-600">DAMAR DCLASS</span>
        </h1>
        <p class="mt-4 text-gray-600 text-lg">
          Kelola KRS, nilai, presensi, dan pembayaran UKT dengan alur sederhana untuk
          Mahasiswa, Dosen, Operator Prodi, Keuangan, dan Admin.
        </p>
        <div class="mt-6 flex gap-3">
          @auth
            <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded bg-indigo-600 text-white font-medium hover:bg-indigo-700">Masuk Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="px-5 py-3 rounded bg-indigo-600 text-white font-medium hover:bg-indigo-700">Masuk</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-5 py-3 rounded bg-gray-900 text-white font-medium hover:bg-black">Daftar</a>
            @endif
          @endauth
        </div>
        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
          <div class="p-4 bg-white rounded shadow">
            <div class="text-2xl font-extrabold">{{ \App\Models\User::count() }}</div>
            <div class="text-xs text-gray-500">Pengguna</div>
          </div>
          <div class="p-4 bg-white rounded shadow">
            <div class="text-2xl font-extrabold">{{ \App\Models\Course::count() }}</div>
            <div class="text-xs text-gray-500">Mata Kuliah</div>
          </div>
          <div class="p-4 bg-white rounded shadow">
            <div class="text-2xl font-extrabold">{{ \App\Models\Invoice::count() }}</div>
            <div class="text-xs text-gray-500">Tagihan</div>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="rounded-2xl border bg-white shadow p-3">
          <img alt="Preview Dashboard" class="rounded-xl"
               src="https://dummyimage.com/800x480/ffffff/aaa.png&text=DAMAR+DCLASS+Dashboard">
        </div>
      </div>
    </div>
  </div>
</section>

{{-- FITUR --}}
<section id="fitur" class="max-w-7xl mx-auto px-4 py-16">
  <h2 class="text-2xl md:text-3xl font-black mb-6">Fitur Utama</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="p-5 bg-white rounded shadow">
      <div class="text-2xl">📝</div>
      <div class="font-semibold mt-2">KRS & Jadwal</div>
      <p class="text-sm text-gray-600 mt-1">Ambil/drop kelas, lihat kuota & jadwal real time.</p>
    </div>
    <div class="p-5 bg-white rounded shadow">
      <div class="text-2xl">📊</div>
      <div class="font-semibold mt-2">Nilai & Transkrip</div>
      <p class="text-sm text-gray-600 mt-1">Input nilai oleh dosen, KHS & transkrip otomatis.</p>
    </div>
    <div class="p-5 bg-white rounded shadow">
      <div class="text-2xl">💳</div>
      <div class="font-semibold mt-2">UKT & Pembayaran</div>
      <p class="text-sm text-gray-600 mt-1">Tagihan massal, verifikasi pembayaran, rekam jejak.</p>
    </div>
  </div>
</section>

{{-- ROLES --}}
<section id="roles" class="max-w-7xl mx-auto px-4 py-16">
  <h2 class="text-2xl md:text-3xl font-black mb-6">5 Role, 1 Portal Terpadu</h2>
  <div class="grid md:grid-cols-5 gap-4 text-sm">
    <div class="p-4 bg-white rounded shadow">
      <div class="font-bold">Mahasiswa</div>
      <ul class="mt-2 list-disc ml-4 text-gray-600">
        <li>KRS & Jadwal</li><li>KHS/Transkrip</li><li>Tagihan UKT</li>
      </ul>
    </div>
    <div class="p-4 bg-white rounded shadow">
      <div class="font-bold">Dosen</div>
      <ul class="mt-2 list-disc ml-4 text-gray-600">
        <li>Input Nilai</li><li>Presensi</li>
      </ul>
    </div>
    <div class="p-4 bg-white rounded shadow">
      <div class="font-bold">Operator Prodi</div>
      <ul class="mt-2 list-disc ml-4 text-gray-600">
        <li>Kurikulum</li><li>Matkul & Kelas</li>
      </ul>
    </div>
    <div class="p-4 bg-white rounded shadow">
      <div class="font-bold">Keuangan</div>
      <ul class="mt-2 list-disc ml-4 text-gray-600">
        <li>Tagihan</li><li>Verifikasi Pembayaran</li>
      </ul>
    </div>
    <div class="p-4 bg-white rounded shadow">
      <div class="font-bold">Admin</div>
      <ul class="mt-2 list-disc ml-4 text-gray-600">
        <li>User & Role</li><li>Konfigurasi</li>
      </ul>
    </div>
  </div>
</section>

{{-- DEMO CTA --}}
<section id="demo" class="max-w-7xl mx-auto px-4 py-16">
  <div class="p-6 md:p-10 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-800 text-white">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
      <div>
        <div class="text-2xl md:text-3xl font-black">Siap mencoba DAMAR DCLASS?</div>
        <p class="text-indigo-100 mt-1">Masuk/daftar untuk melihat dashboard sesuai peran Anda.</p>
      </div>
      <div class="flex gap-3">
        @auth
          <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded bg-white text-indigo-700 font-semibold">Buka Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="px-5 py-3 rounded bg-white text-indigo-700 font-semibold">Masuk</a>
          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="px-5 py-3 rounded border border-white/40 font-semibold">Daftar</a>
          @endif
        @endauth
      </div>
    </div>
  </div>
</section>
@endsection
