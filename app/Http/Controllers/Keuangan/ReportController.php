<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;

class ReportController extends Controller
{
    public function index()
    {
        $total = Payment::where('status','succeeded')->sum('amount');
        $lunas = Invoice::where('status','paid')->count();
        $tagihan = Invoice::count();
        $recent = Payment::with('invoice')->latest()->take(10)->get();
        return view('keuangan.report', compact('total','lunas','tagihan','recent'));
    }
    public function methods() { return view('keuangan.methods'); }
}
