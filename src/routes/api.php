<?php

use Illuminate\Support\Facades\Route;
use anthonyvasiliuk\healthcheck\src\Controllers\HealthCheckController;

Route::get('/healthcheck', [HealthCheckController::class, 'healthCheck']);
