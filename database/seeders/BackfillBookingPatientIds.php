<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackfillBookingPatientIds extends Seeder
{
    public function run()
    {
        // Backfill patient_id from user_id where possible
        DB::statement("UPDATE lab_bookings lb JOIN patients p ON p.user_id = lb.user_id SET lb.patient_id = p.id WHERE lb.patient_id IS NULL AND lb.user_id IS NOT NULL");
        DB::statement("UPDATE health_package_bookings hb JOIN patients p ON p.user_id = hb.user_id SET hb.patient_id = p.id WHERE hb.patient_id IS NULL AND hb.user_id IS NOT NULL");

        // Try matching health package bookings to patients by email, phone, or name
        DB::statement("UPDATE health_package_bookings hb JOIN patients p ON p.email = hb.email SET hb.patient_id = p.id WHERE hb.patient_id IS NULL AND hb.email IS NOT NULL");
        DB::statement("UPDATE health_package_bookings hb JOIN patients p ON p.phone = hb.phone SET hb.patient_id = p.id WHERE hb.patient_id IS NULL AND hb.phone IS NOT NULL");
        DB::statement("UPDATE health_package_bookings hb JOIN patients p ON p.name = hb.patient_name SET hb.patient_id = p.id WHERE hb.patient_id IS NULL AND hb.patient_name IS NOT NULL");

        // We cannot reliably backfill package_id as there's no unified packages table in this app.

        // For safety, ensure report_uploaded_at is set when report_file exists but timestamp is null
        DB::statement("UPDATE lab_bookings SET report_uploaded_at = updated_at WHERE report_file IS NOT NULL AND report_uploaded_at IS NULL");
        DB::statement("UPDATE health_package_bookings SET report_uploaded_at = updated_at WHERE report_file IS NOT NULL AND report_uploaded_at IS NULL");

        // For any remaining health package bookings with report_file but no patient_id,
        // create a patient record and link it so reports are accessible to a patient account.
        $unmatched = DB::table('health_package_bookings')
            ->whereNotNull('report_file')
            ->whereNull('patient_id')
            ->get();

        foreach ($unmatched as $hb) {
            $now = date('Y-m-d H:i:s');
            $patientId = DB::table('patients')->insertGetId([
                'user_id' => null,
                'name' => $hb->patient_name ?? 'Unknown',
                'email' => $hb->email,
                'phone' => $hb->phone,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('health_package_bookings')->where('id', $hb->id)->update(['patient_id' => $patientId]);
        }
    }
}
