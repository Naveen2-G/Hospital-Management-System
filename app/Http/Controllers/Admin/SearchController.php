<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        
        $patients = collect();
        $doctors = collect();
        $appointments = collect();

        if ($q) {
            $patients = Patient::where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('phone', 'like', "%{$q}%")
                ->take(10)->get();

            $doctors = Doctor::where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('specialization', 'like', "%{$q}%")
                ->take(10)->get();

            $appointments = Appointment::with(['patient', 'doctor'])
                ->whereHas('patient', function($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                })
                ->orWhereHas('doctor', function($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                })
                ->take(10)->get();
        }

        return view('admin.search', compact('q', 'patients', 'doctors', 'appointments'));
    }
}
