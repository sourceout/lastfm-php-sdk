<?php
namespace Sourceout\LastFm;

use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Services\ServiceFactory;
use Sourceout\LastFm\Providers\ResourceInterface;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Exception\ProviderDoesNotExistException;
use Sourceout\LastFm\Exception\UnregisteredProviderException;
use Sourceout\LastFm\Exception\IncomptabileProviderTypeException;

class Client
{
    /** @var string[] a list of default providers */
    private $providers = [
        \Sourceout\LastFm\Providers\LastFm\LastFm::class
    ];

    private $providerInterfaces = [
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
     * @throws ProviderDoesNotExistsException
     * @throws IncomptabileProviderTypeException
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
                        $this->providerInterfaces,
                        class_implements($provider)
                    ) == $this->providerInterfaces
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
     * @throws UnregisteredProviderException
     */
    public function getServiceFactory(
        ResourceInterface $provider
    ) : ServiceFactory
    {
        $class = get_class($provider);
        if (! in_array($class, $this->getRegisteredProviders() )) {
            throw new UnregisteredProviderException(
                "Provider {$class} is not registered"
            );
        }
        return new ServiceFactory($provider);
    }
}