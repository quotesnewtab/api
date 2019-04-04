<?php

/**
* Custom 404 Not Found error handler.
*/
$container['notFoundHandler'] = function($container) {
  return function ($request, $response) use ($container) {
      return $response->withStatus(404)
          ->withHeader('Content-Type', 'application/json')
          ->write(json_encode(array(
              'error' => 'NOT_FOUND',
              'error_message' => 'Endpoint was not found. Check API documentation for valid endpoints.',
              'status_code' => 404,
            ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));    
  };
};