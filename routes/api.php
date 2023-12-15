<?php

use AnthonyVasiliuk\HealthCheck\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', [HealthCheckController::class, 'healthCheck']);
