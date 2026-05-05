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
        abort_unless($user, 403);

        $isAdmin = $user->role === 'admin';
        $isDoctorOwner = $user->role === 'doctor' && $user->doctor && $user->doctor->id === $labOrder->doctor_id;

        abort_unless($isAdmin || $isDoctorOwner, 403);

        abort_if(! $labOrder->report_file, 404, 'Report file not found.');
        abort_if(! Storage::disk('public')->exists($labOrder->report_file), 404, 'Report file not found.');

        $filePath = Storage::disk('public')->path($labOrder->report_file);
        $mimeType = Storage::disk('public')->mimeType($labOrder->report_file) ?? 'application/octet-stream';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($labOrder->report_file) . '"',
        ]);
    }
}
