<?php

namespace App\Http\Controllers\TeamLead;


use App\Http\Controllers\Controller;
use App\Models\LeaveNotification;
use Illuminate\Http\Request;

class TlNotificationController extends Controller
{
    // সব notification list
    public function index()
    {
        $tlId = auth('tl')->user()->employee->id ?? null;

        $notifications = LeaveNotification::where('recipient_type', 'tl')
            ->where('recipient_id', $tlId)
            ->with('leave.employee')
            ->latest()
            ->paginate(15);

        return view('team_lead.notifications.index', compact('notifications'));
    }

    // Single notification mark as read
    public function markRead(int $id)
    {
        $tlId = auth('tl')->user()->employee->id ?? null;

        LeaveNotification::where('id', $id)
            ->where('recipient_type', 'tl')
            ->where('recipient_id', $tlId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // সব notification mark as read
    public function markAllRead()
    {
        $tlId = auth('tl')->user()->employee->id ?? null;

        LeaveNotification::where('recipient_type', 'tl')
            ->where('recipient_id', $tlId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }
}