@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">User Baru</h1>
<form method="POST" action="{{ route('users.store') }}" class="bg-white rounded shadow p-4 max-w-xl">
  @csrf
  <div class="mb-3">
    <label class="block text-sm mb-1">Nama</label>
    <input name="name" class="border rounded w-full px-3 py-2" required>
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Email</label>
    <input type="email" name="email" class="border rounded w-full px-3 py-2" required>
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Password</label>
    <input type="password" name="password" class="border rounded w-full px-3 py-2" required>
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Role</label>
    <select name="roles[]" multiple class="border rounded w-full px-3 py-2">
      @foreach(\Spatie\Permission\Models\Role::pluck('name') as $r)
        <option value="{{ $r }}">{{ $r }}</option>
      @endforeach
    </select>
    <div class="text-xs text-gray-500 mt-1">Tahan Ctrl/Cmd untuk memilih banyak.</div>
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 rounded">Batal</a>
  </div>
</form>
@endsection
