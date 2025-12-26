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
        Schema::create('invoice_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number'); 
            $table->bigInteger('organization_id');
            $table->double('amount_paid');
            $table->enum('paymode', ['cash','pos','transfer']);
            $table->dateTime('date_paid');
            $table->integer('collected_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payment_logs');
    }
};
