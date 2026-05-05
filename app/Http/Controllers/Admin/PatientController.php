<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }
        $patients = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function create() { return view('admin.patients.create'); }

    public function store(Request $request)
    {
        $messages = [
            'phone.required' => 'Phone number is mandatory to enter.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
        ], $messages);
        Patient::create($data);
        return redirect()->route('admin.patients.index')->with('success', 'Patient added successfully.');
    }

    public function show(Patient $patient) { return view('admin.patients.show', compact('patient')); }

    public function edit(Patient $patient) { return view('admin.patients.edit', compact('patient')); }

    public function update(Request $request, Patient $patient)
    {
        $messages = [
            'phone.required' => 'Phone number is mandatory to enter.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
        ], $messages);
        $patient->update($data);
        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted.');
    }
}
