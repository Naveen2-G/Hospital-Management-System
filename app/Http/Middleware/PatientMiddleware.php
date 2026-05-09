<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PatientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! Auth::check() || ! $user || $user->role !== 'patient') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return redirect('/?login=1')->with('error', 'Please sign in with patient credentials to access the patient portal.');
        }

        return $next($request);
    }
}

