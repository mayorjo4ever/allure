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
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('ticket_no')->nullable(); 
            $table->string('hospital')->nullable(); 
            $table->string('doctor')->nullable(); 
            $table->string('consultant')->nullable(); 
            $table->string('clinical_details')->nullable();                     
            $table->string('created_by');
            $table->enum('create_mode',['new','completed'])->default('new');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_tickets');
    }
};
