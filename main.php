<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$route = getRoute(getenv('HOUSE'), getenv('WORK'));
echo $route;

function getRoute($origin, $destination)
{
  $client = new Client();
  try{
    $response = $client->request('GET', getenv('URL'), [
      'query' => [
        'origin' => $origin,
        'destination' => $destination,
        'key' => getenv('KEY')
      ]
    ]);

    $body = $response->getBody();
    $body = json_decode($body);

    if($body->status == 'OK')
    {
      $distance = $body->routes[0]->legs[0]->distance->text;
      $duration = $body->routes[0]->legs[0]->duration->text;
      $steps = $body->routes[0]->legs[0]->steps;

      $wome = array();
      foreach($steps as $turn => $step)
      {
        $wome[$turn] = $step->html_instructions;
      }
    }

    return textRoute($distance, $duration, $wome);
  }
  catch(Exception $e){
    echo $e->getMessage();
  }

}

function textRoute($distance = 0, $duration = 0, $wome = array())
{
  $text_route = "Distance: $distance and will take $duration.\n";
  foreach($wome as $turn => $step)
    $text_route .= ($turn + 1).". ".strip_tags($step).".\n";

  return $text_route;
}
?>
