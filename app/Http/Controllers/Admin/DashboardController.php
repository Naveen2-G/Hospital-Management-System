<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Admission;
use App\Models\LabBooking;
use App\Models\HealthPackageBooking;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Medicine;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // KPI metrics
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::where('status', 'active')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
            'monthly_revenue' => Invoice::where('status', 'paid')
                ->where('created_at', '>=', $startOfMonth)
                ->sum('paid_amount'),
            'active_admissions' => Admission::where('status', 'admitted')->count(),
            'pending_payments' => Invoice::whereIn('status', ['unpaid', 'partial'])->sum('due_amount'),
        ];

        // Revenue for last 7 days (for chart)
        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenueChart[] = [
                'date' => $date->format('M d'),
                'amount' => Invoice::where('status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('paid_amount'),
            ];
        }

        // Appointments by status (for chart)
        $appointmentStats = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // Recent appointments
        $recentAppointments = Appointment::with(['patient', 'doctor', 'department'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Recent audit logs
        $recentActivity = AuditLog::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Room occupancy
        $roomStats = [
            'total' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
        ];

        // Low stock medicines
        $lowStockMedicines = Medicine::whereColumn('stock_quantity', '<=', 'reorder_level')
            ->where('stock_quantity', '>', 0)
            ->limit(5)
            ->get();

        $healthPackageStats = [
            'total' => HealthPackageBooking::count(),
            'confirmed' => HealthPackageBooking::where('booking_status', 'confirmed')->count(),
            'paid' => HealthPackageBooking::where('payment_status', 'paid')->count(),
            'revenue' => HealthPackageBooking::where('payment_status', 'paid')->sum('package_price'),
        ];

        $recentHealthPackageBookings = HealthPackageBooking::orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentLabBookings = LabBooking::orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueChart',
            'appointmentStats',
            'recentAppointments',
            'recentActivity',
            'roomStats',
            'lowStockMedicines',
            'healthPackageStats',
            'recentHealthPackageBookings',
            'recentLabBookings'
        ));
    }
}
