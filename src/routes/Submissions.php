<?php

$app->group('/submissions', function() {
  $this->post  (''                    , 'SubmissionController:create')->add(new SubmissionAuthMiddleware($this->getContainer()));
  $this->get   (''                    , 'SubmissionController:read')->add(new AuthMiddleware($this->getContainer()));
  $this->get   ('/'                   , 'SubmissionController:read')->add(new AuthMiddleware($this->getContainer()));
  $this->put   ('/{id:[0-9]+}'        , 'SubmissionController:update')->add(new AuthMiddleware($this->getContainer()));
  $this->delete('/{id:[0-9]+}'        , 'SubmissionController:delete')->add(new AuthMiddleware($this->getContainer()));
  $this->post  ('/{id:[0-9]+}/accept' , 'SubmissionController:accept')->add(new AuthMiddleware($this->getContainer()));
  $this->post  ('/{id:[0-9]+}/decline', 'SubmissionController:decline')->add(new AuthMiddleware($this->getContainer()));
})->add(new BlacklistedMiddleware($container));