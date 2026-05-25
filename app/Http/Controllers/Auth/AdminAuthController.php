<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function registrationForm()
    {
        // if (User::where('role', 'admin')->exists()) {
        //     abort(403, 'Super Admin already exists.');
        // }

        return view('admin.auth.registration');
    }

    public function registration(AdminRegistrationRequest $request)
    {
        // if (User::where('role', 'admin')->exists()) {
        //     abort(403, 'Super Admin already exists.');
        // }

        User::create([
            'name'         => $request->name,
            'position'     => $request->position,
            'company_name' => $request->company_name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'admin',
        ]);

        return redirect()->route('admin.login');
    }
public function store(){


}
    public function loginForm()
    {
        return view('admin.auth.login');
    }
}