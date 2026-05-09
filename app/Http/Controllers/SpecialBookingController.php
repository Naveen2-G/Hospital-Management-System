<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SpecialBookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'reason' => 'required|string',
            'service' => 'required|string|in:Emergency,Video Consultation',
            'department' => 'nullable|exists:departments,id',
            'doctor' => 'nullable|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // For special bookings, we set the date to today or tomorrow depending on time
            $date = Carbon::now()->toDateString();
            $timeSlot = Carbon::now()->addHour()->format('H:i') . ' - ' . Carbon::now()->addHours(2)->format('H:i');

            Appointment::create([
                'guest_name' => $request->name,
                'guest_phone' => $request->phone,
                'notes' => $request->reason,
                'type' => $request->service === 'Video Consultation' ? 'video' : 'emergency',
                'department_id' => $request->department,
                'doctor_id' => $request->doctor,
                'appointment_date' => $date,
                'time_slot' => $timeSlot,
                'status' => 'pending',
                // patient_id remains null for guest users
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Request received successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Special Booking Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }
}
