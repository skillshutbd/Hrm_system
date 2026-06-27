<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamLead\TeamLeadController; 
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ProfileController;

Route::get('/teamleads/dashboard',[TeamLeadController::class,'dashboard'])->name('team_lead.dashboard');
Route::get('/teamleads/members',[TeamLeadController::class,'memberIndex'])->name('team_lead.memberIndex');

Route::post('/teamlead/logout',[AdminAuthController::class,'logout'])->name('team_lead.logout');

Route::get('/teamlead/profile',[ProfileController::class,'profile'])-> name('team_lead.profile');



  Route::patch('/leave/{leave}/recommend',     [TeamLeadController::class, 'recommend'])    ->name('tl.leave.recommend');
Route::patch('/leave/{leave}/not-recommend', [TeamLeadController::class, 'notRecommend']) ->name('tl.leave.not-recommend');
Route::get('/leave/{leave}',                 [TeamLeadController::class, 'show'])         ->name('tl.leave.show');