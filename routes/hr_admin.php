<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HrAdmin\HrAdminController; 
use App\Http\Controllers\Admin\EmployeeController;


Route::get('/hr_admin/dashboard', [HrAdminController::class, 'dashboard'])->name('hr_admin.dashboard');


Route::get('/hr_admin/employee-directory', [HrAdminController::class, 'employeeDirectory'])->name('hr_admin.employee_directory');
Route::get('/hr_admin/teamlead-assignment', [HrAdminController::class, 'teamLeadAssignment'])->name('hr_admin.teamlead_assignment');

