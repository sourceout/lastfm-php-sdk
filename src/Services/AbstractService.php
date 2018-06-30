<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ProviderInterface;

abstract class AbstractService
{
    /** @var ProviderInterface */
    protected $provider;

    /**
     * constructor for the service
     *
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
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