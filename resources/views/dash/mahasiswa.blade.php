@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Mahasiswa</h1>
<div class="grid md:grid-cols-2 gap-4">
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold mb-2">Jadwal hari ini</div>
    <div class="text-sm text-gray-500">Silakan cek KRS untuk detail kelas.</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold mb-2">Tagihan Aktif</div>
    <div class="text-sm text-gray-500">Cek menu Tagihan UKT.</div>
  </div>
</div>
@endsection
