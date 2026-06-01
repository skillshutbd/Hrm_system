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

        if (Auth::guard('employee')->attempt($request->only('email', 'password'))) {
            return redirect()->route('employee.dashboard');
        }
        elseif (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }
            $admin = User::where('email', $request->email)->first();



        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        // Log the admin in
        Auth::login($admin);

        

        return redirect()->route('admin.dashboard');
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
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
}
}