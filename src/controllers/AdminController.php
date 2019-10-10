<?php

use Respect\Validation\Validator as v;

class AdminController extends Controller {
  public function login($request, $response) {
    $validation = $this->validator->validate($request, [
      'username' => v::notEmpty(),
      'password' => v::notEmpty()
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

    $auth = Login::where('username', '=', $request->getParam('username'))
                 ->where('password', '=', hash('sha512', $request->getParam('password')))
                 ->exists();

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode($auth, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}