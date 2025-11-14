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
        Schema::create('customer_bills', function (Blueprint $table) {
            $table->id();
            $table->string('ticketno')->nullable(); 
            $table->bigInteger('appointment_id');
            $table->bigInteger('patient_id')->nullable();
            $table->string('bill_type_ids')->nullable();
            $table->double('total_cost')->default(0);
            $table->double('amount_paid')->default(0);
            $table->double('discount')->default(0);
            $table->double('refund')->default(0);
            $table->boolean('payment_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_bills');
    }
};
