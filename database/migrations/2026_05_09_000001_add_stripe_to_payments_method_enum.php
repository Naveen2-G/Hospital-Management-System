<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `method` ENUM('cash', 'card', 'online', 'insurance', 'stripe') NOT NULL DEFAULT 'cash'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `method` ENUM('cash', 'card', 'online', 'insurance') NOT NULL DEFAULT 'cash'");
    }
};
