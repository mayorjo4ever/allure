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
         Schema::table('microorganisms', function($table){       
            $table->enum('micro_type',['bacteria','virus','fungi','algae','protozoan'])->after('name')->nullable(); 
          });     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('microorganisms', function($table){
            $table->dropColumn('micro_type');
         });
    }
};
