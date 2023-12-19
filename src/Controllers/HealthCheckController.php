<?php

namespace Gedisa\LaravelSimpleHealthCheck\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

            return DB::connection()->getDatabaseName() === $this->getDefaultDatabaseConnection();
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

    private function getDefaultDatabaseConnection()
    {
        return match (config('database.default')) {
            'sqlite' => config('database.connections.sqlite.database'),
            'mysql' => config('database.connections.mysql.database'),
            'pgsql' => config('database.connections.pgsql.database'),
        };
    }
}
