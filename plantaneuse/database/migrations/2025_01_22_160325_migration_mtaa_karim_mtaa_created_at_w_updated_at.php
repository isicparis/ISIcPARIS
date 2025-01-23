<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Increase statement timeout
        DB::statement('SET statement_timeout TO 600000;'); // 10 minutes

        Schema::table('plantes', function (Blueprint $table) {
            $table->timestamps(); // This will add both created_at and updated_at columns
        });

        // Reset statement timeout to default
        DB::statement('RESET statement_timeout;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantes', function (Blueprint $table) {
            $table->dropTimestamps(); // This will remove both created_at and updated_at columns
        });
    }
};