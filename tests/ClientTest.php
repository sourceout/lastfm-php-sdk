<?php
namespace Sourceout\LastFm\Tests;

use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Client;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\ResourceInterface;
use Sourceout\LastFm\Exception\ProviderDoesNotExistException;
use Sourceout\LastFm\Exception\IncomptabileProviderTypeException;
use Sourceout\LastFm\Exception\UnregisteredProviderException;

/**
 * @group unit
 * @group default
 */
class ClientTest extends TestCase
{
    /** @test */
    public function it_returns_a_list_of_registered_providers()
    {
        $client = new Client();
        $defaultProviders = [
            \Sourceout\LastFm\Providers\LastFm\LastFm::class
        ];
        $providers = $client->getRegisteredProviders();
        foreach($providers as $provider) {
            $this->assertTrue(
                in_array($provider, $defaultProviders)
            );
        }
    }

    /** @test */
    public function it_registers_custom_provider()
    {
        $client = new Client();

        $defaultProviders = [
             \Sourceout\LastFm\Providers\LastFm\LastFm::class
        ];

        $client->registerCustomProviders(
            [
                \Sourceout\LastFm\Providers\LastFm\LastFm::class
            ]
        );

        $providers = $client->getRegisteredProviders();
        foreach($providers as $provider) {
            $this->assertTrue(
                in_array($provider, $defaultProviders)
            );
        }
    }

    /** @test */
    public function it_returns_exception_in_case_of_non_existing_provider()
    {
        $this->expectException(ProviderDoesNotExistException::class);

        $client = new Client();

        $defaultProviders = [
             \Sourceout\LastFm\Providers\LastFm\LastFm::class
        ];

        $client->registerCustomProviders(
            [
                'Foo\Bar::class'
            ]
        );

        $providers = $client->getRegisteredProviders();
        foreach($providers as $provider) {
            $this->assertTrue(
                in_array($provider, $defaultProviders)
            );
        }
    }

    /** @test */
    public function it_throws_exception_in_case_of_incompatible_provider()
    {
        $this->expectException(IncomptabileProviderTypeException::class);

        $client = new Client();

        $defaultProviders = [
            \Sourceout\LastFm\Providers\LastFm\LastFm::class
        ];

        $anonymousClass = get_class(
            new class('argument') {
                public $property;
                public function __construct($argument)
                {
                    $this->property = $argument;
                }
            }
        );
        $client->registerCustomProviders(
            [
                $anonymousClass
            ]
        );

        $providers = $client->getRegisteredProviders();
        foreach ($providers as $provider) {
            $this->assertTrue(
                in_array($provider, $defaultProviders)
            );
        }

    }

    /** @test */
    public function it_returns_an_instance_of_service_factory()
    {
        $client = new Client();
        $lastFm = new LastFm(['api_key' => 'dummy_sample_key']);
        $serviceFactory = $client->getServiceFactory($lastFm);
        $this->assertInstanceOf(
            \Sourceout\LastFm\Services\ServiceFactory::class,
            $serviceFactory
        );
    }

    /** @test */
    public function it_throws_exception_in_case_of_unregistered_provider()
    {
        $this->expectException(UnregisteredProviderException::class);

        $client = new Client();

        // An anonymous class that is not a valid provider type
        $provider =
            (new class ('argument') implements ResourceInterface
            {
                public $property;
                public function __construct($argument)
                {
                    $this->property = $argument;
                }

                public function getGeoResource() {
                    return '';
                }
            });
        $serviceFactory = $client->getServiceFactory($provider);
    }
}