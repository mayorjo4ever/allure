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
        Schema::create('investigation_result_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('template_id');
            $table->string('label'); // e.g., "Intraocular Pressure (mmHg)"
            $table->string('field_type'); // e.g., text, number, select, image, boolean
            $table->json('options')->nullable(); // for dropdowns or multi-select
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigation_result_fields');
    }
};
