<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Notification;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    private function portalData(): array
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

        $notifications = Notification::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(10)
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

        return compact(
            'user',
            'patient',
            'appointments',
            'prescriptions',
            'labOrders',
            'notifications',
            'invoices',
            'departments',
            'doctors',
        );
    }

    public function dashboard(Request $request)
    {
        return view('patient.dashboard', $this->portalData());
    }

    public function appointments(Request $request)
    {
        return view('patient.appointments', $this->portalData());
    }

    public function reports(Request $request)
    {
        return view('patient.reports', $this->portalData());
    }

    public function prescriptions(Request $request)
    {
        return view('patient.prescriptions', $this->portalData());
    }

    public function invoices(Request $request)
    {
        return view('patient.invoices', $this->portalData());
    }

    public function profile(Request $request)
    {
        return view('patient.profile', $this->portalData());
    }

    public function markNotificationsRead(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'patient', 403);

        Notification::query()
            ->where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifications marked as read.');
    }
}

