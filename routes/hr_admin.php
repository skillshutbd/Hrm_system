<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HrAdmin\HrAdminController; 
use App\Http\Controllers\Admin\EmployeeController;


Route::get('/hr_admin/dashboard', [HrAdminController::class, 'dashboard'])->name('hr_admin.dashboard');
Route::post('/hr_admin/logout', [AdminAuthController::class, 'logout'])->name('hr_admin.logout');

// Employee Management Routes for HR Admin

Route::get('/hr_admin/employee-directory', [HrAdminController::class, 'employeeDirectory'])->name('hr_admin.employee_directory');
Route::get('/hr_admin/employee/create',[EmployeeController::class,'create'])->name('hr_admin.employee.create');
Route::post('/hr_admin/employee',[EmployeeController::class,'store'])->name('hr_admin.employee.store');
Route::get('/hr_admin/employee/{employee}', [EmployeeController::class, 'show'])->name('hr_admin.employee.show');
Route::get('/hr_admin/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('hr_admin.employee.edit');
Route::put('/hr_admin/employee/{employee}', [EmployeeController::class, 'update'])->name('hr_admin.employee.update');
Route::delete('/hr_admin/employee/{employee}', [EmployeeController::class, 'destroy'])->name('hr_admin.employee.destroy');

// Team Lead Assignment Route for HR Admin
Route::get('/hr_admin/teamlead-assignment', [HrAdminController::class, 'teamLeadAssignment'])->name('hr_admin.teamlead_assignment');
Route::post('/hr_admin/tl-assignment/{employee}/toggle', [EmployeeController::class, 'toggleTeamLead'])
    ->name('hr_admin.tl-assignment.toggle');
    Route::delete('/hr_admin/tl-request/{id}/cancel', [EmployeeController::class, 'cancelTlRequest'])->name('hr_admin.tl-request.cancel');

