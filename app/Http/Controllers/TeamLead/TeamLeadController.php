<?php

namespace App\Http\Controllers\TeamLead;

use App\Http\Controllers\Controller;
use App\Models\Tl;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveNotification;
use Illuminate\Http\Request;

class TeamLeadController extends Controller
{
    public function dashboard()
    {
        $tl           = auth('tl')->user();
        $departmentId = $tl->employee->department_id ?? null;

        $members = Employee::where('department_id', $departmentId)->get();

        $leaveRequests = Leave::whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            })
            ->where('tl_status', 'pending')
            ->with(['employee', 'leaveType'])
            ->latest()
            ->paginate(5);

        $totalMembers  = $members->count();
        $activeOnLeave = $members->where('status', 'on_leave')->count();
        $pendingCount  = $leaveRequests->total();

        // Unread notifications for this TL
        $tlUnreadNotifications = LeaveNotification::where('recipient_type', 'tl')
            ->where('recipient_id', $tl->id)
            ->whereNull('read_at')
            ->latest()
            ->get();

        $tlUnreadCount = $tlUnreadNotifications->count();


        return view('team_lead.dashboard', compact(
            'leaveRequests',
            'members',
            'totalMembers',
            'activeOnLeave',
            'pendingCount',
            'tlUnreadNotifications',
            'tlUnreadCount'
        ));
    }

  public function memberIndex()
{
    $tl = auth('tl')->user();
    
    // tl.employee_id যেটা employees.id কে point করে
    $employeeId = $tl->employee_id;

    // এই employee যে যে department-এর hod, সেগুলোর id বের করো
    $departmentIds = Department::where('hod_id', $employeeId)->pluck('id');

    // ঐ সব department-এর সব member (team_lead বাদে)
    $members = Employee::whereIn('department_id', $departmentIds)
        ->where('role', '!=', 'team_lead')
        ->latest()
        ->get();

    $departments = Department::whereIn('id', $departmentIds)->get();

    return view('team_lead.members.index', compact('members', 'departments'));
}
  public function recommend_index()
{
    $tl           = auth('tl')->user();
    $departmentId = $tl->employee->department_id ?? null;

    $query = Leave::with(['employee.department', 'leaveType'])
        ->whereHas('employee', function ($q) use ($departmentId) {
            $q->where('department_id', $departmentId);
        });

    // Filter
    $filter = request('filter', 'pending');

    if ($filter === 'pending') {
        $query->where('tl_status', 'pending');
    } elseif ($filter === 'recommended') {
        $query->where('tl_status', 'recommended');
    } elseif ($filter === 'declined') {
        $query->where('tl_status', 'not_recommended');
    }

    $leaves = $query->latest()->paginate(10)->withQueryString();

    // KPI counts
    $baseQuery = Leave::whereHas('employee', function ($q) use ($departmentId) {
        $q->where('department_id', $departmentId);
    });

    $pendingCount    = (clone $baseQuery)->where('tl_status', 'pending')->count();
    $recommendedCount = (clone $baseQuery)->where('tl_status', 'recommended')->count();
    $declinedCount   = (clone $baseQuery)->where('tl_status', 'not_recommended')->count();

    return view('team_lead.recommend.index', compact(
        'leaves', 'filter', 'pendingCount', 'recommendedCount', 'declinedCount'
    ));
}

    public function recommend(Request $request, Leave $leave)
    {
        $request->validate([
            'tl_note' => 'required|string|max:500',
        ]);

        $leave->update([
            'tl_status' => 'recommended',
            'tl_note'   => $request->tl_note,
        ]);

        // HR কে notification পাঠাও — এখন HR এর final approval এর জন্য রেডি
        $hrAdmin = \App\Models\HrAdmin::first();

        if ($hrAdmin) {
            LeaveNotification::create([
                'leave_id'       => $leave->id,
                'recipient_type' => 'hr',
                'recipient_id'   => $hrAdmin->id,
                'type'           => 'leave_recommended',
                'message'        => ($leave->employee->name ?? 'An employee') . '\'s leave has been recommended by TL and awaits your approval.',
            ]);
        }

        return back()->with('success', 'Leave recommended successfully.');
    }

    public function notRecommend(Request $request, Leave $leave)
    {
        $request->validate([
            'tl_note' => 'required|string|max:500',
        ]);

        $leave->update([
            'tl_status' => 'not_recommended',
            'tl_note'   => $request->tl_note,
            'status'    => 'rejected', // TL declined → auto reject, HR এর কাছে যাবে না
        ]);

        return back()->with('success', 'Leave declined.');
    }

    public function show(Leave $leave)
    {
        $leave->load(['employee', 'leaveType']);
        return view('team_lead.leave.show', compact('leave'));
    }

    public function markNotificationRead($id)
{
    $notification = \App\Models\LeaveNotification::find($id);

    if ($notification) {
        $notification->update(['read_at' => now()]);
    }

    return response()->json(['success' => true]);
}

public function markAllNotificationsRead()
{
    $tl = auth('tl')->user();

    \App\Models\LeaveNotification::where('recipient_type', 'tl')
        ->where('recipient_id', $tl->id)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    return back()->with('success', 'All notifications marked as read.');
}

public function notificationsIndex()
{
    $tl = auth('tl')->user();

    $notifications = \App\Models\LeaveNotification::where('recipient_type', 'tl')
        ->where('recipient_id', $tl->id)
        ->with('leave.employee')
        ->latest()
        ->paginate(15);

    return view('team_lead.notifications.index', compact('notifications'));
}
}