<?php

$app->group('/tokens', function() {
  $this->post  (''            , 'TokenController:create'     )->add(new AuthMiddleware($this->getContainer()));
  $this->get   (''            , 'TokenController:read'       )->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/'           , 'TokenController:read'       )->add(new AuthMiddleware($this->getContainer()));
  $this->put   ('/{id:[0-9]+}', 'TokenController:update'     )->add(new AuthMiddleware($this->getContainer()));
  $this->delete('/{id:[0-9]+}', 'TokenController:delete'     )->add(new AuthMiddleware($this->getContainer()));
})->add(new RateLimitMiddleware($container));