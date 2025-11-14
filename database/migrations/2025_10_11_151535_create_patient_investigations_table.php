v<?php

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
        Schema::create('patient_investigations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id');
            $table->bigInteger('appointment_id')->nullable();
            $table->bigInteger('doctor_id');
            $table->bigInteger('investigation_template_id');
            $table->decimal('price', 10, 2);
            $table->enum('status',['pending','done','cancelled'])->default('pending'); // pending, done, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_investigations');
    }
};
