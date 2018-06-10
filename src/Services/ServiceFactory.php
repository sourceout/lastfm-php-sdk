<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ResourcefulProviderInterface;

class ServiceFactory
{
    /** @var ResourcefulProviderInterface */
    private $provider;

    /**
     * Constructor method for the client
     *
     * @param ResourcefulProviderInterface $provider
     */
    public function __construct(ResourcefulProviderInterface $provider)
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