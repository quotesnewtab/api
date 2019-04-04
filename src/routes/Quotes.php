<?php

$app->group('/quotes', function() {
  $this->post  (''            , 'QuoteController:create')->add(new AuthMiddleware($this->getContainer()));
  $this->get   (''            , 'QuoteController:readAll');
  $this->get   ('/'           , 'QuoteController:readAll');
  $this->get   ('/{id:[0-9]+}', 'QuoteController:readOne');
  $this->get   ('/random'     , 'QuoteController:readRandom');
  $this->put   ('/{id:[0-9]+}', 'QuoteController:update')->add(new AuthMiddleware($this->getContainer()));
  $this->delete('/{id:[0-9]+}', 'QuoteController:delete')->add(new AuthMiddleware($this->getContainer()));
})->add(new RateLimitMiddleware($container))->add(new BlacklistedMiddleware($container));