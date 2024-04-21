<?php

use App\Http\Controllers\DataPenjualanController;
use App\Http\Controllers\MasterBarangController;
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

Route::resource('data-barang', MasterBarangController::class);
Route::resource('data-penjualan', DataPenjualanController::class);

Route::post('/data-barang/update', [MasterBarangController::class, 'update']);
Route::post('/data-barang/delete', [MasterBarangController::class, 'destroy']);
