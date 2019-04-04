<?php

class BlacklistedMiddleware extends Middleware {
  public function __invoke($request, $response, $next) {
    $blacklisted = Blacklisted::whereIp($this->getIP())->exists();

    if (!$blacklisted) {
      $response = $next($request, $response);
    } else {
      $response = $response->withStatus(403)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            'error' => 'BLACKLISTED',
            'error_message' => 'You are banned from using the API due to missuse.',
            'status_code' => 403,
          ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));  
    }

    return $response;
  }

  protected function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
      // IP from shared internet.
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        // IP pass from proxy.
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
  }
}