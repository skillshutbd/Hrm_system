<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }
  

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create($request->only('name', 'description'));

        return redirect()->route('admin.department.index')->with('success', 'Department created successfully.');
    }

    public function edit(int $id)
    {
        $department = Department::findOrFail($id);
        return view('admin.department.edit', compact('department'));
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->only('name', 'description'));

        return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(int $id)
{
    Department::findOrFail($id)->delete();
    return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully.');
}

    

}