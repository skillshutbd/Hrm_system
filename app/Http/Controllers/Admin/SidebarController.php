<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Leave;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function dashbooard()
    {
        $totalEmployees   = Employee::count();
        $totalDepartments = Department::count();
        $totalTeamLeads   = Employee::where('role', 'team_lead')->count();

        // Pending queue — TL recommended (or skipped) but not yet finally approved/rejected
        // Admin can act on this in case HR missed it
        $pendingLeaves = Leave::with(['employee.department', 'leaveType'])
            ->where('status', 'pending')
            ->whereIn('tl_status', ['recommended', 'skipped'])
            ->latest()
            ->take(6)
            ->get();

        // Recently approved — show who approved it (HR or Admin)
        $approvedLeaves = Leave::with(['employee.department', 'leaveType'])
            ->where('status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        // Activity log — recent leave status changes + notifications
        $recentLeaveActivity = Leave::with('employee')
            ->whereIn('status', ['approved', 'rejected'])
            ->orWhere('tl_status', 'recommended')
            ->latest()
            ->take(5)
            ->get();

        $recentNotifications = \App\Models\Notification::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'totalTeamLeads',
            'pendingLeaves',
            'approvedLeaves',
            'recentLeaveActivity',
            'recentNotifications'
        ));
    }

    public function approveLeave(Leave $leave)
    {
        $leave->update([
            'status'        => 'approved',
            'approver_type' => 'super_admin',
            'approver_id'   => auth()->id(),
        ]);

        return back()->with('success', 'Leave approved by Admin.');
    }

    public function rejectLeave(Request $request, Leave $leave)
    {
        $request->validate([
            'hr_note' => 'required|string|max:500',
        ]);

        $leave->update([
            'status'        => 'rejected',
            'hr_note'       => $request->hr_note,
            'approver_type' => 'super_admin',
            'approver_id'   => auth()->id(),
        ]);

        return back()->with('success', 'Leave rejected by Admin.');
    }

    public function Department() { return view('admin.department.index'); }
    public function Employee() { return view('admin.employee.index'); }
    public function TeamLead() { return view('admin.teamlead.index'); }
    public function employee_activity() { return view('admin.employee_activity.index'); }
    public function employee_leave() { return view('admin.leave.request-directory'); }
}