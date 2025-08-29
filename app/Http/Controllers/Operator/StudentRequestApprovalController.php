<?php


namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentRequestApprovalController extends Controller
{
    public function index(Request $r)
    {
        $q = StudentRequest::with('student')
            ->when($r->filled('type'), fn($x) => $x->where('type', $r->type))
            ->when($r->filled('status'), fn($x) => $x->where('status', $r->status))
            ->when($r->filled('q'), function($x) use ($r) {
                $x->where(function($y) use ($r) {
                    $y->where('reason','like','%'.$r->q.'%')
                        ->orWhereHas('student', fn($z)=>$z->where('name','like','%'.$r->q.'%'));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('operator.requests.index', [
            'items' => $q,
            'filters' => [
                'type' => $r->type,
                'status' => $r->status,
                'q' => $r->q,
            ],
        ]);
    }

    public function show(StudentRequest $req)
    {
        $req->load('student');
        return view('operator.requests.show', compact('req'));
    }

    public function approve(Request $r, StudentRequest $req)
    {
        $r->validate(['note'=>'nullable|string|max:255']);
        if ($req->status !== 'submitted') {
            return back()->with('error','Pengajuan sudah diproses.');
        }
        $req->status = 'approved';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->note = $r->note;
        $req->save();

        return redirect()->route('opr.reqs.show',$req)->with('ok','Pengajuan disetujui.');
    }

    public function reject(Request $r, StudentRequest $req)
    {
        $r->validate(['note'=>'required|string|max:255']);
        if ($req->status !== 'submitted') {
            return back()->with('error','Pengajuan sudah diproses.');
        }
        $req->status = 'rejected';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->note = $r->note;
        $req->save();

        return redirect()->route('opr.reqs.show',$req)->with('ok','Pengajuan ditolak.');
    }
}
