<?php

namespace AnthonyVasiliuk\HealthCheck\Tests;

use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use AnthonyVasiliuk\HealthCheck\Providers\HealthCheckProvider;


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
            'client' => 'mock',
            'default' => [
                'url' => env('REDIS_URL'),
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'username' => env('REDIS_USERNAME'),
                'password' => env('REDIS_PASSWORD'),
                'port' => env('REDIS_PORT', '6379'),
                'database' => env('REDIS_DB', '0'),
            ]
        ]);
        $app['config']->set('sentry.dsn', 'https://examplePublicKey@o0.ingest.sentry.io/');
    }
    protected function getPackageProviders($app)
    {
        return [
            HealthCheckProvider::class,
            RedisMockServiceProvider::class
        ];
    }
}
