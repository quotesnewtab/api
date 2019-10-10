<?php

use Illuminate\Database\Capsule\Manager as DB;

class AnalyticsController extends Controller {

  /**
   * Read all analytics.
   */
  public function read($request, $response) {
    $analytics = array();

    $avg_users_per_day = DB::table('daily_users')
      ->select(DB::raw('DAYNAME(date) as weekday, ROUND(AVG(users), 0) as users'))
      ->groupBy(DB::raw('DAYNAME(date)'))
      ->orderByRaw('(CASE DAYOFWEEK(date) WHEN 1 THEN 7 ELSE DAYOFWEEK(date) END)')
      ->get();

    $country_stats = DB::table('users')
      ->select(DB::raw('country_flag, country_code, country, COUNT(*) as users'))
      ->whereNotNull('country')
      ->groupBy('country')
      ->orderByDesc('users')
      ->get();

    $daily_users = DB::table('daily_users')->get();

    $weekly_users = DB::table('x_requests')
      ->whereRaw('last_request >= (CURDATE() - INTERVAL 7 DAY) AND last_request < CURDATE()')
      ->count();

    $analytics['avgUsersPerDay'] = $avg_users_per_day;
    $analytics['countryStats'] = $country_stats;
    $analytics['dailyUsers'] = $daily_users;
    $analytics['weeklyUsers'] = $weekly_users;

    return $response->withStatus(200)
      ->withHeader("Content-Type", "application/json")
      ->write(json_encode($analytics, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}