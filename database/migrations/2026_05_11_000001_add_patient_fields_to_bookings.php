<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lab_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_bookings', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('lab_bookings', 'package_id')) {
                $table->unsignedBigInteger('package_id')->nullable()->after('patient_id');
            }
            if (!Schema::hasColumn('lab_bookings', 'report_uploaded_at')) {
                $table->timestamp('report_uploaded_at')->nullable()->after('report_file');
            }
            if (!Schema::hasColumn('lab_bookings', 'admin_remarks')) {
                $table->text('admin_remarks')->nullable()->after('report_uploaded_at');
            }
        });

        Schema::table('health_package_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('health_package_bookings', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('health_package_bookings', 'package_id')) {
                $table->unsignedBigInteger('package_id')->nullable()->after('patient_id');
            }
            if (!Schema::hasColumn('health_package_bookings', 'report_uploaded_at')) {
                $table->timestamp('report_uploaded_at')->nullable()->after('report_file');
            }
            if (!Schema::hasColumn('health_package_bookings', 'admin_remarks')) {
                $table->text('admin_remarks')->nullable()->after('report_uploaded_at');
            }
        });
    }

    public function down()
    {
        Schema::table('lab_bookings', function (Blueprint $table) {
            $table->dropColumn(['patient_id','package_id','report_uploaded_at','admin_remarks']);
        });

        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->dropColumn(['patient_id','package_id','report_uploaded_at','admin_remarks']);
        });
    }
};
