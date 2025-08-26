@extends('layouts.auth')

@section('card')
<div class="max-w-md bg-white border rounded-xl shadow p-6">
  <h1 class="text-xl font-bold">Daftar</h1>
  <p class="text-sm text-gray-600 mb-4">Buat akun DAMAR DCLASS Anda.</p>

  @if ($errors->any())
    <div class="mb-3 p-2 rounded bg-red-50 text-red-700 text-sm">
      @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('register') }}" class="space-y-3">
    @csrf
    <div>
      <label class="text-sm">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="text-sm">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="text-sm">Password</label>
      <input type="password" name="password" required class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="text-sm">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" required class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <button class="w-full px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Buat Akun</button>
  </form>

  <div class="mt-4 text-sm text-center">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk</a>
  </div>
</div>
@endsection
