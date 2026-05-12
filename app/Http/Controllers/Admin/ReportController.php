<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HealthPackageBooking;
use App\Models\LabBooking;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Admission;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function labBookingReport(LabBooking $booking)
    {
        if (! $booking->report_file) {
            abort(404, 'Report file not found.');
        }

        if (! Storage::disk('public')->exists($booking->report_file)) {
            abort(404, 'Report file not found.');
        }

        $filePath = Storage::disk('public')->path($booking->report_file);
        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($booking->report_file) . '"',
        ]);
    }

    public function healthPackageBookingReport(HealthPackageBooking $booking)
    {
        if (! $booking->report_file) {
            abort(404, 'Report file not found.');
        }

        if (! Storage::disk('public')->exists($booking->report_file)) {
            abort(404, 'Report file not found.');
        }

        $filePath = Storage::disk('public')->path($booking->report_file);
        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($booking->report_file) . '"',
        ]);
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $start = match ($period) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth(),
        };

        $stats = [
            'new_patients' => Patient::where('created_at', '>=', $start)->count(),
            'appointments' => Appointment::where('created_at', '>=', $start)->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->where('created_at', '>=', $start)->count(),
            'revenue' => Invoice::where('status', 'paid')->where('created_at', '>=', $start)->sum('paid_amount'),
            'pending_dues' => Invoice::whereIn('status', ['unpaid', 'partial'])->sum('due_amount'),
            'admissions' => Admission::where('created_at', '>=', $start)->count(),
            'discharges' => Admission::where('status', 'discharged')->where('updated_at', '>=', $start)->count(),
        ];

        // Department-wise appointments
        $deptStats = Appointment::selectRaw('department_id, COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupBy('department_id')
            ->with('department')
            ->get();

        // Top doctors by appointments
        $topDoctors = Doctor::withCount(['appointments' => fn($q) => $q->where('created_at', '>=', $start)])
            ->orderByDesc('appointments_count')
            ->limit(5)
            ->get();

        // Low stock medicines
        $lowStock = Medicine::whereColumn('stock_quantity', '<=', 'reorder_level')->get();

        return view('admin.reports.index', compact('stats', 'period', 'deptStats', 'topDoctors', 'lowStock'));
    }
}
