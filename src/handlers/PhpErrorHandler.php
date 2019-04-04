<?php

/**
* Custom global PHP error handler.
*/
$container['phpErrorHandler'] = function($container) {
  return $container['errorHandler'];
};