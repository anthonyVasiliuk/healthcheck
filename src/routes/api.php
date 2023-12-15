<?php

use anthonyvasiliuk\healthcheck\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', [HealthCheckController::class, 'healthCheck']);
