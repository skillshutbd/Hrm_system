<?php

namespace App\Http\Controllers\TeamLead;

use App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Tl;
use App\Models\Employee;

use Illuminate\Http\Request;


class TeamLeadController extends Controller{


 public function dashboard()
    {
        return view('team_lead.dashboard');
    }

}