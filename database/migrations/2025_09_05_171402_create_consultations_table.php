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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('regno'); 
            $table->bigInteger('doctor_id');
            $table->dateTime('visit_date');
            $table->text('complaint')->nullable();
            $table->longText('review_of_system')->nullable();
            $table->longText('findings')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->longText('treatment_plan')->nullable();
            $table->date('follow_up_date')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
