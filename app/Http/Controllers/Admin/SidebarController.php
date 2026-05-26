<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use illuminate\Http\View;

class SidebarController extends Controller
{
    public function dashbooard()
    {
        return view('admin.dashbooard.index');
    }

    public function Department()
    {
        return view('admin.department.index');
    }

     public function Employee()
    {
        return view('admin.employee.index');
    }

    public function TeamLead()
    {
        return view('admin.teamlead.index');
    }

    public function employee_activity()
    {
        return view('admin.employee_activity.index');
    }

    public function employee_leave()
    {
        return view('admin.leave.index');
    }


    
}