<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Providers\ProviderInterface;

abstract class AbstractService
{
    /** @var ProviderInterface */
    protected $provider;

    /** @var HttpInterface */
    protected $http;

    /**
     * constructor for the service
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
     * set the provider for the service
     *
     * @param ProviderInterface $provider
     * @return void
     */
    public function setProvider(ProviderInterface $provider) : void
    {
        $this->provider = $provider;
    }
}