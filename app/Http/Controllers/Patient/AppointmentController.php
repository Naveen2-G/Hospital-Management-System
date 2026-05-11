<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'in:male,female,other'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'department' => ['nullable', 'string'],
            'doctor' => ['required', 'numeric'],
            'appointment_type' => ['nullable', 'in:regular,emergency,video'],
            'appointment_date' => ['required', 'date'],
            'time_slot' => ['required', 'string'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $patient = $user->patient;
        if (! $patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        // Fetch doctor from database
        $doctor = Doctor::query()
            ->with('department')
            ->where('status', 'active')
            ->where('id', (int) $data['doctor'])
            ->first();

        if (! $doctor) {
            return back()->withInput()->with('error', 'Selected doctor is not available right now.');
        }

        $department = null;
        if (! empty($data['department_id'])) {
            $department = Department::query()->where('id', (int) $data['department_id'])->first();
        }

        // Backwards compatible: slug-to-name conversion from older front-end pages.
        if (! $department && ! empty($data['department'])) {
            $departmentMap = [
                'cardiology' => 'Cardiology',
                'dermatology' => 'Dermatology',
                'neurology' => 'Neurology',
                'pediatrics' => 'Pediatrics',
                'orthopedics' => 'Orthopedics',
                'general' => 'General Medicine',
                'ent' => 'ENT',
                'gynecology' => 'Gynecology',
                'emergency' => 'Emergency',
            ];

            $departmentName = $departmentMap[$data['department']] ?? $data['department'];
            $department = Department::query()->whereRaw('LOWER(name) = ?', [strtolower($departmentName)])->first();
        }

        if (! $department && $doctor->department_id) {
            $department = $doctor->department;
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department?->id,
            'appointment_date' => $data['appointment_date'],
            'time_slot' => $data['time_slot'],
            'status' => 'pending',
            'type' => $data['appointment_type'] ?? 'regular',
            'notes' => trim((string) $data['notes']) ?: null,
        ]);

        // Notify doctor + admins (persistent DB notifications)
        if ($doctor->user_id) {
            Notification::create([
                'user_id' => $doctor->user_id,
                'title' => 'New appointment booked',
                'message' => ($patient->name ?? 'A patient') . ' booked an appointment for ' .
                    ($appointment->appointment_date?->format('d M Y') ?? '') . ' · ' . ($appointment->time_slot ?? ''),
                'type' => 'appointment',
                'is_read' => false,
            ]);
        }

        $adminIds = User::query()->where('role', 'admin')->pluck('id');
        foreach ($adminIds as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'title' => 'New appointment booked',
                'message' => ($patient->name ?? 'A patient') . ' booked with Dr. ' . ($doctor->name ?? 'doctor') .
                    ' on ' . ($appointment->appointment_date?->format('d M Y') ?? '') . ' · ' . ($appointment->time_slot ?? ''),
                'type' => 'appointment',
                'is_read' => false,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully.',
                'appointment' => [
                    'id' => $appointment->id,
                    'doctor' => $doctor->name,
                    'department' => $department?->name,
                    'date' => $appointment->appointment_date?->format('Y-m-d'),
                    'status' => $appointment->status,
                ],
            ]);
        }

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);

        $patient = $user->patient;
        abort_unless($patient && $appointment->patient_id === $patient->id, 403);

        if (in_array($appointment->status, ['completed', 'cancelled'], true)) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => 'cancelled']);

        $doctor = $appointment->doctor;
        if ($doctor && $doctor->user_id) {
            Notification::create([
                'user_id' => $doctor->user_id,
                'title' => 'Appointment cancelled',
                'message' => ($patient->name ?? 'A patient') . ' cancelled the appointment scheduled on ' .
                    ($appointment->appointment_date?->format('d M Y') ?? '') . ' · ' . ($appointment->time_slot ?? ''),
                'type' => 'appointment',
                'is_read' => false,
            ]);
        }

        $adminIds = User::query()->where('role', 'admin')->pluck('id');
        foreach ($adminIds as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'title' => 'Appointment cancelled',
                'message' => ($patient->name ?? 'A patient') . ' cancelled an appointment with Dr. ' .
                    ($doctor?->name ?? 'doctor') . ' on ' . ($appointment->appointment_date?->format('d M Y') ?? '') .
                    ' · ' . ($appointment->time_slot ?? ''),
                'type' => 'appointment',
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}