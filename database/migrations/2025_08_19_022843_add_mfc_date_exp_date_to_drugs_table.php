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
        Schema::table('drugs', function($table){                    
           $table->boolean('has_expiry')->after('qty_rem')->default(false);
           $table->date('mfc_date')->after('has_expiry')->nullable();
           $table->date('exp_date')->after('mfc_date')->nullable();           
          });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn('has_expiry');
            $table->dropColumn('mfc_date');
            $table->dropColumn('exp_date');
        });
    }
};
