<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;

// Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SystemController;

// Mahasiswa
use App\Http\Controllers\Mahasiswa\KRSController;
use App\Http\Controllers\Mahasiswa\PaymentGuideController;
use App\Http\Controllers\Mahasiswa\StudentServiceController;

// Dosen
use App\Http\Controllers\Dosen\NilaiController;
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Dosen\BimbinganController;

// Operator
use App\Http\Controllers\Operator\MasterDataController;
use App\Http\Controllers\Operator\ScheduleController;

// Keuangan
use App\Http\Controllers\Keuangan\BillingController;
use App\Http\Controllers\Keuangan\ReportController;

/*
|--------------------------------------------------------------------------
| Public / Landing
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('landing'); // resources/views/landing.blade.php
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])->group(function () {

    // Dashboard (auto-switch by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | ADMIN
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);               // users.*
        Route::get('roles', fn() => view('admin.roles'))->name('admin.roles');
        Route::get('system', [SystemController::class,'index'])->name('admin.system');
    });

    /*
    |----------------------------------------------------------------------
    | MAHASISWA
    |----------------------------------------------------------------------
    */
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        // KRS & Tagihan
        Route::get('krs', [KRSController::class, 'index'])->name('mhs.krs');
        Route::post('krs/submit', [KRSController::class, 'submit'])->name('mhs.krs.submit');
        Route::delete('krs/{plan}', [KRSController::class, 'drop'])->name('mhs.krs.drop');
        Route::get('tagihan', [BillingController::class,'studentInvoices'])->name('mhs.tagihan');

        // Metode Pembayaran (Panduan)
        Route::get('metode-pembayaran', [PaymentGuideController::class,'show'])->name('mhs.pay.guide');

        // Layanan Akademik (cuti, pengunduran, riwayat)
        Route::prefix('layanan')->name('mhs.req.')->group(function () {
            Route::get('cuti', [StudentServiceController::class,'formCuti'])->name('cuti.form');
            Route::post('cuti', [StudentServiceController::class,'storeCuti'])->name('cuti.store');

            Route::get('pengunduran', [StudentServiceController::class,'formResign'])->name('resign.form');
            Route::post('pengunduran', [StudentServiceController::class,'storeResign'])->name('resign.store');

            Route::get('riwayat', [StudentServiceController::class,'history'])->name('history');
        });

        // CS & Bantuan
        Route::get('cs', fn() => view('mahasiswa.cs'))->name('mhs.cs');
    });

    /*
    |----------------------------------------------------------------------
    | DOSEN UNIVERSITAS
    |----------------------------------------------------------------------
    */
    Route::prefix('dosen')->middleware('role:dosen')->group(function () {
        Route::get('nilai', [NilaiController::class, 'index'])->name('dsn.nilai');
        Route::post('nilai/{krs}/update', [NilaiController::class,'update'])->name('dsn.nilai.update');

        Route::get('presensi', [PresensiController::class,'index'])->name('dsn.presensi');
        Route::get('bimbingan', [BimbinganController::class,'index'])->name('dsn.bimbingan');
    });

    /*
    |----------------------------------------------------------------------
    | OPERATOR PRODI UNIVERSITAS
    |----------------------------------------------------------------------
    */
    Route::prefix('operator')->middleware('role:operator')->group(function () {
        // Master Data
        Route::get('master-data', [MasterDataController::class,'index'])->name('opr.master');
        Route::post('master-data/program', [MasterDataController::class,'storeProgram'])->name('opr.program.store');
        Route::delete('master-data/program/{program}', [MasterDataController::class,'destroyProgram'])->name('opr.program.destroy');

        Route::post('master-data/course', [MasterDataController::class,'storeCourse'])->name('opr.course.store');
        Route::delete('master-data/course/{course}', [MasterDataController::class,'destroyCourse'])->name('opr.course.destroy');

        Route::post('master-data/class', [MasterDataController::class,'storeClass'])->name('opr.class.store');
        Route::delete('master-data/class/{courseClass}', [MasterDataController::class,'destroyClass'])->name('opr.class.destroy');

        // Jadwal & Sinkron
        Route::get('schedule', [ScheduleController::class,'index'])->name('opr.schedule');
        Route::get('sync', [ScheduleController::class,'sync'])->name('opr.sync');
    });

    /*
    |----------------------------------------------------------------------
    | KEUANGAN UNIVERSITAS
    |----------------------------------------------------------------------
    */
    Route::prefix('keuangan')->middleware('role:keuangan')->group(function () {
        // Tagihan & Pembayaran
        Route::get('tagihan', [BillingController::class,'index'])->name('keu.tagihan');
        Route::post('tagihan/generate', [BillingController::class,'generate'])->name('keu.tagihan.generate');
        Route::post('pembayaran/create', [BillingController::class,'createPayment'])->name('keu.pembayaran.create');
        Route::post('pembayaran/verify', [BillingController::class,'verify'])->name('keu.pembayaran.verify');

        // Laporan & Metode Pembayaran
        Route::get('report', [ReportController::class,'index'])->name('keu.report');
        Route::get('methods', [ReportController::class,'methods'])->name('keu.methods');
    });
});

require __DIR__.'/auth.php';
