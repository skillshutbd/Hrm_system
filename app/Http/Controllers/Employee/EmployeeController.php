<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;

use  App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Leave;


class EmployeeController extends Controller{


   public function dashboard()
{
    $employee = auth('employee')->user();

    $leaveTypes = LeaveType::where('is_active', 1)->get();

    // Approved leave — type অনুযায়ী কতদিন নেওয়া হয়েছে
    $usedByType = Leave::where('employee_id', $employee->id)
        ->where('status', 'approved')
        ->selectRaw('leave_type_id, SUM(duration) as used_days')
        ->groupBy('leave_type_id')
        ->pluck('used_days', 'leave_type_id');

    // নির্দিষ্ট type খোঁজো
    $annual = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'annual'));
    $sick   = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'sick'));
    $casual = $leaveTypes->first(fn($t) => str_contains(strtolower($t->name), 'casual'));

    // Used days per type
    $annualUsed = $annual ? ($usedByType[$annual->id] ?? 0) : 0;
    $sickUsed   = $sick   ? ($usedByType[$sick->id]   ?? 0) : 0;
    $casualUsed = $casual ? ($usedByType[$casual->id]  ?? 0) : 0;

    // Annual balance
    $annualBalance = $annual
        ? max(0, $annual->days_allowed - $annualUsed)
        : 0;

    // Total remaining — সব type এর allowed - used
    $totalAllowed    = $leaveTypes->sum('days_allowed');
    $totalUsed       = $usedByType->sum();
    $remainingLeaves = max(0, $totalAllowed - $totalUsed);

    // Recent leave history — last 5
    $recentLeaves = Leave::where('employee_id', $employee->id)
        ->with('leaveType')
        ->latest()
        ->take(5)
        ->get();

    // HR Manager
    $hrManager = \App\Models\HrAdmin::first();

    return view('employee.dashboard', compact(
        'leaveTypes',
        'annual', 'sick', 'casual',
        'annualBalance', 'annualUsed',
        'sickUsed', 'casualUsed',
        'remainingLeaves',
        'recentLeaves',
        'hrManager'
    ));
}
}

