@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Kelola Profil</h1>

<div class="grid lg:grid-cols-3 gap-6">

  {{-- FOTO PROFIL --}}
  <section class="bg-white rounded shadow p-4">
    <div class="font-semibold mb-3">Foto Profil</div>
    <div class="flex items-center gap-4">
      @php
        $src = $user->avatar_path ? asset('storage/'.$user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128';
      @endphp
      <img src="{{ $src }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border">
      <form method="POST" action="{{ route('mhs.profile.avatar') }}" enctype="multipart/form-data" class="flex-1">
        @csrf
        <input type="file" name="avatar" accept="image/*" class="block w-full text-sm mb-2">
        <button class="px-3 py-2 rounded bg-gray-900 text-white">Upload</button>
        <div class="text-xs text-gray-500 mt-1">*.jpg, .png, .webp — maks 2MB</div>
      </form>
    </div>
  </section>

  {{-- DATA AKUN --}}
  <section class="bg-white rounded shadow p-4 lg:col-span-2">
    <div class="font-semibold mb-3">Data Akun</div>
    <form method="POST" action="{{ route('mhs.profile.update') }}" class="grid md:grid-cols-2 gap-3">
      @csrf
      <div>
        <label class="text-sm">Nama</label>
        <input name="name" value="{{ old('name',$user->name) }}" class="mt-1 w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="text-sm">Email</label>
        <input type="email" name="email" value="{{ old('email',$user->email) }}" class="mt-1 w-full border rounded px-3 py-2" required>
      </div>
      <div class="md:col-span-2 flex justify-end">
        <button class="px-4 py-2 rounded bg-indigo-600 text-white">Simpan Perubahan</button>
      </div>
    </form>
  </section>

  {{-- GANTI PASSWORD --}}
  <section class="bg-white rounded shadow p-4 lg:col-span-3">
    <div class="font-semibold mb-3">Ganti Password</div>
    <form method="POST" action="{{ route('mhs.profile.password') }}" class="grid md:grid-cols-3 gap-3">
      @csrf
      <div>
        <label class="text-sm">Password Saat Ini</label>
        <input type="password" name="current_password" class="mt-1 w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="text-sm">Password Baru</label>
        <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="text-sm">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2" required>
      </div>
      <div class="md:col-span-3 flex justify-end">
        <button class="px-4 py-2 rounded bg-gray-900 text-white">Ubah Password</button>
      </div>
    </form>
  </section>

</div>
@endsection
