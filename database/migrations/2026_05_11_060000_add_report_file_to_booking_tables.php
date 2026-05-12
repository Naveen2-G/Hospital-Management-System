<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lab_bookings', function (Blueprint $table) {
            $table->string('report_file')->nullable()->after('transaction_id');
        });

        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->string('report_file')->nullable()->after('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('lab_bookings', function (Blueprint $table) {
            $table->dropColumn('report_file');
        });

        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->dropColumn('report_file');
        });
    }
};