<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Employee\LeaveController;
use App\Models\leave;

Route::middleware('auth:employee')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');

    //Profile
Route::get('/employee/profile', [ProfileController::class, 'profile'])->name('employee.profile');
  Route::get('/employee/profile/edit', [ProfileController::class, 'edit'])->name('employee.edit');
  Route::put('/employee/profile', [ProfileController::class, 'update'])->name('employee.update');
Route::post('/employee/logout', [AdminAuthController::class, 'logout'])->name('employee.logout');

//Leave

Route::get('/employee/leave',[LeaveController::class,'create'])->name('employee.leave.create');
});




