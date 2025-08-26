<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use App\Models\StudyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KRSController extends Controller
{
    public function index()
    {
        $semester = now()->format('Y').'-1';
        $classes = CourseClass::with(['course','lecturer'])
            ->orderBy('id','desc')->paginate(12);

        $myPlans = StudyPlan::with('courseClass.course')
            ->where('student_id', Auth::id())
            ->where('semester_label', $semester)
            ->get();

        return view('mahasiswa.krs', compact('classes','myPlans','semester'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'class_ids' => ['required','array','min:1'],
            'class_ids.*' => ['integer'],
            'semester'  => ['nullable','string','max:10']
        ]);

        $semester = $request->input('semester', now()->format('Y').'-1');

        foreach ($request->class_ids as $cid) {
            StudyPlan::firstOrCreate(
                [
                    'student_id' => Auth::id(),
                    'course_class_id' => $cid,
                    'semester_label' => $semester,
                ],
                ['status' => 'submitted']
            );
        }

        return back()->with('ok','KRS berhasil diajukan.');
    }

    public function drop(StudyPlan $plan)
    {
        abort_unless($plan->student_id === Auth::id(), 403);
        $plan->delete();
        return back()->with('ok','Matkul dihapus dari KRS.');
    }
}
