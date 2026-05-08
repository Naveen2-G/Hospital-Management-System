<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('employee_id');
            $table->date('dob')->nullable()->after('gender');
            $table->string('blood_group', 5)->nullable()->after('dob');
            $table->text('address')->nullable()->after('blood_group');
            $table->date('joining_date')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id',
                'gender',
                'dob',
                'blood_group',
                'address',
                'joining_date',
            ]);
        });
    }
};