<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('patient.change-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|same:confirm_password',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'current_password.required' => 'Current password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.regex' => 'New password must contain uppercase, lowercase, and number',
            'new_password.same' => 'Passwords do not match',
            'confirm_password.required' => 'Please confirm your new password',
            'confirm_password.same' => 'Passwords do not match',
        ]);

        $user = Auth::user();

        abort_unless($user && $user->role === 'patient', 403);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect',
            ])->withInput();
        }

        if (Hash::check($validated['new_password'], $user->password)) {
            return back()->withErrors([
                'new_password' => 'New password cannot be the same as current password',
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Password updated successfully!');
    }
}