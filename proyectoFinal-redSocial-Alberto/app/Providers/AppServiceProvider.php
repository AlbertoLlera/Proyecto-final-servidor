<?php

namespace App\Providers;

use App\Services\SystemMetrics;
use App\Support\SystemMetricKeys;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier servicio de la aplicación.
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa los servicios de la aplicación.
     */
    public function boot(): void
    {
        Event::listen(Login::class, static function (): void {
            SystemMetrics::increment(SystemMetricKeys::ACTIVE_SESSIONS);
        });

        Event::listen(Logout::class, static function (): void {
            SystemMetrics::decrement(SystemMetricKeys::ACTIVE_SESSIONS);
        });

        Event::listen(Registered::class, static function (): void {
            SystemMetrics::increment(SystemMetricKeys::USERS_REGISTERED);
        });
    }
}
