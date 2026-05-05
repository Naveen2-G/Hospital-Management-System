<?php

namespace App\Http\Controllers;

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

        if (! ($isAdmin || $isDoctorOwner)) {
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
}
