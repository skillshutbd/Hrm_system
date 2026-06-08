<?php

namespace App\Http\Controllers\TeamLead;

use App\Http\Controllers\Controller;
use App\Models\Tl;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
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

        $totalMembers    = $members->count();
        $activeOnLeave   = $members->where('status', 'on_leave')->count();
        $pendingCount    = $leaveRequests->total();

        return view('team_lead.dashboard', compact(
            'leaveRequests',
            'members',
            'totalMembers',
            'activeOnLeave',
            'pendingCount'
        ));
    }

    public function memberIndex()
    {
        $tl           = auth('tl')->user();
        $departmentId = $tl->employee->department_id ?? null;

        $members    = Employee::where('department_id', $departmentId)
            ->where('role', '!=', 'team_lead')
            ->latest()
            ->get();

        $department = Department::find($departmentId);

        return view('team_lead.members.index', compact('members', 'department'));
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
        ]);

        return back()->with('success', 'Leave declined.');
    }

    public function show(Leave $leave)
    {
        $leave->load(['employee', 'leaveType']);
        return view('team_lead.leave.show', compact('leave'));
    }
}