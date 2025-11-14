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
       Schema::table('customer_specimen_results', function($table){       
           $table->bigInteger('ticket_id')->after('customer_id');           
           $table->text('comment')->after('raw_text_val')->nullable();           
          });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('customer_specimen_results', function($table){             
         $table->dropColumn('ticket_id');
         $table->dropColumn('comment');
       });
    }
};
