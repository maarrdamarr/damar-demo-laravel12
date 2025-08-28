<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentRequestApprovalController extends Controller
{
    /**
     * Daftar pengajuan mahasiswa (filter by type/status/q).
     */
    public function index(Request $request)
    {
        $items = StudentRequest::with('student')
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->string('q');
                $q->where(function ($inner) use ($term) {
                    $inner->where('reason', 'like', "%{$term}%")
                          ->orWhereHas('student', fn ($u) => $u->where('name', 'like', "%{$term}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('operator.requests.index', [
            'items'   => $items,
            'filters' => [
                'type'   => $request->string('type'),
                'status' => $request->string('status'),
                'q'      => $request->string('q'),
            ],
        ]);
    }

    /**
     * Detail satu pengajuan.
     */
    public function show(StudentRequest $req)
    {
        $req->load(['student', 'processor', 'student.studentProfile.program']);
        return view('operator.requests.show', compact('req'));
    }

    /**
     * Setujui pengajuan (hanya jika status submitted).
     */
    public function approve(Request $request, StudentRequest $req)
    {
        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        if ($req->status !== 'submitted') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $req->status       = 'approved';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->note         = $data['note'] ?? null;
        $req->save();

        return redirect()->route('opr.reqs.show', $req)->with('ok', 'Pengajuan disetujui.');
    }

    /**
     * Tolak pengajuan (hanya jika status submitted).
     */
    public function reject(Request $request, StudentRequest $req)
    {
        $data = $request->validate([
            'note' => ['required', 'string', 'max:255'],
        ]);

        if ($req->status !== 'submitted') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $req->status       = 'rejected';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->note         = $data['note'];
        $req->save();

        return redirect()->route('opr.reqs.show', $req)->with('ok', 'Pengajuan ditolak.');
    }

    /**
     * Export PDF Surat Keputusan (hanya untuk status approved).
     */
    public function exportPdf(StudentRequest $req)
    {
        if ($req->status !== 'approved') {
            return back()->with('error', 'Hanya pengajuan yang disetujui yang bisa dicetak.');
        }

        // Set nilai default SK bila belum diisi
        if (!$req->decision_number) {
            $seq  = str_pad((string) $req->id, 4, '0', STR_PAD_LEFT);
            $year = now()->format('Y');
            $req->decision_number = "SK/DCLASS/{$seq}/{$year}";
        }
        if (!$req->decision_date) {
            $req->decision_date = now()->toDateString();
        }
        if (!$req->effective_semester && $req->type === 'cuti') {
            $req->effective_semester = now()->format('Y') . '-1';
        }
        if (!$req->effective_date) {
            $req->effective_date = now()->toDateString();
        }
        $req->save();

        $req->load(['student', 'processor', 'student.studentProfile.program']);

        $pdf = Pdf::loadView('operator.requests.sk_pdf', [
            'req' => $req,
            'org' => [
                'name'    => 'DAMAR DCLASS',
                'unit'    => 'Biro Akademik',
                'address' => 'Jl. Contoh No. 123, Surabaya',
            ],
        ])->setPaper('a4', 'portrait');

        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $req->student->name);
        $filename = strtoupper($req->type) . "_{$safeName}_{$req->id}.pdf";

        return $pdf->download($filename);
        // Atau tampilkan di browser:
        // return $pdf->stream($filename);
    }
}
