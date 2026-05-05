<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Bed;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['patient', 'doctor', 'bed.room']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('type'))   $query->where('type', $request->type);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('patient', fn($q) => $q->where('name', 'like', "%{$s}%"));
        }
        $admissions = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.admissions.index', compact('admissions'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::where('status', 'active')->orderBy('name')->get();
        $beds = Bed::with('room')->where('status', 'available')->get();
        return view('admin.admissions.create', compact('patients', 'doctors', 'beds'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'bed_id' => 'nullable|exists:beds,id',
            'admission_date' => 'required|date',
            'type' => 'required|in:OPD,IPD',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $data['status'] = 'admitted';
        $admission = Admission::create($data);
        if ($admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'occupied']);
        }
        return redirect()->route('admin.admissions.index')->with('success', 'Admission recorded successfully.');
    }

    public function show(Admission $admission)
    {
        $admission->load(['patient', 'doctor', 'bed.room']);
        return view('admin.admissions.show', compact('admission'));
    }

    public function edit(Admission $admission)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::where('status', 'active')->orderBy('name')->get();
        $beds = Bed::with('room')->get();
        return view('admin.admissions.edit', compact('admission', 'patients', 'doctors', 'beds'));
    }

    public function update(Request $request, Admission $admission)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'bed_id' => 'nullable|exists:beds,id',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'type' => 'required|in:OPD,IPD',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:admitted,discharged,transferred',
        ]);
        // Free old bed if changed
        if ($admission->bed_id && $admission->bed_id != ($data['bed_id'] ?? null)) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'available']);
        }
        // Occupy new bed
        if (!empty($data['bed_id']) && $admission->bed_id != $data['bed_id']) {
            Bed::where('id', $data['bed_id'])->update(['status' => 'occupied']);
        }
        // On discharge, free bed
        if ($data['status'] === 'discharged' && $admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'available']);
        }
        $admission->update($data);
        return redirect()->route('admin.admissions.index')->with('success', 'Admission updated.');
    }

    public function destroy(Admission $admission)
    {
        if ($admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'available']);
        }
        $admission->delete();
        return redirect()->route('admin.admissions.index')->with('success', 'Admission deleted.');
    }
}
