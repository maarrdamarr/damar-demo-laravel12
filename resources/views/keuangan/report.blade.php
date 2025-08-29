{{-- resources/views/keuangan/report.blade.php --}}
@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Laporan Penerimaan</h1>
<div class="grid md:grid-cols-3 gap-4 mb-6">
  <x-stat title="Total Masuk" :value="'Rp '.number_format($total,0,',','.')" />
  <x-stat title="Invoice Lunas" :value="$lunas" />
  <x-stat title="Total Tagihan" :value="$tagihan" />
</div>
<div class="bg-white rounded shadow p-4">
  <div class="font-semibold mb-2">Pembayaran Terbaru</div>
  <ul class="text-sm divide-y">
    @forelse($recent as $p)
    <li class="py-2">#{{ $p->id }} — {{ $p->invoice?->number }} — Rp {{ number_format($p->amount,0,',','.') }} ({{ $p->status }})</li>
    @empty
    <li class="py-2 text-gray-500">Belum ada pembayaran.</li>
    @endforelse
  </ul>
</div>
@endsection
