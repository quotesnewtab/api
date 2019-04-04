<?php

$app->group('/blacklisted', function() {
  $this->get('' , 'BlacklistedController:checkStatus');
  $this->get('/', 'BlacklistedController:checkStatus');
})->add(new RateLimitMiddleware($container));