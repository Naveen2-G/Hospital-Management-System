<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Update the authenticated doctor's password.
     */
    public function update(Request $request)
    {
        $validated = $request->validateWithBag('changePassword', [
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

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect',
            ], 'changePassword');
        }

        if (Hash::check($validated['new_password'], $user->password)) {
            return back()->withErrors([
                'new_password' => 'New password cannot be the same as current password',
            ], 'changePassword');
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Password updated successfully!');
    }
}
