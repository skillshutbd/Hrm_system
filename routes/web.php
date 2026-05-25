<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;

Route::get('/admin/signup', [AdminAuthController::class, 'registrationForm'])->name('admin.signup');
Route::post('/admin/signup', [AdminAuthController::class, 'registration'])->name('admin.reg.submit');
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');