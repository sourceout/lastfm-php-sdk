<?php
namespace Sourceout\LastFm\Tests\Services;

use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\Http;
use Sourceout\LastFm\Services\ServiceFactory;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Services\AbstractService;
use Sourceout\LastFm\Services\GeoService;

class ServiceFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_geo_service()
    {
        $lastFm = new LastFm(['api_key' => 'dummy_sample_key']);
        $http = new Http();

        $serviceFactory = new ServiceFactory($lastFm, $http);
        $geoService = $serviceFactory->getGeoService();

        $this->assertInstanceOf(GeoService::class, $geoService);
        $this->assertTrue($geoService instanceof AbstractService);
    }
}