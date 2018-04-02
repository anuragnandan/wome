<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

getRoute(getenv('HOUSE'), getenv('WORK'));

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

  }
  catch(Exception $e){
    echo $e->getMessage();
  }

}
?>
