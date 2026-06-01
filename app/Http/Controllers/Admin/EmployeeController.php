<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->latest()->paginate(8);
    $departments = Department::orderBy('name')->get();

    return view('admin.employee.index', compact('employees', 'departments'));
    }

    public function create()
    {
        // Show form to create a new employee
        return view('admin.employee.create');
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email',
        'phone' => 'nullable|string|max:255',
        'employee_id' => 'nullable|string|max:255|unique:employees,employee_id',
        'nid' => 'required|string|max:255|unique:employees,nid',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'address' => 'nullable|string|max:255',
        'emergency_contact_name' => 'nullable|string|max:255',
        'emergency_contact_phone' => 'nullable|string|max:255',
        'emergency_contact_relationship' => 'nullable|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'designation' => 'required|string|max:255',
        'role' => 'nullable|string|max:255',
        'hire_date' => 'nullable|date',
        'password' => 'nullable|string|min:8',
        'status' => 'required|in:active,inactive',
    ]);

   if ($request->hasFile('profile_picture')) {
    $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
}

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    }

    Employee::create($validated);

    return redirect()->route('admin.employee.index')->with('success', 'Employee created successfully.');
}
    public function show(Employee $employee)
{
    $employee->load('department');

    return view('admin.employee.show', compact('employee'));
}

    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.employee.edit', compact('employee', 'departments'));

    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:255',
            'employee_id' => 'nullable|string|max:255|unique:employees,employee_id,' . $employee->id,
            'nid' => 'required|string|max:255|unique:employees,nid,' . $employee->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('admin.employee.index')->with('success', 'Employee updated successfully.');
    }

    public function exportCsv()
{
    $fileName = 'employees.csv';

    $employees = \App\Models\Employee::with('department')->latest()->get();

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    ];

    $callback = function () use ($employees) {
        $file = fopen('php://output', 'w');

        // Excel-friendly UTF-8 BOM
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($file, [
            'Employee ID',
            'NID',
            'Name',
            'Email',
            'Phone',
            'Department',
            'Designation',
            'Role',
            'Hire Date',
            'Status',
            'Address',
            'Emergency Contact Name',
            'Emergency Contact Phone',
            'Emergency Contact Relationship',
            'Created At',
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

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }


    public function toggleTeamLead(Employee $employee)
{
    $employee->update([
        'role' => $employee->role === 'team_lead' ? 'employee' : 'team_lead',
    ]);

    return back()->with('success', 'Employee role updated successfully.');
}
}