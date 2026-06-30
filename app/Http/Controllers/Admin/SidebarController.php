<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Leave;
use App\Models\LeaveType;
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

             // ── Unified Activity Feed ──────────────────────────────
   
    $leaveActivities = Leave::with('employee')
        ->whereIn('status', ['approved', 'rejected'])
        ->orWhere('tl_status', 'recommended')
        ->latest()
        ->take(10)
        ->get()
        ->map(function ($leave) {
            $title = $leave->employee->name ?? 'Employee';

            if ($leave->status === 'approved') {
                $desc = 'Leave request approved';
            } elseif ($leave->status === 'rejected') {
                $desc = 'Leave request rejected';
            } elseif ($leave->tl_status === 'recommended') {
                $desc = 'Leave recommended by Team Lead, awaiting approval';
            } else {
                $desc = 'Leave status updated';
            }

            return (object) [
                'type'       => 'leave',
                'title'      => $title,
                'desc'       => $desc,
                'approver'   => $leave->approver_type ?? null,
                'created_at' => $leave->updated_at,
            ];
        });

  
    $generalActivities = \App\Models\Notification::latest()
        ->take(10)
        ->get()
        ->map(function ($notif) {
            $titleMap = [
                'tl_assignment_request' => 'Team Lead Assignment',
                'employee_creation'     => 'New Employee',
            ];

            return (object) [
                'type'       => $notif->type,
                'title'      => $titleMap[$notif->type] ?? 'System Update',
                'desc'       => $notif->message,
                'approver'   => null,
                'created_at' => $notif->updated_at,
            ];
        });

   
    $recentLeaveActivity = $leaveActivities
        ->concat($generalActivities)
        ->sortByDesc('created_at')
        ->take(6)
        ->values();

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

    return view('admin.employee_activity.index', compact(
        'activities',
        'totalActivities',
        'leaveCount',
        'assignmentCount',
        'employeeAddCount',
        'filter'
    ));
}

    public function Department() { return view('admin.department.index'); }
    public function Employee() { return view('admin.employee.index'); }
  public function TeamLead()
{
    $departments = \App\Models\Department::orderBy('name')->get();

    $employeesQuery = \App\Models\Employee::with('department')
        ->when(request('department_id'), function ($query) {
            $query->where('department_id', request('department_id'));
        })
        ->when(request('dept_ids'), function ($query) {
            $query->whereIn('department_id', request('dept_ids'));
        });

    $totalMembers  = (clone $employeesQuery)->count();
    $assignedLeads = (clone $employeesQuery)->where('role', 'team_lead')->count();
    $openPositions = max(0, $totalMembers - $assignedLeads);

    $employees = $employeesQuery->latest()->paginate(8)->withQueryString();

    $pendingRequests = \App\Models\Notification::where('type', 'tl_assignment_request')
        ->where('status', 'pending')
        ->pluck('employee_id')
        ->toArray();

    $pendingNotifications = \App\Models\Notification::where('type', 'tl_assignment_request')
        ->where('status', 'pending')
        ->orderBy('id', 'desc')
        ->get()
        ->keyBy('employee_id');

    return view('admin.teamlead.index', compact(
        'departments',
        'employees',
        'totalMembers',
        'assignedLeads',
        'openPositions',
        'pendingRequests',
        'pendingNotifications'
    ));
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

    return view('admin.leave.request-directory', compact(
        'leaves', 'pendingCount', 'approvedTodayCount', 'onLeaveTodayCount',
        'staffOnLeave', 'leaveTypes'
    ));
}

public function exportLeaveCsv()
{
    $query = Leave::with(['employee.department', 'leaveType'])->latest();

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

    $leaves = $query->get();

    $fileName = 'leave_requests_' . now()->format('Y-m-d_His') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $callback = function () use ($leaves) {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM, Excel friendly

        fputcsv($file, [
            'Employee Name',
            'Designation',
            'Department',
            'Leave Type',
            'From Date',
            'To Date',
            'Duration (Days)',
            'Reason',
            'TL Status',
            'TL Note',
            'Final Status',
            'HR Note',
            'Submitted At',
        ]);

        foreach ($leaves as $leave) {
            fputcsv($file, [
                $leave->employee->name ?? '',
                $leave->employee->designation ?? '',
                $leave->employee->department->name ?? '',
                $leave->leaveType->name ?? '',
                \Carbon\Carbon::parse($leave->from_date)->format('Y-m-d'),
                \Carbon\Carbon::parse($leave->to_date)->format('Y-m-d'),
                $leave->duration,
                $leave->reason,
                $leave->tl_status,
                $leave->tl_note,
                $leave->status,
                $leave->hr_note,
                optional($leave->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($file);
    };

    return response()->streamDownload($callback, $fileName, $headers);
}

public function show_leave(Leave $leave)
{
    $leave->load([
        'employee.department',
        'leaveType',
    ]);

    return view('admin.leave.show', compact('leave'));
}
}