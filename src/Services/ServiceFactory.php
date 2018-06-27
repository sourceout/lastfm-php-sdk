<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ResourceInterface;

class ServiceFactory
{
    /** @var ResourceInterface */
    private $provider;

    /**
     * Constructor method for the client
     *
     * @param ResourceInterface $provider
     */
    public function __construct(ResourceInterface $provider)
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