<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->text('allergies')->nullable()->after('emergency_contact_name');
            $table->text('chronic_diseases')->nullable()->after('allergies');
            $table->string('avatar')->nullable()->after('chronic_diseases');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['allergies', 'chronic_diseases', 'avatar']);
        });
    }
};
