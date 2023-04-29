<?php
namespace GonNl\LaravelStatusEndpoint\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class StatusController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display the status of the application's database and cache.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $config = config('laravel-status-endpoint');

        $status = 'OK';
        $error = false;
        $cacheTime = $databaseTime = $lastCheck = 0;
        $lastCheck = Cache::get($config['cache_key']);

        // Check the cache status
        try {
            $cacheTime = $this->timedExecution(function () use($config) {
                Cache::set($config['cache_key'], now()->toDateTimeString());
                Cache::get($config['cache_key']);
            });
        } catch (\Throwable $th) {
            $error = true;
        }

        // Check the database status
        try {
            $databaseTime = $this->timedExecution(function () use($config) {
                DB::statement($config['database_check_query']);
            });
        } catch (\Throwable $th) {
            $error = true;
        }

        // Determine if the overall status should be set to WARNING
        if ($databaseTime > $config['database_warning_threshold'] || $cacheTime > $config['cache_warning_threshold']) {
            $status = 'WARNING';
        }

        // Return the response as JSON
        return response()->json([
            'status' => $error ? 'ERROR' : $status,
            'database' => $databaseTime ?: 'ERROR',
            'cache' => $cacheTime ?: 'ERROR',
            'last_check' => $lastCheck = Cache::get('last_check'),
            'last_check_human' => now()->parse($lastCheck)->diffForHumans()
        ], $error ? 500 : 200);
    }

    /**
     * Execute a callback and return the execution time in microseconds.
     *
     * @param callable $callback
     * @return int
     */
    private function timedExecution(callable $callback): int
    {
        $start = microtime(true);
        $callback();
        return $this->convertToMicroseconds(microtime(true) - $start);
    }

    /**
     * Convert a time value to microseconds.
     *
     * @param mixed $time The time value to convert.
     *
     * @return int The time value converted to microseconds.
     */
    private function convertToMicroseconds($time): int
    {
        return floor($time * 1000);
    }
}

