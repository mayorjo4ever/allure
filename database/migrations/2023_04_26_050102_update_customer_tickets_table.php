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
        Schema::table('customer_tickets', function($table){
          ## batch 1
         $table->dateTime('request_date')->after('create_mode')->nullable();                       
           $table->dateTime('date_collected')->after('request_date')->nullable();                       
           $table->integer('year')->after('date_collected')->nullable();                       
          ## batch 2            
           $table->enum('to_modify',['yes','no'])->default('no')->after('year'); 
           $table->enum('finalized',['yes','no'])->default('no')->after('to_modify'); 
           $table->string('finalized_by')->after('finalized')->nullable(); 
           $table->dateTime('date_finalized')->after('finalized_by')->nullable();            
           ## batch 3 
           $table->double('total_cost')->nullable();
           $table->double('amount_paid')->nullable();
           $table->double('discount')->nullable();
           $table->double('refund')->nullable();
           $table->enum('payment_completed',['yes','no'])->default('no');
           $table->enum('payment_finalized',['yes','no'])->default('no');         
           
          });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('customer_tickets', function($table){       
         ## batch 1 
         $table->dropColumn('request_date');         
         $table->dropColumn('date_collected');        
         $table->dropColumn('year');  
         ## batch 2
         $table->dropColumn('to_modify');         
         $table->dropColumn('finalized');        
         $table->dropColumn('finalized_by');    
         $table->dropColumn('date_finalized');                 
         ## batch 3 
         $table->dropColumn('total_cost'); 
         $table->dropColumn('amount_paid');
         $table->dropColumn('discount');
         $table->dropColumn('refund');
         $table->dropColumn('payment_completed');
         $table->dropColumn('payment_finalized');
       });
    }
};
