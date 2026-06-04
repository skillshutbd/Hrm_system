<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('employee_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.notification.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        if ($notification->user_id == Auth::id()) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }
        return redirect()->back()->with('error', 'Unauthorized action.');
    }
}