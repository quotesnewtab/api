<?php

$app->group('/blacklisted', function() {
  $this->post  (''            , 'BlacklistedController:create'     )->add(new AuthMiddleware($this->getContainer()));
  $this->get   (''            , 'BlacklistedController:read'       )->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/'           , 'BlacklistedController:read'       )->add(new AuthMiddleware($this->getContainer()));
  $this->put   ('/{id:[0-9]+}', 'BlacklistedController:update'     )->add(new AuthMiddleware($this->getContainer()));
  $this->delete('/{id:[0-9]+}', 'BlacklistedController:delete'     )->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/status'     , 'BlacklistedController:checkStatus')->add(new AuthMiddleware($this->getContainer()));
})->add(new RateLimitMiddleware($container));