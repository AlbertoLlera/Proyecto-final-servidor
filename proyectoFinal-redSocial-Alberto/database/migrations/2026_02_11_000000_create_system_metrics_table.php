<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        if (! Schema::hasTable('system_metrics')) {
            Schema::create('system_metrics', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->unsignedBigInteger('value')->default(0);
                $table->timestamps();
            });
        }

        $now = now();

        foreach (['active_sessions', 'cookies_accepted'] as $key) {
            $exists = DB::table('system_metrics')->where('key', $key)->exists();

            if (! $exists) {
                DB::table('system_metrics')->insert([
                    'key' => $key,
                    'value' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        if (Schema::hasTable('system_metrics')) {
            Schema::drop('system_metrics');
        }
    }
};
