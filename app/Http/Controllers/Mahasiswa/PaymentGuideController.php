<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentGuideController extends Controller
{
       public function show() { return view('mahasiswa.payment_guide'); }
}
