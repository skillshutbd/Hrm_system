<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private function getView(string $view): string
    {
        if (auth('Hr')->check()) {
            return 'hr.' . $view;
        }
        return 'admin.' . $view;
    }

    private function getRoute(string $route): string
    {
        if (auth('Hr')->check()) {
            return 'hrm.' . $route;
        }
        return 'admin.' . $route;
    }

    public function index()
    {
        $employees = Employee::with('department')->latest()->paginate(8);
        $departments = Department::orderBy('name')->get();
        return view($this->getView('employee.index'), compact('employees', 'departments'));
    }

    public function create() 
    {
        $departments = Department::orderBy('name')->get();
        return view($this->getView('employee.create'), compact('departments'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'name'                           => 'required|string|max:255',
        'email'                          => 'required|email|unique:employees,email',
        'phone'                          => 'nullable|string|max:255',
        'employee_id'                    => 'nullable|string|max:255|unique:employees,employee_id',
        'nid'                            => 'required|string|max:255|unique:employees,nid',
        'profile_picture'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'date_of_birth'                  => 'nullable|date',
        'gender'                         => 'nullable|in:male,female,other',
        'address'                        => 'nullable|string|max:255',
        'emergency_contact_name'         => 'nullable|string|max:255',
        'emergency_contact_phone'        => 'nullable|string|max:255',
        'emergency_contact_relationship' => 'nullable|string|max:255',
        'department_id'                  => 'required|exists:departments,id',
        'designation'                    => 'required|string|max:255',
        'role'                           => 'nullable|string|max:255',
        'hire_date'                      => 'nullable|date',
        'password'                       => 'nullable|string|min:8',
        'status'                         => 'nullable|in:pending,active,inactive',
    ]);

    if ($request->hasFile('profile_picture')) {
        $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
    }

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    }

    if (auth('Hr')->check()) {
        $validated['status'] = 'pending';
    } else {
        $validated['status'] = $validated['status'] ?? 'active';
    }

    $employee = Employee::create($validated);

    if (isset($validated['role']) && $validated['role'] === 'hr_admin') {
        $hrAdmin = \App\Models\HrAdmin::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'hr_admin',
        ]);

        $hrAdmin->assignRole('hr_admin');
    }

    if (auth('Hr')->check()) {
        \App\Models\Notification::create([
            'type'         => 'employee_creation',
            'employee_id'  => $employee->id,
            'requested_by' => auth('Hr')->id(),
            'message'      => auth('Hr')->user()->name . ' has created a new employee: ' . $validated['name'],
            'status'       => 'pending',
        ]);
    }

    return view($this->getView('employee.index'))->with('success', 'Employee created successfully.');
}

    public function show(Employee $employee)
    {
        $employee->load('department');
        return view($this->getView('employee.show'), compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();
        return view($this->getView('employee.edit'), compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'                           => 'required|string|max:255',
            'email'                          => 'required|email|unique:employees,email,' . $employee->id,
            'phone'                          => 'nullable|string|max:255',
            'employee_id'                    => 'nullable|string|max:255|unique:employees,employee_id,' . $employee->id,
            'nid'                            => 'required|string|max:255|unique:employees,nid,' . $employee->id,
            'profile_picture'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth'                  => 'nullable|date',
            'gender'                         => 'nullable|in:male,female,other',
            'address'                        => 'nullable|string|max:255',
            'emergency_contact_name'         => 'nullable|string|max:255',
            'emergency_contact_phone'        => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'department_id'                  => 'required|exists:departments,id',
            'designation'                    => 'required|string|max:255',
            'role'                           => 'nullable|string|max:255',
            'hire_date'                      => 'nullable|date',
            'password'                       => 'nullable|string|min:8',
            'status'                         => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route($this->getRoute('employee.index'))->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route($this->getRoute('employee.index'))->with('success', 'Employee deleted successfully.');
    }

    public function exportCsv()
    {

    
        $fileName = 'employees.csv';
        $employees = Employee::with('department')->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($employees) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Employee ID', 'NID', 'Name', 'Email', 'Phone',
                'Department', 'Designation', 'Role', 'Hire Date', 'Status',
                'Address', 'Emergency Contact Name', 'Emergency Contact Phone',
                'Emergency Contact Relationship', 'Created At',
            ]);

            foreach ($employees as $employee) {
                fputcsv($file, [
                    $employee->employee_id,
                    $employee->nid,
                    $employee->name,
                    $employee->email,
                    $employee->phone,
                    $employee->department->name ?? '',
                    $employee->designation,
                    $employee->role,
                    $employee->hire_date,
                    $employee->status,
                    $employee->address,
                    $employee->emergency_contact_name,
                    $employee->emergency_contact_phone,
                    $employee->emergency_contact_relationship,
                    optional($employee->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function toggleTeamLead(Employee $employee)
    {

        if (auth('Hr')->check()) {
        // HR থেকে request — admin কে notification পাঠাবে
        \App\Models\Notification::create([
            'type'         => 'tl_assignment_request',
            'employee_id'  => $employee->id,
            'requested_by' => auth('Hr')->id(),
            'message'      => auth('Hr')->user()->name . ' wants to assign ' . $employee->name . ' as Team Lead.',
            'status'       => 'pending',
        ]);

         $existing = \App\Models\Notification::where('type', 'tl_assignment_request')
        ->where('employee_id', $employee->id)
        ->where('status', 'pending')
        ->first();

    if ($existing) {
        return back()->with('info', 'Request already pending for this employee.');
    }

            return back()->with('success', 'Employee role updated successfully.');
        }
        $employee->update([
            'role' => $employee->role === 'team_lead' ? 'employee' : 'team_lead',
        ]);

        return back()->with('success', 'Employee role updated successfully.');
    }

    public function cancelTlRequest(int $id)
{
    \App\Models\Notification::where('id', $id)
        ->where('status', 'pending')
        ->delete();

    return back()->with('success', 'TL request cancelled.');
}

public function approveTlRequest(int $id)
{
    $notification = \App\Models\Notification::findOrFail($id);

    // Employee role update
    Employee::findOrFail($notification->employee_id)->update(['role' => 'team_lead']);

    // Notification status update
    $notification->update(['status' => 'approved', 'read_at' => now()]);

    return back()->with('success', 'TL request approved.');
}

public function rejectTlRequest(int $id)
{
    $notification = \App\Models\Notification::findOrFail($id);
    $notification->update(['status' => 'rejected', 'read_at' => now()]);

    return back()->with('success', 'TL request rejected.');
}

    public function approve(Employee $employee)
    {
         $employee->update(['status' => 'active']);

    \App\Models\Notification::where('employee_id', $employee->id)
        ->where('type', 'employee_creation')
        ->where('status', 'pending')
        ->update(['status' => 'approved', 'read_at' => now()]);

    return back()->with('success', $employee->name . ' approved successfully.');
    }

    public function reject(Employee $employee)
    {
         $employee->update(['status' => 'inactive']);

    \App\Models\Notification::where('employee_id', $employee->id)
        ->where('type', 'employee_creation')
        ->where('status', 'pending')
        ->update(['status' => 'rejected', 'read_at' => now()]);

    return back()->with('success', $employee->name . ' rejected.');
    }
}
