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
        Schema::create('bill_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');            
            $table->integer('categ_id'); 
            $table->string('specimen_sample')->nullable();
            $table->double('adult_price')->nullable();
            $table->double('children_price')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('template_type', ['param_form','text_form','for_sale','no_report'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_types');
    }
};
