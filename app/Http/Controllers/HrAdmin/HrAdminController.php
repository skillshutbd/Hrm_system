<?php

namespace App\Http\Controllers\HrAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;

use Illuminate\Http\Request;
class HrAdminController extends Controller
{
    public function dashboard()
    {
        return view('hr.hr_admin');
    }

    public function employeeDirectory()
    {
        $employees = Employee::all();
        return view('hr.employee.index', compact('employees'));
    }

    

    public function teamLeadAssignment()
    {
        $employees = Employee::all();
        return view('hr.teamlead.index', compact('employees'));
    }


}