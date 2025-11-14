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
        Schema::create('users_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('regno');
            $table->longText('history')->nullable();
            $table->longText('drug_history')->nullable();
            $table->longText('family_history')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_histories');
    }
};
