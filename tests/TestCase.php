<?php

namespace Gedisa\LaravelSimpleHealthCheck\Tests;

use Gedisa\LaravelSimpleHealthCheck\Providers\HealthCheckProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', ':memory:'),
        ]);
        $app['config']->set('database.redis', [
            'client' => 'predis',
            'default' => [
                'url' => env('REDIS_URL'),
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'username' => env('REDIS_USERNAME'),
                'password' => env('REDIS_PASSWORD'),
                'port' => env('REDIS_PORT', '6379'),
                'database' => env('REDIS_DB', '0'),
            ],
        ]);
        $app['config']->set('sentry.dsn', 'https://examplePublicKey@o0.ingest.sentry.io/');
    }

    protected function getPackageProviders($app): array
    {
        return [
            HealthCheckProvider::class,
        ];
    }
}
