<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Notifications\PatientWelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'You must accept the Terms of Service.',
        ]);

        $fullName = trim($data['first_name'] . ' ' . $data['last_name']);

        $user = User::create([
            'name' => $fullName,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
            'status' => 'active',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);

        // Send credentials to patient email (as requested).
        $user->notify(new PatientWelcomeNotification($data['password']));

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully.',
                'redirect' => route('patient.dashboard'),
            ]);
        }

        return redirect()->route('patient.dashboard')->with('success', 'Account created successfully. We sent your credentials to your email.');
    }
}

