<?php

use Respect\Validation\Validator as v;

class QuoteController extends Controller {

  /**
   * Create new quote
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

    Quote::create([
      'author' => $request->getParam('author'),
      'quote' => $request->getParam('quote'),
      'submitter' => $request->getParam('submitter'),
    ]);

    return $response->withStatus(201)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Quote was successfully created.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Read all quotes.
   */
  public function readAll($request, $response) {
    $quotes = Quote::all();

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($quotes, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Read a single quote by ID.
   */
  public function readOne($request, $response, $id) {
    $quote = Quote::whereId($id)->first();

    if (!$quote) {
      return $response->withStatus(404)
          ->withHeader('Content-Type', 'application/json')
          ->write(json_encode(array(
              'error' => 'NOT_FOUND',
              'error_message' => 'No quote was found with the id: '.$id['id'].'.',
              'status_code' => 404,
            ), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));  
    }

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($quote, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /** 
   * Read a random quote.
   */
  public function readRandom($request, $response) {
    $quote = Quote::inRandomOrder()->first();
    Quote::whereId($quote->id)->increment('views');

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode($quote, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
  
  /**
   * Update a quote by ID.
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

    Quote::whereId($id)->update([
      'author' => $request->getParam('author'),
      'quote' => $request->getParam('quote'),
      'submitter' => $request->getParam('submitter'),
    ]);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Quote was successfully updated.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Delete a quote by ID.
   */
  public function delete($request, $response, $id) {
    Quote::destroy($id);

    return $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode(array('message' => 'Quote was successfully deleted.'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}