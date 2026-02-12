<?php

namespace App\Services;

use App\Models\SystemMetric;
use Illuminate\Support\Facades\DB;

class SystemMetrics
{
    public static function increment(string $key, int $amount = 1): int
    {
        return DB::transaction(function () use ($key, $amount) {
            $metric = SystemMetric::query()
                ->lockForUpdate()
                ->firstOrCreate(['key' => $key], ['value' => 0]);

            $metric->value += $amount;
            $metric->save();

            return $metric->value;
        });
    }

    public static function decrement(string $key, int $amount = 1): int
    {
        return DB::transaction(function () use ($key, $amount) {
            $metric = SystemMetric::query()
                ->lockForUpdate()
                ->firstOrCreate(['key' => $key], ['value' => 0]);

            $metric->value = max(0, $metric->value - $amount);
            $metric->save();

            return $metric->value;
        });
    }

    public static function value(string $key): int
    {
        return (int) (SystemMetric::query()->where('key', $key)->value('value') ?? 0);
    }
}
