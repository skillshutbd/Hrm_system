<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
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

        $leaveTypes = LeaveType::where('is_active', 1)->get();
        $remainingLeaves = $leaveTypes->sum('days_allowed');
       $annual = $leaveTypes->firstWhere('name', 'Annual Leave');
$sick   = $leaveTypes->firstWhere('name', 'Sick leave');
$casual = $leaveTypes->firstWhere('name', 'Casual');

        return view('employee.leave.create',compact('leaveTypes','remainingLeaves','annual','casual','sick'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'leave_type_id' => 'required|exists:leave_types,id',
        'from_date'     => 'required|date',
        'to_date'       => 'required|date|after_or_equal:from_date',
        'reason'        => 'required|string|max:1000',
        'attachment'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);

    // Handle file upload
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
    }

    // Calculate duration (excluding weekends)
    $from     = \Carbon\Carbon::parse($validated['from_date']);
    $to       = \Carbon\Carbon::parse($validated['to_date']);
    $duration = 0;
    $current  = $from->copy();
    while ($current <= $to) {
        if (!$current->isWeekend()) $duration++;
        $current->addDay();
    }

    Leave::create([
        'employee_id'   => auth('employee')->id(),
        'leave_type_id' => $validated['leave_type_id'],
        'from_date'     => $validated['from_date'],
        'to_date'       => $validated['to_date'],
        'duration'      => $duration,
        'reason'        => $validated['reason'],
        'attachment'    => $attachmentPath,
        'status'        => 'pending',
        'tl_status'     => 'pending',
    ]);

    return redirect()
        ->route('employee.dashboard')
        ->with('success', 'Leave request submitted successfully.');
}
}