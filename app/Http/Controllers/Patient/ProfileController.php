<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);

        $data = $request->validate([
            'name'                   => ['required', 'string', 'max:255'],
            'phone'                  => ['nullable', 'string', 'max:20'],
            'dob'                    => ['nullable', 'date', 'before:today'],
            'gender'                 => ['nullable', 'in:male,female,other'],
            'blood_group'            => ['nullable', 'string', 'max:10'],
            'address'                => ['nullable', 'string', 'max:500'],
            'emergency_contact'      => ['nullable', 'string', 'max:20'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'allergies'              => ['nullable', 'string', 'max:1000'],
            'chronic_diseases'       => ['nullable', 'string', 'max:1000'],
            'avatar'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $patient = $user->patient;
        if (! $patient) {
            $patient = $user->patient()->create([
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        DB::transaction(function () use ($request, $data, $patient, $user) {
            $oldAvatar = $patient->avatar;

            // Handle avatar upload (store relative path only)
            if ($request->hasFile('avatar')) {
                $patient->avatar = $request->file('avatar')->store('avatars', 'public'); // storage/app/public/avatars/...
            }

            $patient->name                   = $data['name'];
            $patient->phone                  = $data['phone'] ?? $patient->phone;
            $patient->dob                    = $data['dob'] ?? $patient->dob;
            $patient->gender                 = $data['gender'] ?? $patient->gender;
            $patient->blood_group            = $data['blood_group'] ?? $patient->blood_group;
            $patient->address                = $data['address'] ?? null;
            $patient->emergency_contact      = $data['emergency_contact'] ?? null;
            $patient->emergency_contact_name = $data['emergency_contact_name'] ?? null;
            $patient->allergies              = $data['allergies'] ?? null;
            $patient->chronic_diseases       = $data['chronic_diseases'] ?? null;
            $patient->save();

            $user->name = $data['name'];
            $user->save();

            // Delete old avatar only after successful save, and only if it changed
            if ($request->hasFile('avatar') && $oldAvatar && $oldAvatar !== $patient->avatar) {
                Storage::disk('public')->delete($oldAvatar);
            }
        });

        return redirect()->route('patient.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
