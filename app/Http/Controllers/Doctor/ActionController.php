<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    private function doctor(): Doctor
    {
        $doctor = Auth::user()?->doctor;
        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        return $doctor;
    }

    private function assertAppointmentOwnership(Appointment $appointment, Doctor $doctor): void
    {
        abort_unless($appointment->doctor_id === $doctor->id, 403, 'You are not allowed to access this appointment.');
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $doctor = $this->doctor();
        $this->assertAppointmentOwnership($appointment, $doctor);

        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment)
    {
        $doctor = $this->doctor();
        $this->assertAppointmentOwnership($appointment, $doctor);

        $data = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:50',
        ]);

        $appointment->update([
            'appointment_date' => $data['appointment_date'],
            'time_slot' => $data['time_slot'],
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Appointment rescheduled successfully.');
    }

    public function storeConsultation(Request $request)
    {
        $doctor = $this->doctor();

        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'symptoms' => 'nullable|string',
            'observations' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::with('patient')->findOrFail($data['appointment_id']);
        $this->assertAppointmentOwnership($appointment, $doctor);

        $consultationNotes = collect([
            $data['symptoms'] ? 'Symptoms: '.$data['symptoms'] : null,
            $data['observations'] ? 'Observations: '.$data['observations'] : null,
            $data['diagnosis'] ? 'Diagnosis: '.$data['diagnosis'] : null,
            $data['notes'] ? 'Notes: '.$data['notes'] : null,
        ])->filter()->implode("\n");

        $appointment->update([
            'notes' => trim(($appointment->notes ? $appointment->notes."\n\n" : '') . $consultationNotes),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Consultation saved and appointment marked completed.');
    }

    public function storePrescription(Request $request)
    {
        $doctor = $this->doctor();

        $data = $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'medicine_ids' => 'required|array|min:1',
            'medicine_ids.*' => 'required|exists:medicines,id',
            'dosages' => 'nullable|array',
            'frequencies' => 'nullable|array',
            'durations' => 'nullable|array',
            'instructions' => 'nullable|array',
        ]);

        if (! empty($data['appointment_id'])) {
            $appointment = Appointment::findOrFail($data['appointment_id']);
            $this->assertAppointmentOwnership($appointment, $doctor);
        }

        $patient = Patient::findOrFail($data['patient_id']);
        $prescription = Prescription::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_id' => $data['appointment_id'] ?? null,
            'diagnosis' => $data['diagnosis'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($data['medicine_ids'] as $index => $medicineId) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $medicineId,
                'dosage' => $data['dosages'][$index] ?? null,
                'frequency' => $data['frequencies'][$index] ?? null,
                'duration' => $data['durations'][$index] ?? null,
                'instructions' => $data['instructions'][$index] ?? null,
            ]);
        }

        return back()->with('success', 'Prescription created successfully.');
    }

    public function storeLabOrder(Request $request)
    {
        $doctor = $this->doctor();

        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'lab_test_id' => 'required|exists:lab_tests,id',
            'result' => 'nullable|string',
        ]);

        $labOrder = LabOrder::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $doctor->id,
            'lab_test_id' => $data['lab_test_id'],
            'status' => 'requested',
            'result' => $data['result'] ?? null,
            'ordered_at' => now(),
        ]);

        return back()->with('success', 'Lab test requested successfully.');
    }

    public function printPrescription(Prescription $prescription)
    {
        $doctor = $this->doctor();

        // Verify ownership
        abort_unless($prescription->doctor_id === $doctor->id, 403, 'You are not allowed to access this prescription.');

$prescription->load(['patient', 'doctor', 'items.medicine', 'appointment']);

        return view('doctor.prescriptions.print', [
            'prescription' => $prescription,
            'hospital' => [
                'name' => 'HMS',
                'address' => '123 Medical Avenue, Healthcare District, New Delhi 110001',
                'phone' => '+91 1800-123-4567',
                'email' => 'info@hms-hospital.com',
            ]
        ]);
    }
    public function formData()
    {
        $doctor = $this->doctor();

        return [
            'medicines' => Medicine::query()->where('status', 'available')->orderBy('name')->get(),
            'labTests' => LabTest::query()->orderBy('name')->get(),
        ];
    }
}
