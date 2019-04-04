<?php

class BlacklistedController extends Controller {

  /**
   * Check status if banned.
   */
  public function checkStatus($request, $response) {
    $blacklisted = Blacklisted::whereIp($this->getIP())->exists();

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($blacklisted, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Get IP of user.
   */
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