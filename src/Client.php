<?php
namespace Sourceout\LastFm;

use Sourceout\LastFm\Services\ServiceFactory;
use Sourceout\LastFm\Providers\ResourcefulProviderInterface;

class Client
{
    private $providers = [
        \Sourceout\LastFm\Providers\LastFm\LastFm::class
    ];

    /**
     * Returns a list of registered providers
     *
     * @return string[]
     */
    public function getRegisteredProviders() : array
    {
        return $this->providers;
    }

    /**
     * Add ability to add new custom providers
     *
     * @param  string ...$providers
     * @return void
     * @throws \InvalidArgumentException
     */
    public function registerCustomProviders(string ...$providers) : void
    {
        foreach($providers as $provider) {
            if (!class_exists($provider)) {
                throw new \InvalidArgumentException(
                    "{$provider} does not exists"
                );
            }
            $this->providers = array_push($this->providers, $provider);
        }
    }

    /**
     * Returns an instance of ServiceFactory
     *
     * @param ResourcefulProviderInterface $provider
     * @return ServiceFactory
     */
    public function getServiceFactory(
        ResourcefulProviderInterface $provider
    ) : ServiceFactory
    {
        return new ServiceFactory($provider);
    }
}