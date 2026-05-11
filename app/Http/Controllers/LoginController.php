<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle unified login from the main site modal.
     * Returns JSON for AJAX requests.
     * Admin users → redirect to /admin/dashboard
     * Regular users → redirect to /
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            /** @var User $user */
            $user = Auth::user();

            // Log audit for admin users
            if ($user->isAdmin()) {
                \App\Models\AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'login',
                    'ip_address' => $request->ip(),
                ]);
            }

            // Determine redirect based on role
            if ($user->isAdmin()) {
                $redirect = route('admin.dashboard');
            } elseif ($user->role === 'doctor') {
                $redirect = route('doctor.dashboard');
            } elseif ($user->role === 'patient') {
                $redirect = route('patient.dashboard');
            } else {
                $redirect = url('/');
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => $redirect,
                    'csrf_token' => csrf_token(),
                    'user' => [
                        'name' => $user->name,
                        'role' => $user->role,
                    ],
                ]);
            }

            return redirect()->intended($redirect);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.',
            ], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    /**
     * Unified logout — works for both admin and regular users.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                \App\Models\AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'logout',
                    'ip_address' => $request->ip(),
                ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'redirect' => url('/')]);
        }

        return redirect('/');
    }
}
