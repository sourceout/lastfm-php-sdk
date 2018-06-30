<?php
namespace Sourceout\LastFm\Tests\Providers\LastFm\Resources;

use Mockery;
use Sourceout\LastFm\Http\Http;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Providers\GeoInterface;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\LastFm\Resources\Resource;

class ResourceTest extends TestCase
{
    /** @test */
    public function it_returns_instance_of_geo_resource()
    {
        $provider = new LastFm(['api_key' => 'some key']);
        $http = new Http();
        $resource = new Resource($provider, $http);
        $geo = $resource->geo();

        $this->assertInstanceOf(GeoInterface::class, $geo);
    }
}