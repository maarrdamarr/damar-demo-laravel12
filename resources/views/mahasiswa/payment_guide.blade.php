{{-- resources/views/mahasiswa/payment_guide.blade.php --}}
@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Metode Pembayaran UKT</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold">Virtual Account</div>
    <p class="text-sm text-gray-600">BCA, BRI, BNI, Mandiri (simulasi).</p>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold">E-Wallet</div>
    <p class="text-sm text-gray-600">OVO, Dana, Gopay (simulasi).</p>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="font-semibold">Kasir Kampus</div>
    <p class="text-sm text-gray-600">Datang ke loket keuangan.</p>
  </div>
</div>
@endsection
