@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Layanan Mahasiswa — Persetujuan</h1>

<form method="GET" class="bg-white rounded shadow p-4 mb-4 grid md:grid-cols-6 gap-2 text-sm">
  <select name="type" class="border rounded px-2 py-2">
    <option value="">Semua Jenis</option>
    @foreach(\App\Models\StudentRequest::TYPES as $t)
      <option value="{{ $t }}" {{ ($filters['type']??'')===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
    @endforeach
  </select>
  <select name="status" class="border rounded px-2 py-2">
    <option value="">Semua Status</option>
    @foreach(\App\Models\StudentRequest::STATUSES as $s)
      <option value="{{ $s }}" {{ ($filters['status']??'')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
    @endforeach
  </select>
  <input name="q" value="{{ $filters['q']??'' }}" placeholder="Cari nama/alasan..." class="border rounded px-3 py-2 md:col-span-3">
  <button class="px-3 py-2 rounded bg-gray-900 text-white">Filter</button>
</form>

<div class="bg-white rounded shadow overflow-x-auto">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="py-2 px-3">Tanggal</th>
        <th>Mahasiswa</th>
        <th>Jenis</th>
        <th>Alasan</th>
        <th>Status</th>
        <th class="text-right pr-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $r)
      <tr class="border-b">
        <td class="py-2 px-3">{{ $r->submitted_at?->format('d M Y H:i') ?? $r->created_at->format('d M Y H:i') }}</td>
        <td>{{ $r->student->name }}</td>
        <td>{{ ucfirst($r->type) }}</td>
        <td class="max-w-xl truncate" title="{{ $r->reason }}">{{ $r->reason }}</td>
        <td>
          <span class="px-2 py-0.5 rounded text-xs
            {{ $r->status==='submitted'?'bg-yellow-50 text-yellow-700':($r->status==='approved'?'bg-green-100 text-green-700':'bg-red-100 text-red-700') }}">
            {{ $r->status }}
          </span>
        </td>
        <td class="text-right pr-3">
          <a href="{{ route('opr.reqs.show',$r) }}" class="text-indigo-600 hover:underline">Detail</a>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada pengajuan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
