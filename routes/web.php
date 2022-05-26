<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\KiosController;
use App\Http\Controllers\Admin\TarifKiosController;
use App\Http\Controllers\Admin\TarifKwhController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\RelasiKiosController;
use App\Http\Controllers\Admin\SewaKiosController;
use App\Http\Controllers\Admin\HistoriSewaKiosController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['checkRole:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'] );
    // hanya admin yang bisa akses
    Route::resource('dashboard/master-admin', AdminController::class)->except('show');
    Route::resource('dashboard/master-petugas', PetugasController::class)->except('show');
    Route::resource('dashboard/master-kios', KiosController::class)->except('show');
    Route::resource('dashboard/master-tarifKios', TarifKiosController::class)->except('show');
    Route::resource('dashboard/master-tarifKwh', TarifKwhController::class)->except('show');
    Route::resource('dashboard/master-lokasi', LokasiController::class)->except('show');

    Route::resource('dashboard/master-user', UserController::class)->except('show');
    Route::resource('dashboard/master-informasi', InformasiController::class);
    Route::resource('dashboard/master-relasiKios', RelasiKiosController::class);
    Route::resource('dashboard/sewa-kios', SewaKiosController::class);
});

Route::middleware(['checkRole:admin,operator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'] );
    // hanya admin yang bisa akses
    Route::resource('dashboard/master-kios', KiosController::class);
    Route::resource('dashboard/master-tarifKios', TarifKiosController::class);
    Route::resource('dashboard/master-tarifKwh', TarifKwhController::class);
    Route::resource('dashboard/master-lokasi', LokasiController::class);

    Route::resource('dashboard/master-user', UserController::class)->except('show');
    Route::resource('dashboard/master-informasi', InformasiController::class);
    Route::resource('dashboard/master-relasiKios', RelasiKiosController::class);
    Route::resource('dashboard/sewa-kios', SewaKiosController::class);
    Route::get('dashboard/histori-sewa', [HistoriSewaKiosController::class, 'index'] )->name('histori-sewa');
});


// Route::get('/dashboard', function () {
//     // return view('dashboard');


// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
