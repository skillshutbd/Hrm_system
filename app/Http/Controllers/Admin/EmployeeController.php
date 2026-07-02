<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        'blood_group' => [
    'required',
    'string',
    Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])
],
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
    if (isset($validated['role']) && $validated['role'] === 'team_lead') {
        $teamLead = \App\Models\Tl::create([
              'employee_id' => $employee->id,
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'team_lead',
        ]);

        $teamLead->assignRole('team_lead');
    }
   if (isset($validated['role']) && $validated['role'] === 'employee') {
   $employee= \App\Models\EmployeeUser::create([
        'employee_id'   => $employee->id,
        'name'          => $validated['name'],
        'email'         => $validated['email'],
        'password'      => $validated['password'],
        'role'          => 'employee',
        'department_id' => $validated['department_id'],
    ]);

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
            'nid'                            => 'required|string|max:16|unique:employees,nid,' . $employee->id,
             'blood_group'                    => [
            'required',
            'string',
            Rule::in(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
        ],
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
        DB::table('notifications')->where('employee_id', $employee->id)->delete();
    
    $employee->delete();
    
    return redirect()->route($this->getRoute('employee.index'))
        ->with('success', 'Employee deleted successfully.');
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

public function toggleTeamLead(Request $request, $employeeId)
{
    $employee = Employee::findOrFail($employeeId);
 
    $deptIds   = $request->input('department_ids', []);
    $isRemove  = $request->boolean('is_remove');
 
    // ── Case 1: Explicit "Remove TL" ──────────────────────────────
    if ($isRemove || empty($deptIds)) {
        Department::where('hod_id', $employee->id)->update(['hod_id' => null]);
 
        $employee->role = 'member';
        $employee->save();
 
        return back()->with('success', "{$employee->name} has been removed as Team Lead.");
    }
 
    // ── Case 2: Assign / Modify ────────────────────────────────────
    // Validate none of the selected departments belong to someone else
    $conflicts = Department::whereIn('id', $deptIds)
        ->whereNotNull('hod_id')
        ->where('hod_id', '!=', $employee->id)
        ->with('hod:id,name')
        ->get();
 
    if ($conflicts->isNotEmpty()) {
        $names = $conflicts->map(function ($d) {
            return "{$d->name} (already led by {$d->hod->name})";
        })->implode(', ');
 
        return back()->with('error', "Cannot assign: {$names}.");
    }
 
    // Clear departments this employee previously led but is no longer selecting
    Department::where('hod_id', $employee->id)
        ->whereNotIn('id', $deptIds)
        ->update(['hod_id' => null]);
 
    // Assign the selected departments to this employee
    Department::whereIn('id', $deptIds)->update(['hod_id' => $employee->id]);
 
    $employee->role = 'team_lead';
    $employee->save();
 
    return back()->with('success', "{$employee->name} has been assigned as Team Lead.");
}

public function approveTlRequest(int $id)
{
    $notification  = \App\Models\Notification::findOrFail($id);
    $employee      = Employee::findOrFail($notification->employee_id);
    $departmentIds = json_decode($notification->department_ids ?? '[]', true);

    $employee->update(['role' => 'team_lead']);
    $this->syncTeamLeadRecord($employee, true); // ← যোগ করা হলো

    \App\Models\Department::where('hod_id', $employee->id)->update(['hod_id' => null]);
    if (!empty($departmentIds)) {
        \App\Models\Department::whereIn('id', $departmentIds)->update(['hod_id' => $employee->id]);
    }

    $notification->update(['status' => 'approved', 'read_at' => now()]);

    return back()->with('success', 'TL request approved.');
}
public function cancelTlRequest(int $id)
{
    \App\Models\Notification::where('id', $id)
        ->where('status', 'pending')
        ->delete();

    return back()->with('success', 'TL request cancelled.');
}

// public function approveTlRequest(int $id)
// {
//     $notification = \App\Models\Notification::findOrFail($id);
//     $employee = Employee::findOrFail($notification->employee_id);
//     $departmentIds = json_decode($notification->department_ids ?? '[]', true);

//     $employee->update(['role' => 'team_lead']);
//     $this->syncTeamLeadRecord($employee, true);

//     \App\Models\Department::where('hod_id', $employee->id)->update(['hod_id' => null]);
//     if (!empty($departmentIds)) {
//         \App\Models\Department::whereIn('id', $departmentIds)->update(['hod_id' => $employee->id]);
//     }

//     $notification->update(['status' => 'approved', 'read_at' => now()]);

//     return back()->with('success', 'TL request approved.');
// }

public function rejectTlRequest(int $id)
{
    $notification = \App\Models\Notification::findOrFail($id);
    $notification->update(['status' => 'rejected', 'read_at' => now()]);

    return back()->with('success', 'TL request rejected.');
}

private function syncTeamLeadRecord(Employee $employee, bool $makeTeamLead)
{
    if ($makeTeamLead) {
        \App\Models\Tl::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'name'     => $employee->name,
                'email'    => $employee->email,
                'password' => $employee->password ?? Hash::make('changeme123'),
                'role'     => 'team_lead',
            ]
        );
    } else {
        \App\Models\Tl::where('employee_id', $employee->id)->delete();
    }
}
    public function EmployeeCreationIndex(int $id)
        {
            $employee = Employee::findOrFail($id);
            return view($this->getView('employee.employee_request'), compact('employee'));
        }

    public function EmployeeCreationView(Employee $employee)
    {
        $employee = Employee::findOrFail($employee->id);
        return view($this->getView('employee.employee_request_view'), compact('employee'));
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
