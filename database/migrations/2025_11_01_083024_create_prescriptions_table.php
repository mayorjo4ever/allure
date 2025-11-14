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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appointment_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('item_id'); // drug_id or lens_id
            $table->string('item_type'); // to know which table to fetch from
            $table->integer('type_id')->nullable(); // for lenses only (1=White, 2=Photo AR, 3=Blue Cut)
            $table->string('type_name')->nullable(); // also store name for readability
            $table->integer('quantity');
            $table->double('unit_price');
            $table->double('total_price');
            $table->string('dosage')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
