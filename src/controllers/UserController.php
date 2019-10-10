<?php

class UserController extends Controller {

  /**
   * Read all users.
   */
  public function read($request, $response, $page) {
    if ($page === NULL) { $page['page'] = 1; }

    $country = $request->getQueryParam('country') === 'null' ? null : $request->getQueryParam('country');
    $city    = $request->getQueryParam('city')    === 'null' ? null : $request->getQueryParam('city');
    $orderBy = $request->getQueryParam('orderBy') ? $request->getQueryParam('orderBy') : 'id';
    $order   = $request->getQueryParam('order')   ? $request->getQueryParam('order')   : 'asc';
    
    if ($order === 'asc') {
      $users = User::when($country, function ($query, $country) {
        return $query->where('country', $country);
      })->when($city, function ($query, $city) {
        return $query->where('city', $city);
      })->when($orderBy, function ($query, $orderBy) {
        return $query->orderBy($orderBy, 'asc');
      })->paginate(25, ['*'], 'page', $page['page']);
    } else {
      $users = User::when($country, function ($query, $country) {
        return $query->where('country', $country);
      })->when($city, function ($query, $city) {
        return $query->where('city', $city);
      })->when($orderBy, function ($query, $orderBy) {
        return $query->orderBy($orderBy, 'desc');
      })->paginate(25, ['*'], 'page', $page['page']);
    }
    
    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($users, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Get all countries for filter purposes.
   */
  public function countries($request, $response) {
    $countries = User::select('country')
      ->whereNotNull('country')
      ->groupBy('country')
      ->get();

    $countries = array_map(function($country) { return $country['country']; }, $countries->toArray());

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($countries, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }

  /**
   * Get all cities for a given country for filter purposes.
   */
  public function cities($request, $response, $country) {
    $cities = User::select('city')
      ->where('country', $country)
      ->groupBy('city')
      ->get();

    $cities = array_map(function($city) { return $city['city']; }, $cities->toArray());

    return $response->withStatus(200)
    ->withHeader("Content-Type", "application/json")
    ->write(json_encode($cities, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}