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
        Schema::create('specimen_result_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_type_id'); 
            $table->string('name')->nullable();                         
            $table->text('raw_text_val')->nullable(); 
            $table->boolean('has_unit')->default(0);
            $table->string('unit')->nullable();
            $table->boolean('has_ref_val')->default(0);
            $table->string('ref_val')->nullable();
            $table->enum('age_range', ['infant','youth','adult'])->default('adult');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specimen_result_templates');
    }
};
