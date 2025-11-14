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
        /** 
         Schema::table('users', function($table){       
           $table->enum('account_type',['personal','family'])->after('othername')->default('personal');           
           $table->string('occupation')->nullable();
           $table->string('employee_address')->nullable();
           $table->string('residence')->nullable();
           $table->string('country_id')->nullable();
           $table->string('state_id')->nullable();
           $table->string('city_id')->nullable();
           $table->string('nok_name')->nullable();
           $table->string('nok_relationship')->nullable();
           $table->string('nok_phone')->nullable();
           $table->string('nok_address')->nullable();
           $table->string('family_id')->nullable();
           $table->tinyInteger('family_host')->default(0);
           $table->enum('family_position',['husband','wife','first_child','second_child','third_child','fourth_child','fifth_child','sixth_child','friend','relative','others'])->nullable();
          });      
         */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*  
        Schema::table('users', function($table){               
          $table->dropColumn('nok_name');     
          $table->dropColumn('nok_relationship');     
          $table->dropColumn('nok_phone');     
          $table->dropColumn('nok_address');     
          $table->dropColumn('account_type');     
          $table->dropColumn('family_id');      
          $table->dropColumn('family_host');     
          $table->dropColumn('family_position');     
          $table->dropColumn('occupation');        
          $table->dropColumn('residence');     
          $table->dropColumn('employee_address');     
          $table->dropColumn('country_id');     
          $table->dropColumn('state_id');     
          $table->dropColumn('city_id');
         });
         *
         */
    }
};
