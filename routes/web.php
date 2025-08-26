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
    });

    // Mahasiswa
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        Route::get('krs', [KRSController::class, 'index'])->name('mhs.krs');
        Route::post('krs/submit', [KRSController::class, 'submit'])->name('mhs.krs.submit');
        Route::delete('krs/{plan}', [KRSController::class, 'drop'])->name('mhs.krs.drop');
        Route::get('tagihan', [BillingController::class,'studentInvoices'])->name('mhs.tagihan');
    });

    // Dosen
    Route::prefix('dosen')->middleware('role:dosen')->group(function () {
        Route::get('nilai', [NilaiController::class, 'index'])->name('dsn.nilai');
        Route::post('nilai/{krs}/update', [NilaiController::class,'update'])->name('dsn.nilai.update');
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
    });

    // Keuangan
    Route::prefix('keuangan')->middleware('role:keuangan')->group(function () {
        Route::get('tagihan', [BillingController::class,'index'])->name('keu.tagihan');
        Route::post('tagihan/generate', [BillingController::class,'generate'])->name('keu.tagihan.generate');
        Route::post('pembayaran/create', [BillingController::class,'createPayment'])->name('keu.pembayaran.create');
        Route::post('pembayaran/verify', [BillingController::class,'verify'])->name('keu.pembayaran.verify');
    });
});

require __DIR__.'/auth.php';
