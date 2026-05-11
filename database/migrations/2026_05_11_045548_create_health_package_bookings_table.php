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
        Schema::create('health_package_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email');
            $table->string('gender');
            $table->integer('age');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->date('preferred_date');
            $table->string('preferred_time_slot');
            $table->string('package_name');
            $table->decimal('package_price', 10, 2);
            $table->text('notes')->nullable();
            $table->string('payment_method')->default('online'); // online, offline
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('booking_status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_package_bookings');
    }
};
