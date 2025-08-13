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
        Schema::create('Appointment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('appointment_time');
            $table->unsignedSmallInteger('duration_minutes')->default(15);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('confirmed')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Appointment');
    }
};
