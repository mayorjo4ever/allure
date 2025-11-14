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
        Schema::create('lenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('categ_id');
            $table->integer('type_id');
            $table->tinyInteger('status')->default(1);
            $table->double('purchase_price')->default(0);
            $table->double('sales_price')->default(0);
            $table->bigInteger('cum_qty')->default(0);
            $table->bigInteger('qty_rem')->default(0);
            $table->string('pix_name')->nullable();
            $table->integer('pix_width')->default(400);
            $table->integer('pix_height')->default(150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lenses');
    }
};
