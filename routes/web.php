<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DashboardController;

// Dashboard
Route::get('/', [DashboardController::class, 'index']);

// Pembelian
Route::resource('pembelian', PembelianController::class);

use App\Http\Controllers\MasterDataController;

// Detail Pembelian
Route::resource('detail-pembelian', DetailPembelianController::class);

// Master Data
Route::resource('masterdata', MasterDataController::class);
