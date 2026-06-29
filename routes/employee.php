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
Route::post('/employee/leave_request',[LeaveController::class,'store'])->name('employee.leave_request.store');
});
Route::get('/leave/notifications', [EmployeeController::class, 'notificationsIndex'])->name('employee.notifications.index');

Route::patch('/employee/notifications/{id}/read', [EmployeeController::class, 'markNotificationRead'])
    ->name('employee.notifications.read');

Route::patch('/employee/notifications/mark-all-read', [EmployeeController::class, 'markAllNotificationsRead'])
    ->name('employee.notifications.mark-all-read');

Route::get('/employee/notifications', [EmployeeController::class, 'notificationsIndex'])
    ->name('employee.notifications.index');

    Route::get('/leave/history', [EmployeeController::class, 'leave_history'])->name('employee.leave.history');



