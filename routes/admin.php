<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SidebarController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Auth\AdminAuthController;
 use App\Http\Controllers\ProfileController;
 use App\Http\Controllers\Admin\LeaveTypeController;


Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [SidebarController::class, 'dashbooard'])->name('admin.dashboard.index');
   
  Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
  Route::get('admin/profile', [ProfileController::class, 'profile'])->name('admin.profile');
  Route::get('admin/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::put('admin/profile', [AdminAuthController::class, 'update'])->name('profile.update');



    // Department Routes
    Route::get('/admin/department', [DepartmentController::class, 'index'])->name('admin.department.index');
    Route::get('/admin/department/create', [DepartmentController::class, 'create'])->name('admin.department.create');
    Route::post('/admin/department', [DepartmentController::class, 'store'])->name('admin.department.store');
    Route::get('/admin/department/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit');
    Route::put('/admin/department/{id}', [DepartmentController::class, 'update'])->name('admin.department.update');
    Route::delete('/admin/department/{id}', [DepartmentController::class, 'destroy'])->name('admin.department.destroy');
// Employee Routes
    Route::get('/admin/employee', [SidebarController::class, 'Employee'])->name('admin.employee.index');
    Route::get('/admin/teamlead', [SidebarController::class, 'TeamLead'])->name('admin.teamlead.index');
    Route::get('/admin/employee-activity', [SidebarController::class, 'employee_activity'])->name('admin.employee_activity.index');
    Route::get('/admin/employee-leave', [SidebarController::class, 'employee_leave'])->name('admin.employee_leave.index');
    Route::get('/admin/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
    Route::post('/admin/employee', [EmployeeController::class, 'store'])->name('admin.employee.store');
    Route::get('/admin/employee/{employee}', [EmployeeController::class, 'show'])->name('admin.employee.show');
    Route::get('/admin/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::put('/admin/employee/{employee}', [EmployeeController::class, 'update'])->name('admin.employee.update');
// Route এ এভাবে রাখো
Route::delete('/admin/employee/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');
    Route::put('/admin/employee/{employee}/approve', [EmployeeController::class, 'approve'])->name('admin.employee.approve');
    Route::put('/admin/employee/{employee}/reject', [EmployeeController::class, 'reject'])->name('admin.employee.reject');

    
// export আগে
Route::get('/leave/export-csv', [SidebarController::class, 'exportLeaveCsv'])->name('admin.leave.export-csv');
    Route::get('/employee/{employee}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::delete('/admin/employee/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');

    Route::get('/leave/{leave}', [SidebarController::class, 'show_leave'])
    ->name('admin.leave.show');


// Team Lead Assignment Routes    

    Route::post('/tl-assignment/{employee}/toggle', [EmployeeController::class, 'toggleTeamLead'])
    ->name('admin.tl-assignment.toggle');

    Route::PUT('/tl-assignment/{id}/approve', [EmployeeController::class, 'approveTlRequest'])->name('admin.tl-assignment.approve');
    Route::PUT('/tl-assignment/{id}/reject', [EmployeeController::class, 'rejectTlRequest'])->name('admin.tl-assignment.reject');

//notification routes
Route::get('/employee/{employee}/creation', [EmployeeController::class, 'EmployeeCreationIndex'])->name('admin.employee.creation_index');
Route::get('/employee/{employee}/request-view', [EmployeeController::class, 'EmployeeCreationView'])->name('admin.employee.creation_view');
    Route::get('/admin/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::put('/admin/notifications/{id}/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
});


//leave
Route::get('/admin/leave_index',[LeaveTypeController::class,'index'])->name('admin.leave.index');

Route::get('/admin/leave_create',[LeaveTypeController::class,'create'])->name('admin.leave.create');
Route::get('/admin/{leaveType}/edit',[LeaveTypeController::class,'edit'])->name('admin.leave.edit');

Route::post('/admin/leave_store',[LeaveTypeController::class,'store'])->name('admin.leave.store');
Route::PUT('/admin/leave_update/{leaveType}',[LeaveTypeController::class,'update'])->name('admin.leave.update');
Route::delete('/admin/leave/{leaveType}', [LeaveTypeController::class, 'destroy'])->name('admin.leave.destroy');


//admin approval
Route::patch('/leave/{leave}/approve', [SidebarController::class, 'approveLeave'])->name('admin.leave.approve');
Route::patch('/leave/{leave}/reject',  [SidebarController::class, 'rejectLeave'])->name('admin.leave.reject');
