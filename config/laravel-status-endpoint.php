<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Status Endpoint Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for configuring the GonNl\LaravelStatusEndpoint package.
    |
    */

    'cache_key' => env('STATUS_ENDPOINT_CACHE_KEY', 'last_check'),

    'database_check_query' => env('STATUS_ENDPOINT_DATABASE_CHECK_QUERY', 'SELECT 1'),

    'database_warning_threshold' => env('STATUS_ENDPOINT_DATABASE_WARNING_THRESHOLD', 200),

    'cache_warning_threshold' => env('STATUS_ENDPOINT_CACHE_WARNING_THRESHOLD', 100),

];
