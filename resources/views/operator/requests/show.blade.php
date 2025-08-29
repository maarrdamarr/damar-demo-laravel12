@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Detail Pengajuan</h1>

<div class="bg-white rounded shadow p-4 max-w-3xl">
  <dl class="text-sm grid md:grid-cols-2 gap-x-6 gap-y-2">
    <div><dt class="text-gray-500">Mahasiswa</dt><dd class="font-medium">{{ $req->student->name }}</dd></div>
    <div><dt class="text-gray-500">Email</dt><dd>{{ $req->student->email }}</dd></div>
    <div><dt class="text-gray-500">Jenis</dt><dd class="font-medium">{{ ucfirst($req->type) }}</dd></div>
    <div><dt class="text-gray-500">Status</dt>
      <dd>
        <span class="px-2 py-0.5 rounded text-xs
          {{ $req->status==='submitted'?'bg-yellow-50 text-yellow-700':($req->status==='approved'?'bg-green-100 text-green-700':'bg-red-100 text-red-700') }}">
          {{ $req->status }}
        </span>
      </dd>
    </div>
    <div><dt class="text-gray-500">Diajukan</dt><dd>{{ $req->submitted_at?->format('d M Y H:i') ?? $req->created_at->format('d M Y H:i') }}</dd></div>
    @if($req->processed_at)
      <div><dt class="text-gray-500">Diproses</dt><dd>{{ $req->processed_at->format('d M Y H:i') }}</dd></div>
      <div><dt class="text-gray-500">Petugas</dt><dd>{{ $req->processor->name ?? '-' }}</dd></div>
    @endif
  </dl>

  @if($req->extra)
  <div class="mt-4">
    <div class="text-gray-500 text-sm">Info Tambahan</div>
    <pre class="text-xs bg-gray-50 p-3 rounded">{{ json_encode(json_decode($req->extra,true), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
  </div>
  @endif

  <div class="mt-4">
    <div class="text-gray-500 text-sm mb-1">Alasan</div>
    <div class="border rounded p-3 text-sm">{{ $req->reason ?: '-' }}</div>
  </div>

  @if($req->status==='submitted')
  <div class="mt-6 flex flex-col md:flex-row gap-3">
    <form method="POST" action="{{ route('opr.reqs.approve',$req) }}" class="flex-1">
      @csrf
      <input name="note" placeholder="Catatan (opsional)" class="w-full border rounded px-3 py-2 mb-2">
      <button class="w-full px-4 py-2 rounded bg-green-600 text-white" onclick="return confirm('Setujui pengajuan ini?')">Setujui</button>
    </form>
    <form method="POST" action="{{ route('opr.reqs.reject',$req) }}" class="flex-1">
      @csrf
      <input name="note" placeholder="Alasan penolakan (wajib)" class="w-full border rounded px-3 py-2 mb-2" required>
      <button class="w-full px-4 py-2 rounded bg-red-600 text-white" onclick="return confirm('Tolak pengajuan ini?')">Tolak</button>
    </form>
  </div>
  @else
  <div class="mt-6 text-sm text-gray-600">
    Catatan: {{ $req->note ?? '-' }}
  </div>
  @endif
</div>
@endsection
