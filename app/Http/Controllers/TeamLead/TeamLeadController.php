<?php

namespace App\Http\Controllers\TeamLead;

use App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Tl;
use App\Models\Department;
use App\Models\Employee;

use Illuminate\Http\Request;


class TeamLeadController extends Controller{


 public function dashboard()
    {
        return view('team_lead.dashboard');
    }

    public function memberIndex(){
        $tl = auth('tl')->user();

    
    $departmentId = $tl->employee->department_id ?? null;

    $members = Employee::where('department_id', $departmentId)
        ->where('role', '!=', 'team_lead')
        ->latest()
        ->get();

    $department = Department::find($departmentId);

    return view('team_lead.members.index', compact('members', 'department'));


    }

}