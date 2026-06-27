<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeaveNotification;
use App\Models\Tl;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::where('employee_id', auth('employee')->id())
            ->with('leaveType')
            ->latest()
            ->paginate(10);

        return view('employee.leave.index', compact('leaves'));
    }

    public function create()
    {
        $employeeId = auth('employee')->id();

        $leaveTypes = LeaveType::where('is_active', 1)->get();

        $usedByType = Leave::where('employee_id', $employeeId)
            ->where('status', 'approved')
            ->selectRaw('leave_type_id, SUM(duration) as used_days')
            ->groupBy('leave_type_id')
            ->pluck('used_days', 'leave_type_id');

        $pendingByType = Leave::where('employee_id', $employeeId)
            ->where('status', 'pending')
            ->selectRaw('leave_type_id, SUM(duration) as pending_days')
            ->groupBy('leave_type_id')
            ->pluck('pending_days', 'leave_type_id');

        $totalAllowed    = $leaveTypes->sum('days_allowed');
        $totalUsed       = $usedByType->sum();
        $remainingLeaves = max(0, $totalAllowed - $totalUsed);

        $annual = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'annual'));
        $sick   = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'sick'));
        $casual = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'casual'));

        $annualUsed    = $annual ? ($usedByType[$annual->id] ?? 0) : 0;
        $annualBalance = $annual ? max(0, $annual->days_allowed - $annualUsed) : 0;

        $sickUsed   = $sick   ? ($usedByType[$sick->id] ?? 0)   : 0;
        $casualUsed = $casual ? ($usedByType[$casual->id] ?? 0) : 0;

        return view('employee.leave.create', compact(
            'leaveTypes', 'remainingLeaves',
            'annual', 'sick', 'casual',
            'annualBalance', 'annualUsed', 'casualUsed',
            'usedByType', 'pendingByType'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_type,id',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'reason'        => 'required|string|max:1000',
            'attachment'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        $from     = \Carbon\Carbon::parse($validated['from_date']);
        $to       = \Carbon\Carbon::parse($validated['to_date']);
        $duration = 0;
        $current  = $from->copy();
        while ($current <= $to) {
            if (!$current->isWeekend()) $duration++;
            $current->addDay();
        }

        $employee = auth('employee')->user();

        $leave = Leave::create([
            'employee_id'   => $employee->id,
            'leave_type_id' => $validated['leave_type_id'],
            'from_date'     => $validated['from_date'],
            'to_date'       => $validated['to_date'],
            'duration'      => $duration,
            'reason'        => $validated['reason'],
            'attachment'    => $attachmentPath,
            'status'        => 'pending',
            'tl_status'     => 'pending',
        ]);

        // Employee এর department অনুযায়ী TL খুঁজো
        $tl = Tl::whereHas('employee', function ($q) use ($employee) {
            $q->where('department_id', $employee->department_id);
        })->first();

        if ($tl) {
            LeaveNotification::create([
                'leave_id'       => $leave->id,
                'recipient_type' => 'tl',
                'recipient_id'   => $tl->id,
                'type'           => 'leave_request',
                'message'        => $employee->name . ' has submitted a leave request for your review.',
            ]);
        }

        return redirect()
            ->route('employee.dashboard')
            ->with('success', 'Leave request submitted successfully.');
    }
}