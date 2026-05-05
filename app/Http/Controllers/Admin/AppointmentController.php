<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date'))   $query->whereDate('appointment_date', $request->date);
        $appointments = $query->orderByDesc('appointment_date')->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'type' => 'nullable|in:regular,emergency,video',
            'notes' => 'nullable|string',
        ]);
        Appointment::create($data);
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment created.');
    }

    public function show(Appointment $appointment) { return view('admin.appointments.show', compact('appointment')); }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'type' => 'nullable|in:regular,emergency,video',
            'notes' => 'nullable|string',
        ]);
        $appointment->update($data);
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted.');
    }
}
