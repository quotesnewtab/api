<?php

include __DIR__ . '/../validation/Validator.php';

$container['validator'] = function($container) {
  return new Validator();
};

$container['logger'] = function($container) {
  $settings = $container->settings['logger'];
  $logger = new Monolog\Logger($settings['name']);
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path']));
  return $logger;
};