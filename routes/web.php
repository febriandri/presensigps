<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    // edit profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

    // histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    // izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/panel/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);

    // karyawan
    Route::get('/panel/karyawan', [KaryawanController::class, 'index']);
    Route::post('/panel/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/panel/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/panel/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/panel/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);
    
    // presensi
    Route::get('/panel/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/panel/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/panel/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/panel/presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('/panel/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/panel/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);
    // Route::get('/panel/presensi/laporan', [PresensiController::class, 'laporan']);
    // Route::post('/panel/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);

    // konfigurasi
    Route::get('/panel/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/panel/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    // izin / sakit

});

