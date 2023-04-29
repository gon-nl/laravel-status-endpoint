<?php

use Illuminate\Support\Facades\Route;
use GonNl\LaravelStatusEndpoint\Http\Controllers\StatusController;

Route::get('/api/status', [StatusController::class, 'index']);