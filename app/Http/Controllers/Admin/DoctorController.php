<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user', 'department')->orderByDesc('id')->paginate(20);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')->where('status', 'active')],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'specialization' => 'nullable|string|max:255',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must contain only digits and be 10 to 15 digits long.',
        ]);

        // Create the user with doctor role
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'doctor',
            'phone' => $data['phone'],
            'status' => 'active',
        ]);

        // Create doctor profile linked to user
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'department_id' => $data['department_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'specialization' => $data['specialization'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor account created successfully.');
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('status', 'active')->get();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')->where('status', 'active')],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'consultation_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must contain only digits and be 10 to 15 digits long.',
        ]);

        $doctor->update($data);
        if ($doctor->user) {
            $doctor->user->update(['name' => $data['name'], 'phone' => $data['phone']]);
        }

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated.');
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->user) {
            $doctor->user->delete();
        }
        $doctor->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor removed.');
    }
}

