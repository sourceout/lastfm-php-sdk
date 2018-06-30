<?php
namespace Sourceout\LastFm\Tests;

use Mockery;
use Sourceout\LastFm\Client;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\ProviderInterface;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;
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

        $resource = Mockery::mock(Geo::class)->makePartial();

        // An anonymous class that is not a valid provider type
        $provider =
            (new class ($resource) implements ProviderInterface
            {
                public $property;

                public function __construct($resource)
                {
                    $this->property = $resource;
                }

                public function getConfig() : array
                {
                    return [];
                }

                public function setConfig(array $config) : void
                {

                }

                public function getVersion() : string
                {
                    return '2.0';
                }

                public function getProviderName() : string
                {
                    return 'Mock Provider';
                }

                public function getResource()
                {
                    return $this->property;
                }
            });
        $serviceFactory = $client->getServiceFactory($provider);
    }
}