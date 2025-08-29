<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Mahasiswa\KRSController;
use App\Http\Controllers\Dosen\NilaiController;
use App\Http\Controllers\Operator\MasterDataController;
use App\Http\Controllers\Keuangan\BillingController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('landing'); // resources/views/landing.blade.php
})->name('home');

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('roles', fn() => view('admin.roles'))->name('admin.roles');
        Route::get('system', [\App\Http\Controllers\Admin\SystemController::class,'index'])->name('admin.system');
    });

        // Mahasiswa
        Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
            Route::get('krs', [KRSController::class, 'index'])->name('mhs.krs');
            Route::post('krs/submit', [KRSController::class, 'submit'])->name('mhs.krs.submit');
            Route::delete('krs/{plan}', [KRSController::class, 'drop'])->name('mhs.krs.drop');
            Route::get('tagihan', [BillingController::class,'studentInvoices'])->name('mhs.tagihan');

            Route::prefix('layanan')->group(function () {
                Route::get('cuti', [\App\Http\Controllers\Mahasiswa\StudentServiceController::class,'formCuti'])->name('mhs.req.cuti.form');
                Route::post('cuti', [\App\Http\Controllers\Mahasiswa\StudentServiceController::class,'storeCuti'])->name('mhs.req.cuti.store');

                Route::get('pengunduran', [\App\Http\Controllers\Mahasiswa\StudentServiceController::class,'formResign'])->name('mhs.req.resign.form');
                Route::post('pengunduran', [\App\Http\Controllers\Mahasiswa\StudentServiceController::class,'storeResign'])->name('mhs.req.resign.store');

                Route::get('riwayat', [\App\Http\Controllers\Mahasiswa\StudentServiceController::class,'history'])->name('mhs.req.history');
        });
            Route::get('cs', fn() => view('mahasiswa.cs'))->name('mhs.cs');
    });

    // Dosen
    Route::prefix('dosen')->middleware('role:dosen')->group(function () {
        Route::get('nilai', [NilaiController::class, 'index'])->name('dsn.nilai');
        Route::post('nilai/{krs}/update', [NilaiController::class,'update'])->name('dsn.nilai.update');
        Route::get('presensi', [\App\Http\Controllers\Dosen\PresensiController::class,'index'])->name('dsn.presensi');
    Route::get('bimbingan', [\App\Http\Controllers\Dosen\BimbinganController::class,'index'])->name('dsn.bimbingan');
    });

    // Operator
    Route::prefix('operator')->middleware('role:operator')->group(function () {
        Route::get('master-data', [MasterDataController::class,'index'])->name('opr.master');

        Route::post('master-data/program', [MasterDataController::class,'storeProgram'])->name('opr.program.store');
        Route::delete('master-data/program/{program}', [MasterDataController::class,'destroyProgram'])->name('opr.program.destroy');

        Route::post('master-data/course', [MasterDataController::class,'storeCourse'])->name('opr.course.store');
        Route::delete('master-data/course/{course}', [MasterDataController::class,'destroyCourse'])->name('opr.course.destroy');

        Route::post('master-data/class', [MasterDataController::class,'storeClass'])->name('opr.class.store');
        Route::delete('master-data/class/{courseClass}', [MasterDataController::class,'destroyClass'])->name('opr.class.destroy');
        Route::get('schedule', [\App\Http\Controllers\Operator\ScheduleController::class,'index'])->name('opr.schedule');
        Route::get('sync', [\App\Http\Controllers\Operator\ScheduleController::class,'sync'])->name('opr.sync');

        Route::get('layanan-mahasiswa', [StudentRequestApprovalController::class,'index'])->name('opr.reqs.index');
        Route::get('layanan-mahasiswa/{req}', [StudentRequestApprovalController::class,'show'])->name('opr.reqs.show');
        Route::post('layanan-mahasiswa/{req}/approve', [StudentRequestApprovalController::class,'approve'])->name('opr.reqs.approve');
        Route::post('layanan-mahasiswa/{req}/reject', [StudentRequestApprovalController::class,'reject'])->name('opr.reqs.reject');
    });

    // Keuangan
    Route::prefix('keuangan')->middleware('role:keuangan')->group(function () {
        Route::get('tagihan', [BillingController::class,'index'])->name('keu.tagihan');
        Route::post('tagihan/generate', [BillingController::class,'generate'])->name('keu.tagihan.generate');
        Route::post('pembayaran/create', [BillingController::class,'createPayment'])->name('keu.pembayaran.create');
        Route::post('pembayaran/verify', [BillingController::class,'verify'])->name('keu.pembayaran.verify');
        Route::get('report', [\App\Http\Controllers\Keuangan\ReportController::class,'index'])->name('keu.report');
        Route::get('methods', [\App\Http\Controllers\Keuangan\ReportController::class,'methods'])->name('keu.methods');

    });
});

require __DIR__.'/auth.php';
