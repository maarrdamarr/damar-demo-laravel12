<?php

// app/Http/Controllers/Mahasiswa/PaymentGuideController.php
namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;

class PaymentGuideController extends Controller {
    public function show() { return view('mahasiswa.payment_guide'); }
}
