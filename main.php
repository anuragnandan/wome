<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$options = getopt("", ["from:"]);

if(isset($options['from']) || $options['from'] == 'WORK')
  $route = getRoute(getenv('WORK'), getenv('HOUSE'));
else
  $route = getRoute(getenv('HOUSE'), getenv('WORK'));
sendRoute($route);

function getResponse($type = 'GET', $url, $params = array())
{
  $client = new Client();
  try{
    $response = $client->request($type, $url, [
      'query' => $params
    ]);

    return $response;
  }
  catch(Exception $e){
    echo $e->getMessage();
  }
}

function getRoute($origin, $destination)
{
   $params = [
        'origin' => $origin,
        'destination' => $destination,
        'key' => getenv('KEY')
      ];

  $response = getResponse('GET', getenv('URL'), $params);
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

function textRoute($distance = 0, $duration = 0, $wome = array())
{
  $text_route = "Distance: $distance and will take $duration.\n";
  foreach($wome as $turn => $step)
    $text_route .= ($turn + 1).". ".strip_tags($step).".\n";

  return $text_route;
}

function sendRoute($route)
{
  $params = [
    'title' => $route,
    'identifier' => getenv('NOTIFY_KEY')
  ];
  $response = getResponse('GET', getenv('NOTIFY_URL'), $params);
}
?>
