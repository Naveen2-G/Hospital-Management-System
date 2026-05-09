<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->change();
            $table->string('guest_name')->nullable()->after('patient_id');
            $table->string('guest_phone')->nullable()->after('guest_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable(false)->change();
            $table->dropColumn(['guest_name', 'guest_phone']);
        });
    }
};
