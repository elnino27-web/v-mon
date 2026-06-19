<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Jalur halaman awal V-MON
Route::get('/', [ReportController::class, 'index'])->name('welcome');
Route::post('/report/process', [ReportController::class, 'process'])->name('report.process');

// Placeholder Dashboard (Hanya sementara agar tidak error saat tombol diklik)
Route::get('/visit-monitoring', function() {
    return "Halaman Dashboard Visit Collection V-MON (Dalam Pengerjaan)";
})->name('visit.dashboard');

Route::get('/non-pots-monitoring', function() {
    return "Halaman Dashboard NON POTS V-MON (Dalam Pengerjaan)";
})->name('nonpots.dashboard');
