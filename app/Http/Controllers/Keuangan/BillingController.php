<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $items = Invoice::with('student')->latest()->paginate(20);
        $students = User::role('mahasiswa')->orderBy('name')->get();
        return view('keuangan.tagihan', compact('items','students'));
    }

    public function studentInvoices()
    {
        $items = Invoice::where('student_id', Auth::id())->latest()->get();
        return view('mahasiswa.tagihan', compact('items'));
    }

    public function generate(Request $r)
    {
        $r->validate([
            'student_ids' => ['required','array','min:1'],
            'student_ids.*' => ['integer','exists:users,id'],
            'amount' => ['required','integer','min:1'],
            'due_date' => ['nullable','date'],
            'note' => ['nullable','string','max:255'],
        ]);

        foreach ($r->student_ids as $sid) {
            Invoice::create([
                'student_id' => $sid,
                'number'     => 'INV-'.now()->format('YmdHis').'-'.$sid,
                'amount'     => $r->amount,
                'due_date'   => $r->due_date,
                'status'     => 'unpaid',
                'note'       => $r->note,
            ]);
        }
        return back()->with('ok','Tagihan dibuat.');
    }

    public function createPayment(Request $r)
    {
        $data = $r->validate([
            'invoice_id' => ['required','exists:invoices,id'],
            'amount'     => ['required','integer','min:1'],
            'paid_by'    => ['required','exists:users,id'],
            'method'     => ['nullable','string','max:50'],
            'channel'    => ['nullable','string','max:50'],
            'reference'  => ['nullable','string','max:100','unique:payments,reference'],
            'proof_url'  => ['nullable','string','max:255'],
            'paid_at'    => ['nullable','date'],
        ]);

        $payment = Payment::create(array_merge($data, ['status' => 'pending']));
        return back()->with('ok','Payment tercatat: #'.$payment->id);
    }

    public function verify(Request $r)
    {
        $r->validate([
            'invoice_id' => ['required','exists:invoices,id'],
            'payment_id' => ['nullable','exists:payments,id'],
        ]);

        $inv = Invoice::findOrFail($r->invoice_id);

        if ($r->filled('payment_id')) {
            $pay = Payment::where('invoice_id', $inv->id)->findOrFail($r->payment_id);
            $pay->status = 'succeeded';
            $pay->verified_by = Auth::id();
            $pay->verified_at = now();
            $pay->save();
        }

        $inv->status = 'paid';
        $inv->paid_at = now();
        $inv->save();

        return back()->with('ok','Pembayaran diverifikasi & invoice dilunasi.');
    }
}
