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
         Schema::table('bill_types', function($table){                    
           $table->tinyInteger('req_med_report')->default(1);
           $table->tinyInteger('allow_price_alteration')->default(0);
           $table->tinyInteger('for_sale')->default(0);
           $table->bigInteger('cum_qty')->nullable(); 
           $table->bigInteger('qty_rem')->nullable();  
          });      
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('bill_types', function($table){               
          $table->dropColumn('req_med_report');     
          $table->dropColumn('allow_price_alteration');     
          $table->dropColumn('for_sale');     
          $table->dropColumn('cum_qty'); 
          $table->dropColumn('qty_rem');  
       });
    }
};
