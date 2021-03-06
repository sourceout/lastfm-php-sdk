<?php
namespace Sourceout\LastFm\Providers\LastFm;

use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Providers\ResourceInterface;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;
use Sourceout\LastFm\Providers\LastFm\Resources\Resource;

class LastFm implements ProviderInterface
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
    public function getResource(HttpInterface $http)
    {
        return new Resource($this, $http);
    }
}