@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm text-gray-500">Total User</div>
    <div class="text-3xl font-extrabold">{{ \App\Models\User::count() }}</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm text-gray-500">Role</div>
    <div class="text-sm mt-2">Kelola di menu <b>Manajemen User</b>.</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm text-gray-500">Sistem</div>
    <div class="text-sm mt-2">Konfigurasi & audit (opsional).</div>
  </div>
</div>
@endsection
