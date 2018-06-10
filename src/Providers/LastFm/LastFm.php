<?php
namespace Sourceout\LastFm\Providers\LastFm;

use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;
use Sourceout\LastFm\Providers\ResourcefulProviderInterface;

class LastFm implements ResourcefulProviderInterface
{
    /** @var array */
    protected $config;

    /** @var string */
    private $apiKey;

    /** @inheritDoc */
    public function __construct(array $config)
    {
        $this->apiKey = $config["api_key"];
    }

    /** @inheritDoc */
    public function getConfig() : array
    {
        return $this->config;
    }

    /** @inheritDoc */
    public function setConfig(array $config) : void
    {
        $this->config = $config;
    }

    /**
     * Setter for API Key (Provider Specific Method)
     *
     * @param string $apiKey
     * @return void
     */
    public function setApiKey(string $apiKey) : void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Getter for API Key (Provider Specific Method)
     *
     * @return string
     */
    public function getApiKey() : string
    {
        return $this->apiKey;
    }

    /** @inheritDoc */
    public function getVersion() : string
    {
        return '2.0';
    }

    /** @inheritDoc */
    public function getProviderName() : string
    {
        return 'LastFm';
    }

    /** @inheritDoc */
    public function getGeoResource() : GeoInterface
    {
        $http = new Http();
        return new Geo($http, $this->apiKey);
    }
}