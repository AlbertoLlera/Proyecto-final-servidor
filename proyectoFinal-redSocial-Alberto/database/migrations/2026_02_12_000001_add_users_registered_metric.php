<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        $exists = DB::table('system_metrics')->where('key', 'users_registered')->exists();

        if (! $exists) {
            DB::table('system_metrics')->insert([
                'key' => 'users_registered',
                'value' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        DB::table('system_metrics')->where('key', 'users_registered')->delete();
    }
};
