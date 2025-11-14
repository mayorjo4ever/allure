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
        Schema::create('customer_ticket_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('ticket_no');
            $table->double('total_cost');
            $table->double('discount')->nullable();
            $table->double('amount_paid')->nullable();
            $table->double('refund')->nullable();
            $table->enum('payment_completed',['yes','no'])->default('no'); 
            $table->enum('payment_finalized',['yes','no'])->default('no'); 
            $table->string('received_by')->nullable();
            $table->dateTime('date_finalized')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ticket_payments');
    }
};
