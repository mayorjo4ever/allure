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
        Schema::table('appointments', function (Blueprint $table) {
           $table->boolean('checkedin')->default(false);
           $table->boolean('checkedout')->default(false);
           $table->dateTime('checkin_time')->nullable();
           $table->dateTime('checkout_time')->nullable();
           $table->bigInteger('customer_bill_id')->after('ticketno')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['checkedin','checkedout',
                'checkin_time','checkout_time']);
        });
    }
};
