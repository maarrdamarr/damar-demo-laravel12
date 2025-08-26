@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tagihan UKT Saya</h1>
<div class="bg-white rounded shadow">
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="py-2 px-3">No</th>
        <th class="px-3">Nomor</th>
        <th class="px-3">Jumlah</th>
        <th class="px-3">Jatuh Tempo</th>
        <th class="px-3">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $i)
      <tr class="border-b">
        <td class="py-2 px-3">{{ $loop->iteration }}</td>
        <td class="px-3">{{ $i->number }}</td>
        <td class="px-3">Rp {{ number_format($i->amount,0,',','.') }}</td>
        <td class="px-3">{{ $i->due_date?->format('d M Y') ?? '-' }}</td>
        <td class="px-3">
          <span class="px-2 py-0.5 rounded text-xs {{ $i->status==='paid'?'bg-green-100 text-green-700':'bg-yellow-50 text-yellow-700' }}">
            {{ $i->status }}
          </span>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="py-3 text-center text-gray-500">Tidak ada tagihan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
