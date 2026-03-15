<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SolarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('bills', BillController::class)->except(['show']);
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/solar', [SolarController::class, 'index'])->name('solar.index');
    Route::get('/solar/calculate', [SolarController::class, 'calculate'])->name('solar.calculate');
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/csv', [ExportController::class, 'csv'])->name('export.csv');
    Route::post('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
});

require __DIR__.'/auth.php';
