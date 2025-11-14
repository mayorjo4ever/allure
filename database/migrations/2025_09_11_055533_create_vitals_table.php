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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('patient_id');

            // General vitals
            $table->string('blood_pressure')->nullable(); // e.g., "120/80"
            $table->integer('pulse')->nullable();         // bpm
            $table->decimal('temperature', 4, 1)->nullable(); // e.g., 37.2
            $table->decimal('weight', 5, 2)->nullable();

            // Eye-specific vitals
            $table->string('va_right')->nullable();   // Visual acuity right
            $table->string('va_left')->nullable();    // Visual acuity left
            $table->decimal('iop_right', 4, 1)->nullable(); // Intraocular pressure right
            $table->decimal('iop_left', 4, 1)->nullable();  // Intraocular pressure left
            $table->string('pupil_reaction')->nullable();   // e.g., "PERRLA"
            $table->string('eom_status')->nullable();       // Extraocular movement status

            $table->timestamps();

            // Relationships
            // $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            // $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
