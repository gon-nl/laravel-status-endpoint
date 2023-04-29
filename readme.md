# Laravel Status Endpoint

Laravel Status Endpoint is a Laravel package that adds a simple `/api/status` endpoint to your application, returning the current status of the database and cache.

## Installation

You can install the package via composer:

```bash
composer require gon-nl/laravel-status-endpoint
```

After installation, the package should be auto-discovered by Laravel.

## Configuration

You can publish the configuration file by running the following command:

```bash
php artisan vendor:publish --provider="GonNl\LaravelStatusEndpoint\LaravelStatusEndpointServiceProvider" --tag="config"
```

This will create a new `laravel-status-endpoint.php` file in your `config` directory.

### Thresholds

You can configure the warning thresholds for both the database and cache checks by specifying the `database.threshold` and `cache.threshold` values in the configuration file, respectively. The default values are `200` and `100` (in milliseconds), respectively.

## Usage

After installation, you can access the `/status` endpoint of your application to get the current status of the database and cache. The endpoint returns a JSON response with the following structure:

```json
{
    "status": "OK",
    "database": 94,
    "cache": 36,
    "last_check": "2022-05-01 12:00:00",
    "last_check_human": "1 hour ago"
}
```

The `status` field indicates the overall status of the checks, which can be either `OK`, `WARNING`, or `ERROR`. The `database` and `cache` fields indicate the execution time (in milliseconds) of the database and cache checks, respectively. The `last_check` and `last_check_human` fields indicate the date and time of the last status check, as well as a human-readable representation of the elapsed time since the last check, respectively.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.