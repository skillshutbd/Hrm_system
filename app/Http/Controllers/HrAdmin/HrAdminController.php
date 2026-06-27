<?php

namespace App\Http\Controllers\HrAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Leave;
use Illuminate\Http\Request;

class HrAdminController extends Controller
{
    public function dashboard()
    {
        // KPI
        $totalEmployees  = Employee::count();
        $totalDepartments = Department::count();

        // HR Final Approval Queue — recommended by TL, pending HR
        $leaveQueue = Leave::where('tl_status', 'recommended')
            ->where('status', 'pending')
            ->with(['employee.department', 'leaveType'])
            ->latest()
            ->take(5)
            ->get();

        // Activity log — recent leaves (any status change)
        $recentActivity = Leave::with(['employee'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orWhere('tl_status', 'recommended')
            ->latest()
            ->take(5)
            ->get();

        return view('hr.hr_admin', compact(
            'totalEmployees',
            'totalDepartments',
            'leaveQueue',
            'recentActivity'
        ));
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

    public function approve(Leave $leave)
    {
        $leave->update([
            'status' => 'approved',
        ]);

        return redirect()->back();
    }

    public function reject(Leave $leave)
    {
        $leave->update([
            'status' => 'rejected',
        ]);

        return redirect()->back();
    }
}