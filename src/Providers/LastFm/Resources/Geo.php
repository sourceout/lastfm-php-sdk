<?php
namespace Sourceout\LastFm\Providers\LastFm\Resources;

use Sourceout\LastFm\Http\Response;
use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

class Geo implements GeoInterface
{
    public const TOP_ARTISTS_URI = "http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists";
    public const TOP_TRACKS_URI = "http://ws.audioscrobbler.com/2.0/?method=geo.gettoptracks";

    /** @var HttpInterface */
    private $http;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $format;

    /**
     * Constructor for Geo Class
     *
     * @param HttpInterface $http
     * @param string $apiKey
     * @param string $format
     * @todo Support for $format is yet not enabled, add that in future
     */
    public function __construct(HttpInterface $http, string $apiKey, $format = 'json')
    {
        $this->http = $http;
        $this->apiKey = $apiKey;
        $this->format = $format;
    }

    /** @inheritDoc */
    public function getTopArtists(
        string $country,
        int $page = 1,
        int $limit = 50
    ) {
        try {
            $response = $this->http->sendRequest(
                'GET',
                Geo::TOP_ARTISTS_URI,
                [
                    'api_key' => $this->apiKey,
                    'country' => $country,
                    'limit' => $limit,
                    'page' => $page,
                    'format' => 'json'
                ]
            );

            return Response::send($response);
        } catch (\Exception $e) {
            throw new LastFmException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /** @inheritDoc */
    public function getTopTracks(
        string $country,
        string $location = null,
        int $limit = 50,
        int $page = 1
    ) {
        try {
            $response = $this->http->sendRequest(
                'GET',
                Geo::TOP_TRACKS_URI,
                [
                    'api_key' => $this->apiKey,
                    'country' => $country,
                    'location' => $location,
                    'limit' => $limit,
                    'page' => $page,
                    'format' => 'json'
                ]
            );
            return Response::send($response);
        } catch (\Exception $e) {
            throw new LastFmException($e->getMessage(), $e->getCode(), $e);
        }
    }
}