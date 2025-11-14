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
        Schema::table('users', function (Blueprint $table) {
            // First, rename the column (optional if you want a new name)
           // $table->enum('hmo',['outsider','personal','family','corporate'])->after('othername')->default('personal');
            #$table->renameColumn('account_type', 'hmo');
        });
        
         // Change type to nullable string and add more field 
        Schema::table('users', function (Blueprint $table) {
           // $table->string('hmo')->nullable()->change();
            $table->string('enrole_no')->after('hmo')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Revert the column to non-nullable enum and rename it back
        Schema::table('users', function (Blueprint $table) {
            ## $table->enum('account_type', ['active', 'inactive'])->nullable(false)->change();
            $table->dropColumn('enrole_no');        
            $table->dropColumn('hmo');            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('hmo', 'account_type');
            $table->enum('hmo',['outsider','personal','family','corporate'])->after('othername')->default('personal');
        });
    }
};
