{{-- resources/views/mahasiswa/layanan/cuti.blade.php --}}
@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Pengajuan Cuti</h1>
<form method="POST" action="{{ route('mhs.req.cuti.store') }}" class="bg-white rounded shadow p-4 max-w-2xl">
  @csrf
  <div class="mb-3">
    <label class="text-sm">Semester Cuti</label>
    <input name="semester" class="mt-1 w-full border rounded px-3 py-2" placeholder="2025-1" required>
  </div>
  <div class="mb-3">
    <label class="text-sm">Alasan</label>
    <textarea name="reason" class="mt-1 w-full border rounded px-3 py-2" rows="4" required></textarea>
  </div>
  <button class="px-4 py-2 rounded bg-indigo-600 text-white">Kirim Pengajuan</button>
</form>
@endsection
