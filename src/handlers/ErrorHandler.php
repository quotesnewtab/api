<?php

/**
 * Custom global error handler.
 */
$container['errorHandler'] = function($container) {
  return function ($request, $response, $exception) use ($container) {
      $monoLog = $container->logger;
      $monoLog->addError($exception->getMessage());
      $monoLog->addError($exception->getTraceAsString());
      $monoLog->addError($exception->getFile());
      $monoLog->addError($exception->getCode());
      $monoLog->addError($exception->getLine());

      return $response->withStatus(500)
          ->withHeader('Content-Type', 'application/json')
          ->write(json_encode(array(
              'error' => 'INTERNAL_ERROR',
              'error_message' => 'Something went wrong internally. Contact support if problem persists.',
              'status_code' => 500
            ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));    
  };
};