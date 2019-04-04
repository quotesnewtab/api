<?php

use Respect\Validation\Validator as v;

class SubmissionController extends Controller {

  /**
   * Create new submission
   */
  public function create($request, $response) {
    $validation = $this->validator->validate($request, [
      'author' => v::notEmpty(),
      'quote' => v::notEmpty()
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

    Submission::create([
      'author' => $request->getParam('author'),
      'quote' => $request->getParam('quote'),
      'submitted_by' => $request->getParam('submitted_by'),
      'ip' => $this->getIP()
    ]);

    return $response->withStatus(201)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Submission was successfully created.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Read all submissions.
   */
  public function read($request, $response) {
    $submissions = Submission::all();

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($submissions, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
  
  /**
   * Update a submission by ID.
   */
  public function update($request, $response, $id) {
    $validation = $this->validator->validate($request, [
      'author' => v::notEmpty(),
      'quote' => v::notEmpty()
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

    Submission::whereId($id)->update([
      'author' => $request->getParam('author'),
      'quote' => $request->getParam('quote'),
      'submitted_by' => $request->getParam('submitted_by'),
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Submission was successfully updated.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Delete a submission by ID.
   */
  public function delete($request, $response, $id) {
    Submission::destroy($id);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Submission was successfully deleted.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
  
  /**
   * Accept a submission by ID.
   */
  public function accept($request, $response, $id) {
    Submission::whereId($id)->update([
      'accepted' => true
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Submission was accepted.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
  
  /**
   * Decline a submission by ID.
   */
  public function decline($request, $response, $id) {
    Submission::whereId($id)->update([
      'accepted' => false
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Submission was declined.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
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