<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AuditLog;
use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Notification;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    private function sidebarItems(): array
    {
        return [
            ['label' => 'Overview', 'href' => route('doctor.dashboard'), 'route' => 'doctor.dashboard', 'icon' => 'M3 13h18M3 6h18M3 20h18'],
            ['label' => 'Appointments', 'href' => route('doctor.appointments'), 'route' => 'doctor.appointments', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Patients', 'href' => route('doctor.patients'), 'route' => 'doctor.patients', 'icon' => 'M12 12a5 5 0 100-10 5 5 0 000 10zm6 8v-2a6 6 0 00-12 0v2'],
            ['label' => 'Consultations', 'href' => route('doctor.consultations'), 'route' => 'doctor.consultations', 'icon' => 'M7.5 8.25h9m-9 4.5h9m-9 4.5H12M9.75 3h4.5c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 018.625 6.375v-2.25C8.625 3.504 9.129 3 9.75 3z'],
            ['label' => 'Prescriptions', 'href' => route('doctor.prescriptions'), 'route' => 'doctor.prescriptions', 'icon' => 'M12 20.25c4.97 0 9-4.03 9-9s-4.03-9-9-9-9 4.03-9 9 4.03 9 9 9z'],
            ['label' => 'Labs & EMR', 'href' => route('doctor.labs'), 'route' => 'doctor.labs', 'icon' => 'M6 3v18m12-18v18M6 6h12M6 18h12'],
            ['label' => 'Schedule', 'href' => route('doctor.schedule'), 'route' => 'doctor.schedule', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
            ['label' => 'Notifications', 'href' => route('doctor.notifications'), 'route' => 'doctor.notifications', 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31'],
            ['label' => 'Reports', 'href' => route('doctor.reports'), 'route' => 'doctor.reports', 'icon' => 'M3 3v18h18M7 14l3-3 4 4 5-7'],
            ['label' => 'Profile', 'href' => route('doctor.profile'), 'route' => 'doctor.profile', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0'],
        ];
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'doctor', 403);

        $routeName = $request->route()?->getName() ?? 'doctor.dashboard';
        $activeSection = match ($routeName) {
            'doctor.appointments' => 'appointments',
            'doctor.patients' => 'patients',
            'doctor.consultations' => 'consultations',
            'doctor.prescriptions' => 'prescriptions',
            'doctor.labs' => 'labs',
            'doctor.schedule' => 'schedule',
            'doctor.notifications' => 'notifications',
            'doctor.reports' => 'reports',
            'doctor.profile' => 'profile',
            default => 'overview',
        };

        $doctor = $user->doctor;
        $today = now()->toDateString();
        $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        if (! $doctor) {
            return view('doctor.dashboard', [
                'doctor' => null,
                'activeSection' => $activeSection,
                'stats' => [
                    'today_appointments' => 0,
                    'upcoming_appointments' => 0,
                    'patients_handled' => 0,
                    'pending_consultations' => 0,
                    'completed_consultations' => 0,
                    'lab_requests' => 0,
                    'unread_notifications' => 0,
                    'completion_rate' => 0,
                ],
                'todayAppointments' => collect(),
                'upcomingAppointments' => collect(),
                'assignedPatients' => collect(),
                'prescriptions' => collect(),
                'labOrders' => collect(),
                'notifications' => collect(),
                'activityLogs' => collect(),
                'weeklyAvailability' => collect(),
                'recentConsultations' => collect(),
                'patientHistory' => [],
                'statusLabels' => $statusLabels,
                'sidebarItems' => $this->sidebarItems(),
            ]);
        }

        $doctorId = $doctor->id;
        $appointmentQuery = Appointment::with(['patient', 'department'])
            ->where('doctor_id', $doctorId);

        $todayAppointments = (clone $appointmentQuery)
            ->whereDate('appointment_date', $today)
            ->orderBy('time_slot')
            ->limit(8)
            ->get();

        $upcomingAppointments = (clone $appointmentQuery)
            ->where(function ($query) use ($today) {
                $query->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($inner) use ($today) {
                        $inner->whereDate('appointment_date', $today)
                            ->whereIn('status', ['pending', 'confirmed']);
                    });
            })
            ->orderBy('appointment_date')
            ->orderBy('time_slot')
            ->limit(8)
            ->get();

        $recentConsultations = (clone $appointmentQuery)
            ->where('status', 'completed')
            ->orderByDesc('appointment_date')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        $patientsHandledCount = (clone $appointmentQuery)->distinct('patient_id')->count('patient_id');
        $pendingConsultations = (clone $appointmentQuery)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('appointment_date', '<=', $today)
            ->count();
        $completedConsultations = (clone $appointmentQuery)
            ->where('status', 'completed')
            ->count();
        $labRequestCount = LabOrder::where('doctor_id', $doctorId)->count();
        $totalAppointments = (clone $appointmentQuery)->count();
        $completionRate = $totalAppointments > 0
            ? (int) round(($completedConsultations / $totalAppointments) * 100)
            : 0;

        $patientIds = (clone $appointmentQuery)->distinct()->pluck('patient_id');
        $assignedPatients = Patient::query()
            ->withCount(['appointments as visits_count' => function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            }])
            ->whereIn('id', $patientIds)
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get();

        $patientHistorySource = (clone $appointmentQuery)
            ->with(['patient', 'department'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('time_slot')
            ->limit(30)
            ->get();

        $patientHistory = [];

        foreach ($assignedPatients as $patient) {
            $patientHistory[$patient->id] = $patientHistorySource
                ->where('patient_id', $patient->id)
                ->take(3)
                ->map(function (Appointment $appointment) {
                    return [
                        'date' => $appointment->appointment_date?->format('M d, Y'),
                        'time' => $appointment->time_slot,
                        'status' => $appointment->status,
                        'department' => $appointment->department->name ?? 'General',
                        'notes' => $appointment->notes ?: 'No visit notes recorded.',
                    ];
                })
                ->values()
                ->all();
        }

        // Build a merged timeline per patient (appointments, prescriptions, lab orders)
        $patientTimeline = [];

        foreach ($assignedPatients as $patient) {
            $pid = $patient->id;

            $apptItems = Appointment::with('department')
                ->where('doctor_id', $doctorId)
                ->where('patient_id', $pid)
                ->orderByDesc('appointment_date')
                ->orderByDesc('time_slot')
                ->limit(8)
                ->get()
                ->map(function (Appointment $a) {
                    return [
                        'type' => 'appointment',
                        'date' => $a->appointment_date?->format('Y-m-d') ?? null,
                        'display_date' => $a->appointment_date?->format('M d, Y'),
                        'time' => $a->time_slot,
                        'title' => ($a->department->name ?? 'General') . ' visit',
                        'notes' => $a->notes ?: null,
                    ];
                })->all();

            $presItems = Prescription::where('doctor_id', $doctorId)
                ->where('patient_id', $pid)
                ->orderByDesc('created_at')
                ->limit(8)
                ->get()
                ->map(function (Prescription $p) {
                    return [
                        'type' => 'prescription',
                        'date' => $p->created_at?->format('Y-m-d') ?? null,
                        'display_date' => $p->created_at?->format('M d, Y'),
                        'time' => $p->created_at?->format('H:i') ?? null,
                        'title' => 'Prescription: ' . ($p->diagnosis ?: '—'),
                        'notes' => $p->notes ?: null,
                    ];
                })->all();

            $labItems = LabOrder::where('doctor_id', $doctorId)
                ->where('patient_id', $pid)
                ->orderByDesc('created_at')
                ->limit(8)
                ->get()
                ->map(function (LabOrder $l) {
                    return [
                        'type' => 'lab',
                        'date' => $l->created_at?->format('Y-m-d') ?? null,
                        'display_date' => $l->created_at?->format('M d, Y'),
                        'time' => $l->created_at?->format('H:i') ?? null,
                        'title' => 'Lab: ' . ($l->labTest->name ?? 'Test'),
                        'notes' => $l->result ?? null,
                    ];
                })->all();

            // merge and sort by date/time desc
            $merged = array_merge($apptItems, $presItems, $labItems);
            usort($merged, function ($a, $b) {
                $ad = $a['date'] ?? '';
                $bd = $b['date'] ?? '';
                if ($ad === $bd) {
                    return strcmp($b['time'] ?? '', $a['time'] ?? '');
                }
                return strcmp($bd, $ad);
            });

            $patientTimeline[$pid] = array_slice($merged, 0, 12);
        }

        $prescriptions = Prescription::with(['patient', 'appointment'])
            ->where('doctor_id', $doctorId)
            ->latest()
            ->limit(6)
            ->get();

        $labOrders = LabOrder::with(['patient', 'labTest'])
            ->where('doctor_id', $doctorId)
            ->latest()
            ->limit(6)
            ->get();

        $notifications = Notification::query()
            ->where('user_id', $user->id)
            ->latest()
            ->limit(6)
            ->get();

        $activityLogs = AuditLog::query()
            ->where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $medicines = Medicine::query()
            ->where('status', 'available')
            ->orderBy('name')
            ->get();

        $labTests = LabTest::query()
            ->orderBy('name')
            ->get();

        $availability = $doctor->availability ?? [];
        $weeklyAvailability = collect([
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
        ])->map(function ($dayLabel, $dayKey) use ($availability) {
            $slots = $availability[$dayKey] ?? ['09:00 - 13:00', '14:00 - 17:00'];
            if (! is_array($slots)) {
                $slots = [$slots];
            }

            return [
                'day' => $dayLabel,
                'slots' => $slots,
                'available' => ! empty($slots) && $slots[0] !== 'Blocked',
            ];
        });

        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'activeSection' => $activeSection,
            'stats' => [
                'today_appointments' => $todayAppointments->count(),
                'upcoming_appointments' => $upcomingAppointments->count(),
                'patients_handled' => $patientsHandledCount,
                'pending_consultations' => $pendingConsultations,
                'completed_consultations' => $completedConsultations,
                'lab_requests' => $labRequestCount,
                'unread_notifications' => $notifications->where('is_read', false)->count(),
                'completion_rate' => $completionRate,
            ],
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'recentConsultations' => $recentConsultations,
            'assignedPatients' => $assignedPatients,
            'prescriptions' => $prescriptions,
            'labOrders' => $labOrders,
            'notifications' => $notifications,
            'activityLogs' => $activityLogs,
            'weeklyAvailability' => $weeklyAvailability,
            'sidebarItems' => $this->sidebarItems(),
            'medicines' => $medicines,
            'labTests' => $labTests,
            'patientHistory' => $patientHistory,
            'patientTimeline' => $patientTimeline,
            'statusLabels' => $statusLabels,
        ]);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'doctor', 403);

        $doctor = $user->doctor;
        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        return view('doctor.profile', [
            'doctor' => $doctor->load('department', 'user'),
            'sidebarItems' => $this->sidebarItems(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'doctor', 403);

        $doctor = $user->doctor;
        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
            'joining_date' => 'nullable|date',
            'address' => 'nullable|string',

            // Professional details
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:80',
            'consultation_fee' => 'nullable|numeric|min:0|max:1000000',
            'bio' => 'nullable|string|max:3000',
            'image' => 'nullable|image|max:3072',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }
            $imagePath = $request->file('image')->store('doctor-profiles', 'public');
        }

        $doctor->update([
            'name' => $data['name'],
            'employee_id' => $data['employee_id'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'gender' => $data['gender'] ?? null,
            'dob' => $data['dob'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
            'joining_date' => $data['joining_date'] ?? null,
            'address' => $data['address'] ?? null,
            'specialization' => $data['specialization'] ?? ($doctor->specialization ?? null),
            'experience_years' => $data['experience_years'] ?? ($doctor->experience_years ?? null),
            'consultation_fee' => $data['consultation_fee'] ?? ($doctor->consultation_fee ?? null),
            'bio' => $data['bio'] ?? ($doctor->bio ?? null),
            ...($imagePath ? ['image' => $imagePath] : []),
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return redirect()->route('doctor.profile')->with('success', 'Profile updated successfully.');
    }

    public function markNotificationsRead(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'doctor', 403);

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
