<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD']);

// Instantiate the app
$settings = require __DIR__ . '/src/config/settings.php';
$app = new \Slim\App(['settings' => $settings]);

// Get container
$container = $app->getContainer();

// Initiate database
require __DIR__ . '/src/config/database.php';

// Set up handlers
require __DIR__ . '/src/handlers/_Handlers.php';

// Set up dependencies
require __DIR__ . '/src/config/dependencies.php';

// Import models
require __DIR__ . '/src/models/_Models.php';

// Import controllers
require __DIR__ . '/src/controllers/_Controllers.php';

// Import middlewares
require __DIR__ . '/src/middleware/_Middlewares.php';

// Register routes
require __DIR__ . '/src/routes/_Routes.php';

// Run app
$app->run();