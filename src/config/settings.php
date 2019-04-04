<?php
return [
    // Slim settings
    'displayErrorDetails' => false, // set to false in production
    'addContentLengthHeader' => false,

    // Database settings
    'db' => [
        'driver' => 'mysql',
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_DATABASE'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset' => 'utf8',
        'prefix' => '',
    ],

    // API Rate Limit settings
    'api_rate_limiter' => [
        'max_requests' => '180',
        'per_seconds' => '60',
    ],

    // Monolog settings
    'logger' => [
        'name' => 'quotes-new-tab-api',
        'path' => __DIR__ . '/../../logs/errors.log'
    ]
];