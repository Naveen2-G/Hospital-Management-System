<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the enum to include new types
        if (Schema::hasTable('notifications')) {
            // For MySQL, we need to modify the column
            DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('appointment', 'payment', 'system', 'alert', 'booking_status', 'report') DEFAULT 'system'");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('notifications')) {
            // Revert to original enum values
            DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('appointment', 'payment', 'system', 'alert') DEFAULT 'system'");
        }
    }
};
