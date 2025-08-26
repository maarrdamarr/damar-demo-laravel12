@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Tagihan & Pembayaran</h1>

{{-- Generate Tagihan --}}
<div class="bg-white rounded shadow p-4 mb-6">
  <div class="font-semibold mb-3">Generate Tagihan Massal</div>
  <form method="POST" action="{{ route('keu.tagihan.generate') }}" class="grid md:grid-cols-4 gap-3">
    @csrf
    <select name="student_ids[]" multiple class="border rounded px-2 py-2 md:col-span-2 h-28">
      @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>@endforeach
    </select>
    <input type="number" name="amount" placeholder="Nominal" class="border rounded px-2 py-2">
    <input type="date" name="due_date" class="border rounded px-2 py-2">
    <input type="text" name="note" placeholder="Catatan (opsional)" class="border rounded px-2 py-2 md:col-span-3">
    <div class="md:col-span-1 flex items-center">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded w-full">Buat Tagihan</button>
    </div>
  </form>
</div>

{{-- Daftar Tagihan --}}
<div class="bg-white rounded shadow p-4">
  <div class="font-semibold mb-3">Daftar Tagihan</div>
  <table class="w-full text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="py-2">No</th>
        <th>Mahasiswa</th>
        <th>Nomor</th>
        <th>Jumlah</th>
        <th>Jatuh Tempo</th>
        <th>Status</th>
        <th class="text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $i)
      <tr class="border-b">
        <td class="py-2">{{ $loop->iteration + ($items->currentPage()-1)*$items->perPage() }}</td>
        <td>{{ $i->student->name }}</td>
        <td>{{ $i->number }}</td>
        <td>Rp {{ number_format($i->amount,0,',','.') }}</td>
        <td>{{ $i->due_date?->format('d M Y') ?? '-' }}</td>
        <td>
          <span class="px-2 py-0.5 rounded text-xs {{ $i->status==='paid'?'bg-green-100 text-green-700':'bg-yellow-50 text-yellow-700' }}">{{ $i->status }}</span>
        </td>
        <td class="text-right">
          {{-- Buat Payment --}}
          <details class="inline-block">
            <summary class="cursor-pointer text-indigo-600 hover:underline">Catat Payment</summary>
            <form method="POST" action="{{ route('keu.pembayaran.create') }}" class="mt-2 flex gap-2">
              @csrf
              <input type="hidden" name="invoice_id" value="{{ $i->id }}">
              <input type="hidden" name="paid_by" value="{{ $i->student_id }}">
              <input type="number" name="amount" value="{{ $i->amount }}" class="border rounded px-2 py-1 w-28">
              <input type="text" name="reference" placeholder="Ref/No. Bukti" class="border rounded px-2 py-1">
              <button class="px-3 py-1 rounded bg-gray-800 text-white">Simpan</button>
            </form>
          </details>

          {{-- Verifikasi --}}
          <form method="POST" action="{{ route('keu.pembayaran.verify') }}" class="inline-block ml-2">
            @csrf
            <input type="hidden" name="invoice_id" value="{{ $i->id }}">
            <button class="px-3 py-1 rounded bg-green-600 text-white"
              onclick="return confirm('Verifikasi dan tandai lunas?')">Verifikasi</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-3">{{ $items->links() }}</div>
</div>
@endsection
