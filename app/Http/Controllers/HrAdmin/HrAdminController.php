<?php

namespace App\Http\Controllers\HrAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HrAdminController extends Controller
{
    public function dashboard()
    {
        return view('hr.hr_admin');
    }
}