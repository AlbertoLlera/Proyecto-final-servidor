<?php

namespace App\Http\Controllers;

use App\Services\SystemMetrics;
use App\Support\SystemMetricKeys;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if (! $request->session()->has('cookies_registered')) {
            SystemMetrics::increment(SystemMetricKeys::COOKIES_ACCEPTED);
            $request->session()->put('cookies_registered', true);
        }

        return response()->json([
            'status' => 'registrado',
            'cookies_accepted' => SystemMetrics::value(SystemMetricKeys::COOKIES_ACCEPTED),
            'active_sessions' => SystemMetrics::value(SystemMetricKeys::ACTIVE_SESSIONS),
        ]);
    }
}
