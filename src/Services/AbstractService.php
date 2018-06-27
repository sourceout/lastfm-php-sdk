<?php
namespace Sourceout\LastFm\Services;

use Sourceout\LastFm\Providers\ResourceInterface;

abstract class AbstractService
{
    /** @var ResourceInterface */
    protected $provider;

    /**
     * constructor for the service
     *
     * @param ResourceInterface $provider
     */
    public function __construct(ResourceInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * set the provider for the service
     *
     * @param ResourceInterface $provider
     * @return void
     */
    public function setProvider(ResourceInterface $provider) : void
    {
        $this->provider = $provider;
    }
}