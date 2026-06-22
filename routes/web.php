<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('welcome');
Route::post('/report/process', [ReportController::class, 'process'])->name('report.process');

// Jalur Dashboard Modul NON POTS
Route::get('/non-pots-monitoring', [DashboardController::class, 'nonPotsDashboard'])->name('nonpots.dashboard');
Route::get('/non-pots-monitoring/performa-am', [DashboardController::class, 'nonPotsPerformaAm'])->name('nonpots.performa_am'); // Route Baru

// Jalur Dashboard Modul Visit PANPC
Route::get('/visit-panpc', [DashboardController::class, 'visitPanpcDashboard'])->name('visitpranpc.dashboard');
