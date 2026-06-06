<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegistrationRequest;
use App\Models\User;
use App\Models\Employee;
use App\Models\HrAdmin;
use App\Models\Tl;
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
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Super Admin
    if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
        if (Auth::guard('web')->user()->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        Auth::guard('web')->logout();
    }

    // HR Admin
    
    if (Auth::guard('Hr')->attempt($request->only('email', 'password'))) {
        if (Auth::guard('Hr')->user()->role === 'hr_admin') {
            $request->session()->regenerate();
            return redirect()->route('hr_admin.dashboard');
        }
        Auth::guard('Hr')->logout();
    }

    //Team lead
    if (Auth::guard('tl')->attempt($request->only('email', 'password'))) {
        if (Auth::guard('tl')->user()->role === 'team_lead') {
            $request->session()->regenerate();
            return redirect()->route('team_lead.dashboard');
        }
        Auth::guard('tl')->logout();
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ])->withInput();
}

        

    public function profile()
    {
        return view('admin.profile.profile');
    }
    public function edit()
    {
        $admin = Auth::user();

        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
           
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

   public function logout(Request $request)
{

if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    } elseif (Auth::guard('Hr')->check()) {
        Auth::guard('Hr')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
}
}