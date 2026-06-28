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
    // Leave সংক্রান্ত activity
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

    // TL Assignment + Employee Creation activity
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

    //  merge  date sort
    $allActivities = $leaveActivities
        ->concat($generalActivities)
        ->sortByDesc('created_at')
        ->values();

    // Manual pagination 
    $perPage     = 15;
    $currentPage = request()->get('page', 1);
    $activities  = new \Illuminate\Pagination\LengthAwarePaginator(
        $allActivities->forPage($currentPage, $perPage),
        $allActivities->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    // KPI counts
    $totalActivities   = $allActivities->count();
    $leaveCount        = $leaveActivities->count();
    $assignmentCount   = $generalActivities->where('category', 'tl_assignment_request')->count();
    $employeeAddCount  = $generalActivities->where('category', 'employee_creation')->count();

    return view('admin.employee_activity.index', compact(
        'activities',
        'totalActivities',
        'leaveCount',
        'assignmentCount',
        'employeeAddCount'
    ));
}

    public function Department() { return view('admin.department.index'); }
    public function Employee() { return view('admin.employee.index'); }
    public function TeamLead() { return view('admin.teamlead.index'); }

    public function employee_leave() { return view('admin.leave.request-directory'); }
}