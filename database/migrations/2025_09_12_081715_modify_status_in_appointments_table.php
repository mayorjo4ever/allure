<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::statement("ALTER TABLE appointments MODIFY status ENUM(
            'pending',
            'confirmed',
            'checked_in',            
            'in_consultation',
            'completed',
            'checked_out',
            'canceled'            
        ) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rollback to original enum
        DB::statement("ALTER TABLE appointments MODIFY status ENUM(
            'pending',
            'confirmed',
            'completed',
            'canceled'
        ) DEFAULT 'pending'");
    }
};
