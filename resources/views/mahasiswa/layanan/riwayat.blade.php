{{-- resources/views/mahasiswa/layanan/riwayat.blade.php --}}
@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Riwayat Pengajuan</h1>
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
  <thead><tr class="text-left border-b">
    <th class="py-2 px-3">Tanggal</th><th>Jenis</th><th>Alasan</th><th>Status</th>
  </tr></thead>
  <tbody>
  @forelse($items as $r)
    <tr class="border-b">
      <td class="py-2 px-3">{{ $r->created_at->format('d M Y H:i') }}</td>
      <td>{{ ucfirst($r->type) }}</td>
      <td class="max-w-xl">{{ $r->reason }}</td>
      <td><span class="px-2 py-0.5 rounded text-xs bg-gray-100">{{ $r->status }}</span></td>
    </tr>
  @empty
    <tr><td colspan="4" class="py-3 text-center text-gray-500">Belum ada pengajuan.</td></tr>
  @endforelse
  </tbody>
</table>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
