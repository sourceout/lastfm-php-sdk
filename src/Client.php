<?php
namespace Sourceout\LastFm;

use Sourceout\LastFm\Services\ServiceFactory;
use Sourceout\LastFm\Providers\ResourceInterface;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Exception\ProviderDoesNotExistException;
use Sourceout\LastFm\Exception\IncomptabileProviderTypeException;
use Sourceout\LastFm\Providers\GeoInterface;

class Client
{
    /** @var string[] a list of default providers */
    private $providers = [
        \Sourceout\LastFm\Providers\LastFm\LastFm::class
    ];

    private $providerImplements = [
        \Sourceout\LastFm\Providers\ProviderInterface::class,
        \Sourceout\LastFm\Providers\ResourceInterface::class,
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
     * @param  array $providers
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function registerCustomProviders(array $providers) : void
    {
        foreach($providers as $provider) {
            if (!class_exists($provider)) {
                throw new ProviderDoesNotExistException(
                    "Provider {$provider} does not exists"
                );
            } else if (
                ! (array_intersect(
                        $this->providerImplements,
                        class_implements($provider)
                    ) == $this->providerImplements
                )
            ) {
                throw new IncomptabileProviderTypeException(
                    "Provider {$provider} is not compatible"
                );
            }
            array_push($this->providers, $provider);
        }
    }

    /**
     * Returns an instance of ServiceFactory
     *
     * @param ResourceInterface $provider
     *
     * @return ServiceFactory
     */
    public function getServiceFactory(
        ResourceInterface $provider
    ) : ServiceFactory
    {
        if (
            $provider instanceof ResourceInterface
            && $provider instanceof ProviderInterface
        ) {
            return new ServiceFactory($provider);
        }
        throw new IncomptabileProviderTypeException(
            "Provider ".  get_class($provider) ." is not compatible"
        );
    }
}