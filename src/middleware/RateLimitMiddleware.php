<?php

class RateLimitMiddleware extends Middleware {
  public function __invoke($request, $response, $next) {
    $APIRateLimiter = new RateLimiter($this->container);
    $exceeded = $APIRateLimiter->isExceeded();

    if ($exceeded) {
      $response = $response->withStatus(429)
        ->withHeader('X-RateLimit-Limit', $this->container->settings['api_rate_limiter']['max_requests'])
        ->withHeader('X-RateLimit-Remaining', 0)
        ->write(json_encode(array(
            'error' => 'TOO_MANY_REQUESTS',
            'error_message' => 'You hit the rate limit for API calls, please wait for it to reset before trying to call again.',
            'status_code' => 429,
          ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    } else {
      $response = $next($request, $response)
        ->withHeader('X-RateLimit-Limit', $this->container->settings['api_rate_limiter']['max_requests'])
        ->withHeader('X-RateLimit-Remaining', $APIRateLimiter->getRemaining());
    }

    return $response;
  }
}