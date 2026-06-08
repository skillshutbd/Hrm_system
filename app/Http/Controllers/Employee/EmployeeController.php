<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;

use  App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Employee;

use App\Models\LeaveType;


class EmployeeController extends Controller{


    public function dashboard()
    {
        
            $employee = auth('employee')->user();

            $leaveTypes = LeaveType::where('is_active', 1)->get();

       $annual = $leaveTypes->firstWhere('name', 'Annual Leave');
$sick   = $leaveTypes->firstWhere('name', 'Sick leave');
$casual = $leaveTypes->firstWhere('name', 'Casual');
$remainingLeaves = $leaveTypes->sum('days_allowed');

            return view('employee.dashboard', compact('leaveTypes', 'annual', 'sick', 'casual','remainingLeaves'));
     }
}

