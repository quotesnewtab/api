<?php

use Respect\Validation\Validator as v;

class BlacklistedController extends Controller {

  /**
   * Create new blacklisted IP.
   */
  public function create($request, $response) {
    $validation = $this->validator->validate($request, [
      'ip'     => v::notEmpty(),
      'reason' => v::notEmpty()
    ]);

    if ($validation->failed()) {
      $errors = $validation->getErrors();

      return $response->withStatus(400)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            'error' => 'INCOMPLETE_DATA',
            'error_message' => 'Unable to perform request. Required parameter(s) `' . implode('`, `', array_keys($errors)) . '` must not be null or empty.',
            'status_code' => 400,
          ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));   
    }

    Blacklisted::create([
      'ip'     => $request->getParam('ip'),
      'reason' => $request->getParam('reason')
    ]);

    return $response->withStatus(201)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Blacklisted IP was successfully created.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Read all blacklisted IPs.
   */
  public function read($request, $response) {
    $blacklisted = Blacklisted::all();

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($blacklisted, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Update a blacklisted IP by ID.
   */
  public function update($request, $response, $id) {
    $validation = $this->validator->validate($request, [
      'ip'     => v::notEmpty(),
      'reason' => v::notEmpty()
    ]);

    if ($validation->failed()) {
      $errors = $validation->getErrors();

      return $response->withStatus(400)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode(array(
            'error' => 'INCOMPLETE_DATA',
            'error_message' => 'Unable to perform request. Required parameter(s) `' . implode('`, `', array_keys($errors)) . '` must not be null or empty.',
            'status_code' => 400,
          ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));   
    }

    Blacklisted::whereId($id)->update([
      'ip'     => $request->getParam('ip'),
      'reason' => $request->getParam('reason')
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Blacklisted IP was successfully updated.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Delete a blacklisted IP by ID.
   */
  public function delete($request, $response, $id) {
    Blacklisted::destroy($id);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Blacklisted IP was successfully deleted.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Check if IP is currently banned.
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