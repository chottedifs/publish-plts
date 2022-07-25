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
use App\Http\Controllers\Admin\HistoriTagihanController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PltsController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TagihanController;
// use App\Http\Controllers\API\UserController as APIUserController;

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

// Route Super Admin, Operator, Plts
Route::middleware(['checkRole:admin,operator,plts'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

//Route Super Admin, Operator
Route::middleware(['checkRole:admin,operator'])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'] );master-status
    Route::resource('dashboard/master-user', UserController::class)->except('show');
    Route::resource('dashboard/master-user', UserController::class)->except('show');
    Route::post('dashboard/master-user/{id}', [UserController::class, 'isActive'])->name('user-isActive');
    Route::resource('dashboard/master-informasi', InformasiController::class);
    Route::resource('dashboard/master-relasiKios', RelasiKiosController::class);
    Route::resource('dashboard/sewa-kios', SewaKiosController::class);
    Route::resource('dashboard/master-status', StatusController::class);
    Route::resource('dashboard/pembayaran', PembayaranController::class);
    Route::post('dashboard/sewa-kios/{id}', [SewaKiosController::class, 'isActive'])->name('sewa-isActive');
    Route::get('dashboard/histori-tagihan', [HistoriTagihanController::class, 'index'])->name('historiTagihan');
    Route::post('dashboard/histori-tagihan/{id}', [HistoriTagihanController::class, 'isActive'])->name('tagihan-isActive');
});

//Route Super Admin, Plts, Operator
Route::middleware(['checkRole:admin,operator,plts'])->group(function () {
    Route::resource('dashboard/tagihan', TagihanController::class);
    Route::get('dashboard/tagihan-edit-diskon/{id}', [TagihanController::class, 'editDiskon'])->name('edit-diskon');
    Route::put('dashboard/tagihan-update-diskon/{id}', [TagihanController::class, 'updateDiskon'])->name('update-diskon');
    Route::resource('dashboard/master-tarifKwh', TarifKwhController::class)->except('show');
    Route::get('dashboard/tagihan', [TagihanController::class, 'index'])->name('tagihan-index');
    Route::get('dashboard/tagihan-export', [TagihanController::class, 'create'])->name('export-tagihan');
    Route::get('dashboard/tagihan-report', [TagihanController::class, 'export'])->name('export-laporan');
    Route::post('dashboard/tagihan-import', [TagihanController::class, 'import'])->name('import-tagihan');
    Route::get('dashboard/tagihan-diskon', [TagihanController::class, 'createDiskon'])->name('export-tagihan-diskon');
    Route::get('dashboard/report-tagihan', [TagihanController::class, 'reportExcelTagihan'])->name('report-tagihan');
    Route::get('dashboard/cetak-tagihan', [TagihanController::class, 'reportTagihan'])->name('cetak-tagihan');
    Route::post('dashboard/tagihan-diskonImport', [TagihanController::class, 'importDiskon'])->name('import-tagihan-diskon');
});

//Route Super Admin
Route::middleware(['checkRole:admin'])->group(function () {
    Route::resource('dashboard/master-admin', AdminController::class)->except('show');
    Route::resource('dashboard/master-petugas', PetugasController::class)->except('show');
    Route::post('dashboard/master-petugas/{id}', [PetugasController::class, 'isActive'])->name('petugas-isActive');
    Route::resource('dashboard/master-plts', PltsController::class)->except('show');
    Route::post('dashboard/master-plts/{id}', [PltsController::class, 'isActive'])->name('plts-isActive');
    Route::resource('dashboard/master-kios', KiosController::class)->except('show');
    Route::resource('dashboard/master-tarifKios', TarifKiosController::class)->except('show');
    Route::resource('dashboard/master-lokasi', LokasiController::class)->except('show');
});

Route::middleware(['checkRole:user'])->group(function () {
    Route::get('/user', [APIUserController::class, 'index']);
});

require __DIR__ . '/auth.php';
