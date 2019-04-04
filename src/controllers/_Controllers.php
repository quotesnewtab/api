<?php

include __DIR__ . '/Controller.php';
include __DIR__ . '/BlacklistedController.php';
include __DIR__ . '/QuoteController.php';
include __DIR__ . '/SubmissionController.php';

$container['BlacklistedController'] = function($container) {
  return new BlacklistedController($container);
};

$container['QuoteController'] = function($container) {
  return new QuoteController($container);
};

$container['SubmissionController'] = function($container) {
  return new SubmissionController($container);
};