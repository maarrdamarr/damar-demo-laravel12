@extends('layouts.auth')

@section('card')
<div class="max-w-md bg-white border rounded-xl shadow p-6">
  <h1 class="text-xl font-bold">Masuk</h1>
  <p class="text-sm text-gray-600 mb-4">Gunakan akun DAMAR DCLASS Anda.</p>

  @if (session('status'))
    <div class="mb-3 p-2 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="mb-3 p-2 rounded bg-red-50 text-red-700 text-sm">
      @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-3">
    @csrf
    <div>
      <label class="text-sm">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus
             class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="text-sm">Password</label>
      <input type="password" name="password" required class="mt-1 w-full border rounded px-3 py-2">
    </div>
    <div class="flex items-center justify-between text-sm">
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="remember"> <span>Ingat saya</span>
      </label>
      @if (Route::has('password.request'))
      <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Lupa password?</a>
      @endif
    </div>
    <button class="w-full px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Masuk</button>
  </form>

  @if (Route::has('register'))
  <div class="mt-4 text-sm text-center">
    Belum punya akun?
    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a>
  </div>
  @endif
</div>
@endsection
