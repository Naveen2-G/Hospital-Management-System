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
        Schema::create('lab_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->integer('age');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->date('preferred_date');
            $table->string('preferred_time_slot');
            $table->string('test_name');
            $table->decimal('test_price', 10, 2);
            $table->text('notes')->nullable();
            $table->enum('payment_method', ['online', 'home']);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('booking_status', ['pending', 'confirmed', 'sample_collected', 'completed', 'cancelled'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_bookings');
    }
};
