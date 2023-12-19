<?php

namespace AnthonyVasiliuk\HealthCheck\Tests;

use Lunaweb\RedisMock\Providers\RedisMockServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use AnthonyVasiliuk\HealthCheck\Providers\HealthCheckProvider;


class FailedTestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', ':memory:'),
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
