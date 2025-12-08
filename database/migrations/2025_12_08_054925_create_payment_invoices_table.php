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
        Schema::create('payment_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->bigInteger('organization_id');
            $table->bigInteger('appointment_id');
            $table->bigInteger('customer_bill_id');
            $table->bigInteger('patient_id');
            $table->bigInteger('account_id');
            $table->double('amount');
            $table->double('discount')->default(0);
            $table->enum('status',['opened','closed'])->default('opened'); 
            $table->tinyInteger('payment_completed')->default(0); 
            $table->bigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_invoices');
    }
};
