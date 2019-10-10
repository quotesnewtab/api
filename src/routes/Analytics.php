<?php

$app->group('/analytics', function() {
  $this->get('' , 'AnalyticsController:read')->add(new AuthMiddleware($this->getContainer()));
  $this->get('/', 'AnalyticsController:read')->add(new AuthMiddleware($this->getContainer()));
})->add(new RateLimitMiddleware($container));