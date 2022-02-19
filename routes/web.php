<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MBarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;

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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::prefix('/master-barang')->middleware('auth')->group(function() {
    Route::get('', [MBarangController::class, 'index']);
    Route::post('', [MBarangController::class, 'store'])->name('barang.add');
    Route::post('{id}/update', [MBarangController::class, 'update'])->name('barang.edit');
    Route::post('{id}/delete', [MBarangController::class, 'delete']);
    Route::get('{id}', [MBarangController::class, 'detail']);
});
Route::prefix('/master-stok-barang')->middleware('auth')->group(function() {
    Route::get('', [StokController::class, 'index']);
    Route::post('', [StokController::class, 'store'])->name('stok.add');
    Route::post('{id}/update', [StokController::class, 'update'])->name('stok.edit');
    Route::post('{id}/delete', [StokController::class, 'delete']);
    Route::get('{id}', [StokController::class, 'detail']);
});
Route::prefix('/master-suplier')->middleware('auth')->group(function() {
    Route::get('', [SuplierController::class, 'index']);
    Route::post('', [SuplierController::class, 'store'])->name('suplier.add');
    Route::post('{id}/update', [SuplierController::class, 'update'])->name('suplier.edit');
    Route::post('{id}/delete', [SuplierController::class, 'delete']);
    Route::get('{id}', [SuplierController::class, 'detail']);
});
Route::prefix('/master-gudang')->middleware('auth')->group(function() {
    Route::get('', [GudangController::class, 'index']);
    Route::post('', [GudangController::class, 'store'])->name('gudang.add');
    Route::post('{id}/update', [GudangController::class, 'update'])->name('gudang.edit');
    Route::post('{id}/delete', [GudangController::class, 'delete']);
    Route::get('{id}', [GudangController::class, 'detail']);
});

Route::prefix('/pembelian')->middleware('auth')->group(function() {
    Route::get('', [PembelianController::class, 'index']);
    Route::post('', [PembelianController::class, 'store'])->name('pembelian.add');
    Route::post('{id}/update', [PembelianController::class, 'update'])->name('pembelian.edit');
    Route::post('{id}/delete', [PembelianController::class, 'delete']);
    Route::get('{id}', [PembelianController::class, 'detail']);
});
Route::prefix('/penjualan')->middleware('auth')->group(function() {
    Route::get('', [PenjualanController::class, 'index']);
    Route::post('', [PenjualanController::class, 'store'])->name('penjualan.add');
    Route::post('{id}/update', [PenjualanController::class, 'update'])->name('penjualan.edit');
    Route::post('{id}/delete', [PenjualanController::class, 'delete']);
    Route::get('{id}', [PenjualanController::class, 'detail']);
});

require __DIR__.'/auth.php';
