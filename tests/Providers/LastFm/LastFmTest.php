<?php
namespace Sourceout\LastFm\Tests\Providers\LastFm;

use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\GeoInterface;

class LastFmTest extends TestCase
{
    private $lastFm;

    public function setUp()
    {
        $this->lastFm = new LastFm(['api_key' => 'some_secret_key']);
    }
    /** @test */
    public function is_able_to_update_config()
    {
        $this->assertEquals(['api_key' => 'some_secret_key'], $this->lastFm->getConfig());

        $this->lastFm->setConfig(['api_key' => 'super_secure_secret_key']);
        $this->assertEquals(['api_key' => 'super_secure_secret_key'], $this->lastFm->getConfig());
    }

    /** @test */
    public function is_able_to_update_api_key()
    {
        $this->assertEquals('some_secret_key', $this->lastFm->getApiKey());
        $this->assertEquals(['api_key' => 'some_secret_key'], $this->lastFm->getConfig());

        $this->lastFm->setApiKey('super_secure_secret_key');
        $this->assertEquals('super_secure_secret_key', $this->lastFm->getApiKey());
        $this->assertEquals(['api_key' => 'super_secure_secret_key'], $this->lastFm->getConfig());
    }

    /** @test */
    public function it_returns_provider_name()
    {
        $this->assertEquals('LastFm', $this->lastFm->getProviderName());
    }

    /** @test */
    public function it_returns_the_version_of_the_provider()
    {
        $this->assertEquals('2.0', $this->lastFm->getVersion());
    }

    /** @test */
    public function it_returns_geo_resource()
    {
        $geoResource = $this->lastFm->getGeoResource();
        $this->assertTrue($geoResource instanceof GeoInterface);
    }

    public function tearDown()
    {
        $this->lastFm = null;
    }
}