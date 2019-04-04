<?php

/**
* Custom 405 Not Allowed error handler.
*/
$container['notAllowedHandler'] = function($container) {
  return function ($request, $response, $methods) use ($container) {
      return $response->withStatus(405)
          ->withHeader('Allow', implode(', ', $methods))
          ->withHeader('Content-Type', 'application/json')
          ->write(json_encode(array(
              'error' => 'NOT_ALLOWED',
              'error_message' => 'HTTP request method is not allowed. Check API documentation for valid methods.',
              'status_code' => 405,
            ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  };
};