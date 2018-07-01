<?php
require __DIR__.'/../vendor/autoload.php';

use Sourceout\LastFm\Client;
use Sourceout\LastFm\Providers\LastFm\LastFm;

$provider = new LastFm(['api_key' => 'd966f2c28ce75500c752e809943eac39']);
// $provider = new LastFm(['api_key' => '966f2c28ce75500c752e809943eac39']);
$client = new Client();
$topArtists = $client->getServiceFactory($provider)
    ->getGeoService()
    ->getTopArtists('india', 1, 10);
print_r($topArtists->toArray());