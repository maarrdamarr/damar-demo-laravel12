@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Keuangan</h1>
<div class="grid md:grid-cols-3 gap-4">
  <x-stat title="Tagihan" :value="\App\Models\Invoice::count()" />
  <x-stat title="Lunas" :value="\App\Models\Invoice::where('status','paid')->count()" />
  <x-stat title="Pembayaran" :value="\App\Models\Payment::count()" />
</div>
@endsection
