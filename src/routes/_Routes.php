<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Admin routes
require __DIR__ . '/Admin.php';

// Analytics routes
require __DIR__ . '/Analytics.php';

// Blacklisted routes
require __DIR__ . '/Blacklisted.php';

// Quotes routes
require __DIR__ . '/Quotes.php';

// Submissions routes
require __DIR__ . '/Submissions.php';

// Tokens routes
require __DIR__ . '/Tokens.php';

// Users routes
require __DIR__ . '/Users.php';

// Cors routes
require __DIR__ . '/Cors.php';