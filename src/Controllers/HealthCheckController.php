<?php

namespace anthonyvasiliuk\healthcheck\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use function Gedisa\Healthcheck\Controllers\collect;
use function Gedisa\Healthcheck\Controllers\config;
use function Gedisa\Healthcheck\Controllers\response;

class HealthCheckController
{
    public function healthCheck(): JsonResponse
    {
        return response()->json(
            $status = collect([
                'redis' => $this->redisStatus(),
                'database' => $this->databaseStatus(),
                'sentry' => $this->sentryStatus(),
            ]),
            status: $status->every(fn ($item) => ($item))
                ? 200
                : 503
        );
    }

    private function redisStatus(): bool
    {
        $testKey = '_health';
        $testValue = 'ok';

        try {
            Redis::connection();

            Redis::set($testKey, $testValue);

            return Redis::get($testKey) === $testValue;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    private function databaseStatus(): bool
    {
        try {
            DB::connection()->getPdo();

            return DB::connection()->getDatabaseName() === config('database.connections.mysql.database');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    private function sentryStatus(): bool
    {
        try {
            return Route::dispatch(Request::create(config('sentry.dsn')))->getStatusCode() === 200;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }
}
