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
        Schema::create('investigation_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('investigation_id');
            $table->bigInteger('field_id');
            $table->text('value')->nullable(); // text, number, or image path           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigation_results');
    }
};
