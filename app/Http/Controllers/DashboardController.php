<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('admin'))     return view('dash.admin');
        if ($user->hasRole('operator'))  return view('dash.operator');
        if ($user->hasRole('keuangan'))  return view('dash.keuangan');
        if ($user->hasRole('dosen'))     return view('dash.dosen');
        if ($user->hasRole('mahasiswa')) return view('dash.mahasiswa');

        abort(403, 'Role tidak dikenali.');
    }
}
