<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('specialization')->nullable();
            $table->string('qualification')->nullable();
            $table->unsignedInteger('experience_years')->default(0);
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->json('availability')->nullable(); // {"mon": ["09:00-12:00","14:00-17:00"], ...}
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
