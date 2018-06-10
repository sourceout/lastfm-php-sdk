<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ResourcefulProviderInterface;

abstract class AbstractService
{
    /** @var ResourcefulProviderInterface */
    protected $provider;

    /**
     * constructor for the service
     *
     * @param ResourcefulProviderInterface $provider
     */
    public function __construct(ResourcefulProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * set the provider for the service
     *
     * @param ResourcefulProviderInterface $provider
     * @return void
     */
    public function setProvider(ResourcefulProviderInterface $provider) : void
    {
        $this->provider = $provider;
    }
}