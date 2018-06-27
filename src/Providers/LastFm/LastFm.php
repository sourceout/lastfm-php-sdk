<?php
namespace Sourceout\LastFm\Providers\LastFm;

use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Providers\ResourceInterface;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;

class LastFm implements ProviderInterface, ResourceInterface
{
    /** @var array */
    protected $config;

    /** @inheritDoc */
    public function __construct(array $config)
    {
        $this->config = $config;
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
        $this->config['api_key'] = $apiKey;
    }

    /**
     * Getter for API Key (Provider Specific Method)
     *
     * @return string
     */
    public function getApiKey() : string
    {
        return $this->config['api_key'];
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
        return new Geo($this, $http);
    }
}