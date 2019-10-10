<?php

$app->group('/admin', function() {
  $this->post('/login', 'AdminController:login');
})->add(new RateLimitMiddleware($container))->add(new BlacklistedMiddleware($container));