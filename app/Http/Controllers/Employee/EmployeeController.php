<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;

use  App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Employee;


class EmployeeController extends Controller{


public function dashboard(){

return view ('employee.dashboard');

}



}