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
   

        return view('employee.leave.create');
    }

    public function store(Request $request)
    {
        
    }
}