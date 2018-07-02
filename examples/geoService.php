<?php
require __DIR__.'/../vendor/autoload.php';

use Sourceout\LastFm\Client;
use Sourceout\LastFm\Providers\LastFm\LastFm;

$provider = new LastFm(['api_key' => 'your_api_key_goes_here']);
$client = new Client();
$topArtists = $client->getServiceFactory($provider)
    ->getGeoService()
    ->getTopArtists('netherlands', 1, 10);
print_r($topArtists->toArray());