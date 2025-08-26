<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use App\Models\StudyPlan;
use App\Models\StudyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $classes = CourseClass::with('course')
            ->where('lecturer_id', Auth::id())
            ->orderBy('id','desc')
            ->get();

        $plans = StudyPlan::with(['student','courseClass.course','result'])
            ->whereIn('course_class_id', $classes->pluck('id'))
            ->latest()
            ->paginate(20);

        return view('dosen.nilai', compact('classes','plans'));
    }

    // route: POST /dosen/nilai/{krs}/update
    public function update(Request $r, StudyPlan $krs)
    {
        abort_unless(
            $krs->courseClass && $krs->courseClass->lecturer_id === Auth::id(),
            403
        );

        $data = $r->validate([
            'grade' => ['required','string','in:A,A-,B+,B,B-,C+,C,D,E'],
            'score' => ['nullable','numeric','between:0,100'],
            'notes' => ['nullable','string','max:255'],
        ]);

        $result = StudyResult::firstOrNew(['study_plan_id' => $krs->id]);
        $result->grade = $data['grade'];
        $result->score = $data['score'] ?? null;
        $result->notes = $data['notes'] ?? null;
        $result->save();

        return back()->with('ok','Nilai diperbarui.');
    }
}
