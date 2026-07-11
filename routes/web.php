<?php

use App\Http\Controllers\TimePunchController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/time-punch', [TimePunchController::class, 'index'])->name('time-punch');
});

require __DIR__ . '/settings.php';
