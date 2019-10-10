<?php

use Respect\Validation\Validator as v;

class TokenController extends Controller {

  /**
   * Create new token.
   */
  public function create($request, $response) {
    $validation = $this->validator->validate($request, [
      'token'   => v::notEmpty(),
      'comment' => v::notEmpty()
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

    Token::create([
      'token'   => $request->getParam('token'),
      'comment' => $request->getParam('comment'),
      'admin'   => $request->getParam('admin') ? 1 : 0
    ]);

    return $response->withStatus(201)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Token was successfully created.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Read all tokens.
   */
  public function read($request, $response) {
    $tokens = Token::all();

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($tokens, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Update a token by ID.
   */
  public function update($request, $response, $id) {
    $validation = $this->validator->validate($request, [
      'token'   => v::notEmpty(),
      'comment' => v::notEmpty()
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

    Token::whereId($id)->update([
      'token'   => $request->getParam('token'),
      'comment' => $request->getParam('comment'),
      'admin'   => $request->getParam('admin') ? 1 : 0
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Token was successfully updated.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Delete a token by ID.
   */
  public function delete($request, $response, $id) {
    Token::destroy($id);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Token was successfully deleted.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}