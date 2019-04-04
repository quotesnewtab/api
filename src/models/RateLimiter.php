<?php

class RateLimiter {
  private $max_requests;
  private $per_seconds;
  private $ip;
  private $remaining;

  public function __construct($container) {
    $this->max_requests = $container->settings['api_rate_limiter']['max_requests'];
    $this->per_seconds = $container->settings['api_rate_limiter']['per_seconds'];
    $this->ip = $this->getIP();
  }

  public function __invoke() {
    return $this->isExceeded();
  }

  public function isExceeded() {
    $xrequest = XRequest::find($this->ip);

    if (!$xrequest) {
      XRequest::create([ 'ip' => $this->ip ]);
      $this->remaining = $this->max_requests - 1;
    } else {
      // Check time elapsed between first and time now.
      $time_elapsed = strtotime(date('Y-m-d H:i:s')) - strtotime($xrequest->first_request);

      // If time elapsed is bigger than rate limit time period, reset 'requests' column.
      if ($time_elapsed > $this->per_seconds) {
        XRequest::whereIp($this->ip)->update([ 
          'requests' => 1,
          'first_request' => date('Y-m-d H:i:s'),
          'last_request' => date('Y-m-d H:i:s')
        ]);
        $this->remaining = $this->max_requests - 1;
      } 
      
      // If requests sent in the rate limit time period is equal to the rate limit max requests, return false.
      else if ($xrequest->requests == $this->max_requests) {
        XRequest::whereIp($this->ip)->increment('spam_requests');
        return true;
      } 
      
      // Else just increment the 'requests' column in database.
      else {
        XRequest::whereIp($this->ip)->increment('requests');
        $this->remaining = $this->max_requests - ($xrequest->requests + 1);
      }
    }

    return false;
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

  public function getRemaining() {
    return $this->remaining;
  }
}