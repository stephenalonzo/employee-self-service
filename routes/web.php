<?php

use App\Http\Controllers\SelfServiceController;
use App\Http\Controllers\TimePunchController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [SelfServiceController::class, 'index'])->name('dashboard');
    Route::get('/time-punch', [\App\Http\Controllers\PunchController::class, 'index'])->name('time-punch');
    Route::post('/time-punch/time_in', [\App\Http\Controllers\PunchController::class, 'store'])->name('time-punch.store');
});

require __DIR__ . '/settings.php';
