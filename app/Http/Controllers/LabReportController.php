<?php

namespace App\Http\Controllers;

use App\Models\HealthPackageBooking;
use App\Models\LabOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabReportController extends Controller
{
    public function show(LabOrder $labOrder)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        $isAdmin = $user->role === 'admin';
        $isDoctorOwner = $user->role === 'doctor' && $user->doctor && $user->doctor->id === $labOrder->doctor_id;
        $isPatientOwner = $user->role === 'patient' && $user->patient && $user->patient->id === $labOrder->patient_id;

        if (! ($isAdmin || $isDoctorOwner || $isPatientOwner)) {
            abort(403);
        }

        if (! $labOrder->report_file) {
            abort(404, 'Report file not found.');
        }

        if (! Storage::disk('public')->exists($labOrder->report_file)) {
            abort(404, 'Report file not found.');
        }

        $filePath = Storage::disk('public')->path($labOrder->report_file);
        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($labOrder->report_file) . '"',
        ]);
    }

    public function healthPackageBookingReport(\Illuminate\Http\Request $request, HealthPackageBooking $booking)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'patient' || (int)$user->id !== (int)$booking->user_id) {
            abort(403, 'Forbidden: You do not have permission to view this report.');
        }

        if (! $booking->report_file) {
            abort(404, 'Report file not found.');
        }

        if (! Storage::disk('public')->exists($booking->report_file)) {
            abort(404, 'Report file not found.');
        }

        $filePath = Storage::disk('public')->path($booking->report_file);
        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';

        if ($request->query('download')) {
            return response()->download($filePath, basename($booking->report_file), ['Content-Type' => $mimeType]);
        }

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($booking->report_file) . '"',
        ]);
    }

    public function labBookingReport(\Illuminate\Http\Request $request, \App\Models\LabBooking $booking)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'patient' || (int)$user->id !== (int)$booking->user_id) {
            abort(403, 'Forbidden: You do not have permission to view this report.');
        }

        if (! $booking->report_file) {
            abort(404, 'Report file not found.');
        }

        if (! Storage::disk('public')->exists($booking->report_file)) {
            abort(404, 'Report file not found.');
        }

        $filePath = Storage::disk('public')->path($booking->report_file);
        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';

        if ($request->query('download')) {
            return response()->download($filePath, basename($booking->report_file), ['Content-Type' => $mimeType]);
        }

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($booking->report_file) . '"',
        ]);
    }
}
