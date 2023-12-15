<?php

namespace AnthonyVasiliuk\HealthCheck\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use AnthonyVasiliuk\HealthCheck\Providers\HealthCheckProvider;


class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            HealthCheckProvider::class,
        ];
    }
}
