<?php

namespace App\Http\Controllers\HrAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\LeaveNotification;
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
    $leave->update(['status' => 'approved']);

    LeaveNotification::create([
        'leave_id'       => $leave->id,
        'recipient_type' => 'employee',
        'recipient_id'   => $leave->employee_id,
        'type'           => 'hr_approved',
        'message'        => 'Your leave request has been approved by HR.',
    ]);

    return redirect()->back()->with('success', 'Leave approved.');
}

public function reject(Leave $leave)
{
    $leave->update(['status' => 'rejected']);

    LeaveNotification::create([
        'leave_id'       => $leave->id,
        'recipient_type' => 'employee',
        'recipient_id'   => $leave->employee_id,
        'type'           => 'hr_rejected',
        'message'        => 'Your leave request has been rejected by HR.',
    ]);

    return redirect()->back()->with('success', 'Leave rejected.');
}


public function notificationsIndex()
{
    $hr = auth('Hr')->user();

    $notifications = LeaveNotification::where('recipient_type', 'hr')
        ->where('recipient_id', $hr->id)
        ->with('leave.employee')
        ->latest()
        ->paginate(15);

    return view('hr.notifications.index', compact('notifications'));
}

public function markNotificationRead($id)
{
    $notification = LeaveNotification::find($id);

    if ($notification) {
        $notification->update(['read_at' => now()]);
    }

    return response()->json(['success' => true]);
}

public function markAllNotificationsRead()
{
    $hr = auth('Hr')->user();

    LeaveNotification::where('recipient_type', 'hr')
        ->where('recipient_id', $hr->id)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    return back()->with('success', 'All notifications marked as read.');
}
}