<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ProviderInterface;

class ServiceFactory
{
    /** @var ProviderInterface */
    private $provider;

    /**
     * Constructor method for the client
     *
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Return an instance of GeoService for the Provider
     *
     * @return GeoService
     */
    public function getGeoService() : GeoService
    {
        return new GeoService($this->provider);
    }
}