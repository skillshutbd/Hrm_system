<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamLead\TeamLeadController; 
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamLead\TlNotificationController;

Route::get('/teamleads/dashboard',[TeamLeadController::class,'dashboard'])->name('team_lead.dashboard');
Route::get('/teamleads/members',[TeamLeadController::class,'memberIndex'])->name('team_lead.memberIndex');

Route::post('/teamlead/logout',[AdminAuthController::class,'logout'])->name('team_lead.logout');

Route::get('/teamlead/profile',[ProfileController::class,'profile'])-> name('team_lead.profile');

Route::get('/team_lead/recommend_index',[TeamLeadController::class,'recommend_index'])-> name('team_lead.index');

  Route::patch('/leave/{leave}/recommend',     [TeamLeadController::class, 'recommend'])    ->name('tl.leave.recommend');
Route::patch('/leave/{leave}/not-recommend', [TeamLeadController::class, 'notRecommend']) ->name('tl.leave.not-recommend');
Route::get('/leave/{leave}',                 [TeamLeadController::class, 'show'])         ->name('tl.leave.show');

// routes এ team_lead group এর ভেতরে
// Route::post('notifications/{id}/read',
//     ['App\Http\Controllers\TeamLead\TlNotificationController', 'markRead'])
//     ->name('team_lead.notifications.mark-all-read');

Route::patch('/team_lead/notifications/{id}/read', [TeamLeadController::class, 'markNotificationRead'])
    ->name('team_lead.notifications.read');
 
Route::patch('/team_lead/notifications/mark-all-read', [TeamLeadController::class, 'markAllNotificationsRead'])
    ->name('team_lead.notifications.mark-all-read');
 
Route::get('/team_lead/notifications', [TeamLeadController::class, 'notificationsIndex'])
    ->name('team_lead.notifications.index');
 