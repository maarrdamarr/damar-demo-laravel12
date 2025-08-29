<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() { return view('operator.schedule'); }
    public function sync()  { return back()->with('ok','Sinkron semester disimulasikan.'); }
}
