<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\LeaveNotification;
use App\Models\HrAdmin;

class LeaveNotificationService
{
    // ১. Employee submit → TL notify
    public function notifyTlOnSubmit(Leave $leave): void
    {
        $employee   = $leave->employee;
        $department = $employee->department;

        if (!$department || !$department->hod_id) return;

        LeaveNotification::create([
            'leave_id'       => $leave->id,
            'recipient_type' => 'tl',
            'recipient_id'   => $department->hod_id,
            'type'           => 'leave_submitted',
            'message'        => $employee->name . ' has submitted a leave request for ' . $leave->duration . ' day(s).',
        ]);
    }

    // ২. TL recommend → HR notify
    public function notifyHrOnRecommendation(Leave $leave): void
    {
        $tl     = $leave->employee->department->teamLead ?? null;
        $action = $leave->tl_status === 'recommended' ? 'recommended' : 'not recommended';

        HrAdmin::all()->each(function ($hr) use ($leave, $action, $tl) {
            LeaveNotification::create([
                'leave_id'       => $leave->id,
                'recipient_type' => 'hr',
                'recipient_id'   => $hr->id,
                'type'           => 'tl_' . $leave->tl_status,
                'message'        => ($tl->name ?? 'Team Lead') . ' has ' . $action . ' a leave request from ' . $leave->employee->name . '.',
            ]);
        });
    }

    // ৩. HR approve/reject → Employee + TL notify
    public function notifyOnHrDecision(Leave $leave): void
    {
        $action   = $leave->status === 'approved' ? 'approved' : 'rejected';
        $employee = $leave->employee;

        // Employee notify
        LeaveNotification::create([
            'leave_id'       => $leave->id,
            'recipient_type' => 'employee',
            'recipient_id'   => $employee->id,
            'type'           => 'hr_' . $leave->status,
            'message'        => 'Your leave request has been ' . $action . ' by HR.',
        ]);

        // TL notify
        $tlId = $employee->department->hod_id ?? null;
        if ($tlId) {
            LeaveNotification::create([
                'leave_id'       => $leave->id,
                'recipient_type' => 'tl',
                'recipient_id'   => $tlId,
                'type'           => 'hr_' . $leave->status,
                'message'        => $employee->name . "'s leave request has been " . $action . ' by HR.',
            ]);
        }
    }
}