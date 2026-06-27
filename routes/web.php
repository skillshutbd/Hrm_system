<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;


/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/admin/signup', [AdminAuthController::class, 'registrationForm'])->name('admin.signup');
Route::post('/admin/signup', [AdminAuthController::class, 'registration'])->name('admin.reg.submit');
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return redirect()->route('admin.dashboard.index');
    })->name('admin.dashboard');
});