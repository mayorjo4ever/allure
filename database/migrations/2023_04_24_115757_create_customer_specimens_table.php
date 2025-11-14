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
        Schema::create('customer_specimens', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('ticket_no')->nullable(); 
            $table->integer('bill_type_id'); 
            $table->string('specimen_sample');
            $table->double('bill_price'); 
            $table->enum('finalized',['yes','no'])->default('no'); 
            $table->enum('process_completed',['yes','no'])->default('no'); 
            $table->enum('to_modify',['yes','no'])->default('no'); 
            $table->text('comment')->nullable(); 
            $table->dateTime('date_submitted')->nullable();
            $table->dateTime('date_perform')->nullable();
            $table->string('created_by')->nullable();
            $table->string('result_uploaded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_specimens');
    }
};
