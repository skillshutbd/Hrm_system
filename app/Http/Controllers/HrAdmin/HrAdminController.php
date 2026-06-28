<?php

namespace App\Http\Controllers\HrAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Leave;
use App\Models\LeaveType;
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

     public function employee_leave()
{
    $query = Leave::with(['employee.department', 'leaveType'])->latest();

    // Filters
    if (request('leave_type_id')) {
        $query->where('leave_type_id', request('leave_type_id'));
    }

    if (request('status') && request('status') !== 'all') {
        $query->where('status', request('status'));
    }

    if (request('from') && request('to')) {
        $query->whereDate('from_date', '>=', request('from'))
              ->whereDate('to_date', '<=', request('to'));
    }

    $leaves = $query->paginate(10)->withQueryString();

    // KPI
    $pendingCount = Leave::where('status', 'pending')->count();

    $approvedTodayCount = Leave::where('status', 'approved')
        ->whereDate('updated_at', today())
        ->count();

    $onLeaveTodayCount = Leave::where('status', 'approved')
        ->whereDate('from_date', '<=', today())
        ->whereDate('to_date', '>=', today())
        ->count();

    // Currently on leave (today)
    $staffOnLeave = Leave::with('employee')
        ->where('status', 'approved')
        ->whereDate('from_date', '<=', today())
        ->whereDate('to_date', '>=', today())
        ->get();

    $leaveTypes = LeaveType::where('is_active', 1)->get();

    return view('hr.leave.index', compact(
        'leaves', 'pendingCount', 'approvedTodayCount', 'onLeaveTodayCount',
        'staffOnLeave', 'leaveTypes'
    ));
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

public function employee_activity()
{
    $filter = request('filter', 'all');

    $leaveActivities = Leave::with('employee')
        ->whereIn('status', ['approved', 'rejected'])
        ->orWhere('tl_status', 'recommended')
        ->orWhere('tl_status', 'not_recommended')
        ->get()
        ->map(function ($leave) {
            $title = $leave->employee->name ?? 'Employee';

            if ($leave->status === 'approved') {
                $desc = 'Leave request approved';
                $icon = 'bi-check-circle-fill';
                $type = 'approved';
            } elseif ($leave->status === 'rejected') {
                $desc = 'Leave request rejected';
                $icon = 'bi-x-circle-fill';
                $type = 'rejected';
            } elseif ($leave->tl_status === 'recommended') {
                $desc = 'Leave recommended by Team Lead, awaiting final approval';
                $icon = 'bi-hourglass-split';
                $type = 'pending';
            } elseif ($leave->tl_status === 'not_recommended') {
                $desc = 'Leave declined by Team Lead';
                $icon = 'bi-x-circle';
                $type = 'rejected';
            } else {
                $desc = 'Leave status updated';
                $icon = 'bi-info-circle';
                $type = 'info';
            }

            return (object) [
                'category'   => 'leave',
                'type'       => $type,
                'icon'       => $icon,
                'title'      => $title,
                'desc'       => $desc,
                'approver'   => $leave->approver_type ?? null,
                'created_at' => $leave->updated_at,
            ];
        });

    $generalActivities = \App\Models\Notification::get()
        ->map(function ($notif) {
            $titleMap = [
                'tl_assignment_request' => 'Team Lead Assignment',
                'employee_creation'     => 'New Employee',
            ];
            $iconMap = [
                'pending'  => 'bi-hourglass-split',
                'approved' => 'bi-check-circle-fill',
                'rejected' => 'bi-x-circle-fill',
            ];

            return (object) [
                'category'   => $notif->type,
                'type'       => $notif->status,
                'icon'       => $iconMap[$notif->status] ?? 'bi-bell',
                'title'      => $titleMap[$notif->type] ?? 'System Update',
                'desc'       => $notif->message,
                'approver'   => null,
                'created_at' => $notif->updated_at,
            ];
        });

    $allActivities = $leaveActivities->concat($generalActivities)->sortByDesc('created_at')->values();

    // Filter apply করো
    $filteredActivities = match($filter) {
        'leave'      => $allActivities->where('category', 'leave')->values(),
        'assignment' => $allActivities->where('category', 'tl_assignment_request')->values(),
        'employee'   => $allActivities->where('category', 'employee_creation')->values(),
        default      => $allActivities,
    };

    $perPage     = 15;
    $currentPage = request()->get('page', 1);
    $activities  = new \Illuminate\Pagination\LengthAwarePaginator(
        $filteredActivities->forPage($currentPage, $perPage),
        $filteredActivities->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $totalActivities  = $allActivities->count();
    $leaveCount       = $leaveActivities->count();
    $assignmentCount  = $generalActivities->where('category', 'tl_assignment_request')->count();
    $employeeAddCount = $generalActivities->where('category', 'employee_creation')->count();

    return view('hr.employee_activity.index', compact(
        'activities',
        'totalActivities',
        'leaveCount',
        'assignmentCount',
        'employeeAddCount',
        'filter'
    ));
}
}