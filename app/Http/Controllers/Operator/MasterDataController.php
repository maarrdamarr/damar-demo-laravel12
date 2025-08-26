<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\User;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('name')->get();
        $courses  = Course::with('program')->latest()->paginate(15);
        $classes  = CourseClass::with(['course','lecturer'])->latest()->paginate(15);
        $lecturers = User::role('dosen')->orderBy('name')->get();

        return view('operator.master', compact('programs','courses','classes','lecturers'));
    }

    // === Program ===
    public function storeProgram(Request $r)
    {
        $data = $r->validate([
            'code' => ['required','string','max:20','unique:programs,code'],
            'name' => ['required','string','max:150'],
        ]);
        Program::create($data);
        return back()->with('ok','Program ditambahkan.');
    }

    public function destroyProgram(Program $program)
    {
        $program->delete();
        return back()->with('ok','Program dihapus.');
    }

    // === Course ===
    public function storeCourse(Request $r)
    {
        $data = $r->validate([
            'program_id' => ['required','exists:programs,id'],
            'code'       => ['required','string','max:20','unique:courses,code'],
            'name'       => ['required','string','max:150'],
            'credits'    => ['required','integer','between:1,6'],
        ]);
        Course::create($data);
        return back()->with('ok','Mata kuliah ditambahkan.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return back()->with('ok','Mata kuliah dihapus.');
    }

    // === Class (Kelas MK) ===
    public function storeClass(Request $r)
    {
        $data = $r->validate([
            'course_id'   => ['required','exists:courses,id'],
            'class_code'  => ['required','string','max:10'],
            'lecturer_id' => ['nullable','exists:users,id'],
            'quota'       => ['required','integer','min:1'],
            'room'        => ['nullable','string','max:50'],
            'day'         => ['nullable','string','max:20'],
            'time'        => ['nullable','string','max:20'],
        ]);

        CourseClass::create($data);
        return back()->with('ok','Kelas dibuat.');
    }

    public function destroyClass(CourseClass $courseClass)
    {
        $courseClass->delete();
        return back()->with('ok','Kelas dihapus.');
    }
}
