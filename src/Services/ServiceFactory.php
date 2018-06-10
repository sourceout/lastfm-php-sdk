<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Providers\ProviderInterface;

class ServiceFactory
{
    /** @var ProviderInterface */
    private $provider;

    /** @var HttpInterface */
    private $http;

    /**
     * Constructor method for the client
     *
     * @param ProviderInterface $provider
     * @param HttpInterface $http
     */
    public function __construct(ProviderInterface $provider, HttpInterface $http)
    {
        $this->provider = $provider;
        $this->http = $http;
    }

    /**
     * Return an instance of GeoService for the Provider
     *
     * @return GeoService
     */
    public function getGeoService() : GeoService
    {
        return new GeoService($this->provider, $this->http);
    }
}