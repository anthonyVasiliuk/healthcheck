<?php

use Illuminate\Support\Facades\Route;
use src\Controllers\HealthCheckController;

Route::get('/healthcheck', [HealthCheckController::class, 'healthCheck']);
