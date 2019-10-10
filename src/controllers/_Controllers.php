<?php

include __DIR__ . '/Controller.php';
include __DIR__ . '/AdminController.php';
include __DIR__ . '/AnalyticsController.php';
include __DIR__ . '/BlacklistedController.php';
include __DIR__ . '/QuoteController.php';
include __DIR__ . '/SubmissionController.php';
include __DIR__ . '/TokenController.php';
include __DIR__ . '/UserController.php';

$container['AdminController'] = function($container) {
  return new AdminController($container);
};

$container['AnalyticsController'] = function($container) {
  return new AnalyticsController($container);
};

$container['BlacklistedController'] = function($container) {
  return new BlacklistedController($container);
};

$container['QuoteController'] = function($container) {
  return new QuoteController($container);
};

$container['SubmissionController'] = function($container) {
  return new SubmissionController($container);
};

$container['TokenController'] = function($container) {
  return new TokenController($container);
};

$container['UserController'] = function($container) {
  return new UserController($container);
};