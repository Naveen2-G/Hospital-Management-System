<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);

        $patient = $user->patient;

        if (! $patient) {
            // In case the patient profile was not created for an older user record.
            $patient = $user->patient()->create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        $appointments = Appointment::query()
            ->with(['doctor', 'department'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->limit(25)
            ->get();

        $prescriptions = Prescription::query()
            ->with(['doctor', 'appointment', 'items.medicine'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        $labOrders = LabOrder::query()
            ->with(['doctor', 'labTest'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('ordered_at')
            ->limit(15)
            ->get();

        $invoices = Invoice::query()
            ->with(['items', 'payments'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        $departments = Department::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $doctors = Doctor::query()
            ->with('department')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('patient.dashboard', compact(
            'user',
            'patient',
            'appointments',
            'prescriptions',
            'labOrders',
            'invoices',
            'departments',
            'doctors',
        ));
    }
}

