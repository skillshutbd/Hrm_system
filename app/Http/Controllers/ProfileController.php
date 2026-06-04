<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HrAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    private function getAuthUser()
    {
        return auth('Hr')->check()
            ? auth('Hr')->user()
            : Auth::user();
    }

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
            return 'hr.' . $route;
        }
        return 'admin.' . $route;
    }

    public function profile()
    {
        $admin = $this->getAuthUser();
        return view($this->getView('profile.profile'), compact('admin'));
    }

    public function edit()
    {
        $admin = $this->getAuthUser();
        return view($this->getView('profile.edit'), compact('admin'));
    }

    public function update(Request $request)
{
    $admin = $this->getAuthUser();

    // HR হলে hr_admins table, Admin হলে users table
    $table = auth('Hr')->check() ? 'hr_admins' : 'users';

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:' . $table . ',email,' . $admin->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

 if (auth('Hr')->check()) {
    HrAdmin::where('id', $admin->id)->update($validated);
} else {
    User::where('id', $admin->id)->update($validated);
}

    
     return redirect()->route('hr_admin.profile')->with('success', 'Profile updated successfully.')
        ->with('success', 'Profile updated successfully.');
}
}