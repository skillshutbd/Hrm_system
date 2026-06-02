<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HrAdmin\HrAdminController; 

Route::get('/hr_admin/dashboard', [HrAdminController::class, 'dashboard'])->name('hr_admin.dashboard');

Route::get('/hr_admin/login', [AdminAuthController::class, 'loginForm'])->name('hr_admin.login');
Route::post('/hr_admin/login', [AdminAuthController::class, 'login'])->name('hr_admin.login.submit');
Route::post('/hr_admin/logout', [AdminAuthController::class, 'logout'])->name('hr_admin.logout');
Route::get('/hr_admin/profile', [AdminAuthController::class, 'profile'])->name('hr_admin.profile');