<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Blacklisted routes
require __DIR__ . '/Blacklisted.php';

// Quotes routes
require __DIR__ . '/Quotes.php';

// Submissions routes
require __DIR__ . '/Submissions.php';

// Cors routes
require __DIR__ . '/Cors.php';