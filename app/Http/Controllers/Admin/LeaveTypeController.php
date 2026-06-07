<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leave_types = LeaveType::all();
        return view('admin.leave.index', compact('leave_types'));
    }

    public function create()
    {
        return view('admin.leave.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'days_allowed' => 'required|integer|min:1',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        LeaveType::create([
            'name'         => $request->name,
            'days_allowed' => $request->days_allowed,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.leave.index')
            ->with('success', 'Leave type created successfully.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('admin.leave.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'days_allowed' => 'required|integer|min:1',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $leaveType->update([
            'name'         => $request->name,
            'days_allowed' => $request->days_allowed,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.leave.index')
            ->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return redirect()->route('admin.leave.index')
            ->with('success', 'Leave type deleted.');
    }
}