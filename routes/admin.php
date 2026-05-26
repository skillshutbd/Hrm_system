<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SidebarController;
use App\Http\Controllers\Admin\DepartmentController;

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [SidebarController::class, 'dashbooard'])->name('admin.dashboard.index');
    Route::get('/admin/department', [DepartmentController::class, 'index'])->name('admin.department.index');
    Route::get('/admin/department/create', [DepartmentController::class, 'create'])->name('admin.department.create');
    Route::post('/admin/department', [DepartmentController::class, 'store'])->name('admin.department.store');
    Route::get('/admin/department/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit');
    Route::put('/admin/department/{id}', [DepartmentController::class, 'update'])->name('admin.department.update');
    Route::delete('/admin/department/{id}', [DepartmentController::class, 'destroy'])->name('admin.department.destroy');

    Route::get('/admin/employee', [SidebarController::class, 'Employee'])->name('admin.employee.index');
    Route::get('/admin/teamlead', [SidebarController::class, 'TeamLead'])->name('admin.teamlead.index');
    Route::get('/admin/employee-activity', [SidebarController::class, 'employee_activity'])->name('admin.employee_activity.index');
    Route::get('/admin/employee-leave', [SidebarController::class, 'employee_leave'])->name('admin.employee_leave.index');
});