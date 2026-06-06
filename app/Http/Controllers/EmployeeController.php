<?php 


namespace App\Http\Controllers;

namespace App\Models\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EmployeeController extends Controller{

public function dashboard() {
        return view('employee.dashboard');
    }
}