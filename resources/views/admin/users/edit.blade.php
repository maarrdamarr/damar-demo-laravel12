@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Edit User</h1>
<form method="POST" action="{{ route('users.update',$user) }}" class="bg-white rounded shadow p-4 max-w-xl">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="block text-sm mb-1">Nama</label>
    <input name="name" class="border rounded w-full px-3 py-2" value="{{ $user->name }}" required>
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Email</label>
    <input type="email" name="email" class="border rounded w-full px-3 py-2" value="{{ $user->email }}" required>
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Password (kosongkan jika tidak ganti)</label>
    <input type="password" name="password" class="border rounded w-full px-3 py-2">
  </div>
  <div class="mb-3">
    <label class="block text-sm mb-1">Role</label>
    <select name="roles[]" multiple class="border rounded w-full px-3 py-2">
      @foreach(\Spatie\Permission\Models\Role::pluck('name') as $r)
        <option value="{{ $r }}" {{ $user->hasRole($r) ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>
  </div>
  <div class="flex gap-2">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 rounded">Kembali</a>
  </div>
</form>
@endsection
