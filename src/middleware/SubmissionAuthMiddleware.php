<?php

class SubmissionAuthMiddleware extends Middleware {
  public function __invoke($request, $response, $next) {
    $validToken = Token::whereToken($_GET['auth_token'])->exists();

    if ($validToken) {
      $response = $next($request, $response);
    } else {
      $response = $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            'error' => 'NOT_AUTHORIZED',
            'error_message' => 'You are not authorized to access this endpoint.',
            'status_code' => 401,
          ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));  
    }

    return $response;
  }
}