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

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }
}