<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\HrAdmin;
use App\Models\Tl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function getAuthUser()
    {
        if (auth('Hr')->check()) return auth('Hr')->user();
        if (auth('tl')->check()) return auth('tl')->user();
        if(auth('employee')->check()) return auth('employee')->user();
        return Auth::user();
    }

    private function getView(string $view): string
    {
        if (auth('Hr')->check()) return 'hr.' . $view;
        if (auth('tl')->check()) return 'team_lead.' . $view;
        if (auth('employee')->check()) return 'employee.' . $view;
        return 'admin.' . $view;
    }

    private function getRoute(string $route): string
    {
        if (auth('Hr')->check()) return 'hr_admin.' . $route;
        if (auth('tl')->check()) return 'tl.' . $route;
        if (auth('employee')->check()) return 'employee.' . $route;
        return 'admin.' . $route;
    }

    private function getTable(): string
    {
        if (auth('Hr')->check()) return 'hr_admins';
        if (auth('tl')->check()) return 'team_leads';
        if (auth('employee')->check()) return 'employee';
        return 'users';
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
        $table = $this->getTable();

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
        } elseif (auth('tl')->check()) {
            Tl::where('id', $admin->id)->update($validated);
        } elseif (auth('employee')->check()) {
            Employee::where('id', $admin->id)->update($validated);
        }else{
            User::where('id', $admin->id)->update($validated);
        }

        return redirect()->route($this->getRoute('profile'))->with('success', 'Profile updated successfully.');
    }
}