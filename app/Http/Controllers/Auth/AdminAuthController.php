<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = User::where('email', $request->email)->where('role', 'admin')->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        // Log the admin in
        Auth::login($admin);

        return redirect()->route('admin.dashboard');
    }
}