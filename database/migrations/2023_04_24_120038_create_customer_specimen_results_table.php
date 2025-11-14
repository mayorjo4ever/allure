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
        Schema::create('customer_specimen_results', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('ticket_no'); 
            $table->integer('bill_type_id'); 
            $table->integer('template_id')->nullable(); 
            $table->string('name')->nullable();
            $table->string('result')->nullable();
            $table->text('raw_text_val')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_specimen_results');
    }
};
