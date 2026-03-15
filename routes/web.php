<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('bills', BillController::class)->except(['show']);
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
});

require __DIR__.'/auth.php';
