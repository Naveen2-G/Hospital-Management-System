<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index(Request $request)
    {
        $query = LabTest::withCount('orders');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', "%{$s}%");
        }
        $labTests = $query->orderBy('name')->paginate(15);
        $recentOrders = LabOrder::with(['patient', 'doctor', 'labTest'])->orderByDesc('created_at')->limit(10)->get();
        return view('admin.lab.index', compact('labTests', 'recentOrders'));
    }

    public function create() { return view('admin.lab.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        LabTest::create($data);
        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test added.');
    }

    public function show(LabTest $labTest)
    {
        $orders = LabOrder::with(['patient', 'doctor'])->where('lab_test_id', $labTest->id)->orderByDesc('created_at')->paginate(10);
        return view('admin.lab.show', compact('labTest', 'orders'));
    }

    public function edit(LabTest $labTest) { return view('admin.lab.edit', compact('labTest')); }

    public function update(Request $request, LabTest $labTest)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        $labTest->update($data);
        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test updated.');
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->delete();
        return redirect()->route('admin.lab-tests.index')->with('success', 'Lab test deleted.');
    }

    public function updateOrder(Request $request, LabOrder $labOrder)
    {
        $data = $request->validate([
            'status' => 'required|in:requested,in_progress,completed',
            'result' => 'nullable|string',
            'report_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $payload = [
            'status' => $data['status'],
            'result' => $data['result'] ?? null,
            'technician_id' => Auth::id(),
            'completed_at' => $data['status'] === 'completed' ? now() : null,
        ];

        if ($request->hasFile('report_file')) {
            if ($labOrder->report_file && Storage::disk('public')->exists($labOrder->report_file)) {
                Storage::disk('public')->delete($labOrder->report_file);
            }

            $payload['report_file'] = $request->file('report_file')->store('lab-reports', 'public');
        }

        $labOrder->update($payload);

        // Notify patient when report is completed / uploaded
        if (($payload['status'] ?? null) === 'completed') {
            $patientUserId = $labOrder->patient?->user_id;
            if ($patientUserId) {
                Notification::create([
                    'user_id' => $patientUserId,
                    'title' => 'Lab report updated',
                    'message' => 'Your lab report for ' . ($labOrder->labTest?->name ?? 'lab test') . ' is now available.',
                    'type' => 'system',
                    'is_read' => false,
                ]);
            }
        }

        return back()->with('success', 'Lab order updated successfully.');
    }
}
