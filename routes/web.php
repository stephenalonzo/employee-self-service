<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\SelfServiceController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [SelfServiceController::class, 'index'])->name('dashboard');
    Route::get('/time-punch', [PunchController::class, 'index'])->name('time-punch');
    Route::post('/time-punch/create', [PunchController::class, 'store'])->name('time-punch.store');
    Route::get('/request-time-off', [LeaveController::class, 'index'])->name('time-off');
    Route::post('/request-time-off/create', [LeaveController::class, 'store'])->name('time-off.store');
});

require __DIR__ . '/settings.php';
