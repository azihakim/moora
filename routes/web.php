<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianPerbulanController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RangkingController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RekapPenilaianController;
use App\Http\Controllers\SubKriteriaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', UserController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('sub_kriteria', SubKriteriaController::class);
    Route::resource('alternatif', AlternatifController::class);
    Route::resource('penilaian', PenilaianController::class);
    Route::resource('perhitungan', PerhitunganController::class);
    Route::resource('rangking', RangkingController::class);
});

Route::resource('penilaianPerbulan', PenilaianPerbulanController::class);
Route::get('penilaianPerbulan/{periode}/{id_user}/edit', [PenilaianPerbulanController::class, 'edit']);
Route::get('penilaianPerbulan-cek/{id}', [PenilaianPerbulanController::class, 'cekPenilaianPerbulan'])->name('penilaianPerbulan.cek');
Route::get('penilaianPerbulan-createByUser/{id}', [PenilaianPerbulanController::class, 'createByUser'])->name('penilaianPerbulan.createByUser');

Route::get('countPenilaianPerbulan/{tglDari}/{tglSampai}', [PerhitunganController::class, 'countPenilaianPerbulan'])->name('penilaianPerbulan.count');

Route::post('countPenilaianPerbulan', [PerhitunganController::class, 'countMoora'])->name('penilaianPerbulan.moora');

// Route::get('rekap-hrd/{tglDari}/{tglSampai}', [RekapPenilaianController::class, 'rekapHrd'])->name('rekap.hrd');

Route::get('rekap-hrd/{id}', [RekapPenilaianController::class, 'rekapHrd'])->name('rekapHrd');
Route::get('rekap-perbulan/{id}', [RekapPenilaianController::class, 'rekapPerbulan'])->name('rekapPerbulan');
Route::resource('rekap', RekapPenilaianController::class);
Route::put('rekap-validasi/{id}', [RekapPenilaianController::class, 'updateStatus'])->name('rekap.updateStatus');
