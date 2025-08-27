<?php


namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentServiceController extends Controller
{
    public function formCuti()    { return view('mahasiswa.layanan.cuti'); }
    public function formResign()  { return view('mahasiswa.layanan.pengunduran'); }

    public function storeCuti(Request $r)
    {
        $r->validate(['semester'=>'required','reason'=>'required|string|max:500']);
        StudentRequest::create([
            'student_id'=>Auth::id(), 'type'=>'cuti', 'reason'=>$r->reason,
            'status'=>'submitted', 'extra'=>json_encode(['semester'=>$r->semester]),
            'submitted_at'=>now(),
        ]);
        return back()->with('ok','Pengajuan cuti terkirim.');
    }

    public function storeResign(Request $r)
    {
        $r->validate(['reason'=>'required|string|max:500']);
        StudentRequest::create([
            'student_id'=>Auth::id(), 'type'=>'pengunduran', 'reason'=>$r->reason,
            'status'=>'submitted', 'submitted_at'=>now(),
        ]);
        return back()->with('ok','Pengajuan pengunduran diri terkirim.');
    }

    public function history()
    {
        $items = StudentRequest::where('student_id', Auth::id())->latest()->paginate(10);
        return view('mahasiswa.layanan.riwayat', compact('items'));
    }
}
