@extends('layouts.auth')

@section('card')
<div class="max-w-md bg-white border rounded-xl shadow p-6">
  <h1 class="text-xl font-bold">Lupa Password</h1>
  <p class="text-sm text-gray-600 mb-4">Masukkan email untuk menerima tautan reset.</p>

  @if (session('status'))
    <div class="mb-3 p-2 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.email') }}" class="space-y-3">
    @csrf
    <div>
      <label class="text-sm">Email</label>
      <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <button class="w-full px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Kirim Tautan</button>
  </form>
</div>
@endsection
