<?php

use App\Http\Controllers\SelfServiceController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [SelfServiceController::class, 'index'])->name('dashboard');
    Route::get('/time-punch', [\App\Http\Controllers\PunchController::class, 'index'])->name('time-punch');
    Route::post('/time-punch/create', [\App\Http\Controllers\PunchController::class, 'store'])->name('time-punch.store');
//    Route::put('/time-punch/{user}/lunch_out', [\App\Http\Controllers\PunchController::class, 'update'])->name('time-punch.lunch_out');
//    Route::put('/time-punch/{user}/lunch_in', [\App\Http\Controllers\PunchController::class, 'update'])->name('time-punch.lunch_in');
//    Route::put('/time-punch/{user}/time_out', [\App\Http\Controllers\PunchController::class, 'update'])->name('time-punch.time_out');
});

require __DIR__ . '/settings.php';
