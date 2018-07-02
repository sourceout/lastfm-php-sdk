<?php
namespace Sourceout\LastFm\Providers\LastFm\Resources;

use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Providers\ResourceInterface;

class Resource implements ResourceInterface
{
    /** @var ProviderInterface */
    private $provider;

    /** @var HttpInterface */
    private $http;

    /**
     * Constructor
     *
     * @param ProviderInterface $provider
     * @param HttpInterface $http
     */
    public function __construct(
        ProviderInterface $provider,
        HttpInterface $http
    ) {
        $this->provider = $provider;
        $this->http = $http;
    }

    /**
     * Returns back an instance of LastFM Geo Resource
     *
     * @return GeoInterface
     */
    public function geo() : GeoInterface
    {
        return new Geo($this->provider, $this->http);
    }
}