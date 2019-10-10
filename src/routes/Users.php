<?php

$app->group('/users', function() {
  $this->get   ('[/page={page:[0-9]+}]', 'UserController:read'     )->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/countries'           , 'UserController:countries')->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/cities/{country}'    , 'UserController:cities'   )->add(new AuthMiddleware($this->getContainer()));
})->add(new BlacklistedMiddleware($container));