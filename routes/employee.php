<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Auth\AdminAuthController;

Route::middleware('auth:employee')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
});


Route::post('/employee/logout', [AdminAuthController::class, 'logout'])->name('employee.logout');