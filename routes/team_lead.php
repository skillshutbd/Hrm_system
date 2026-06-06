<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamLead\TeamLeadController; 

Route::get('/teamleads/dashboard',[TeamLeadController::class,'dashboard'])->name('team_lead.dashboard');