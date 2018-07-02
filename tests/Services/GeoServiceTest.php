<?php
namespace Sourceout\LastFm\Tests\Services;

use Mockery;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\HttpInterface;
use Sourceout\LastFm\Services\GeoService;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;
use Sourceout\LastFm\Providers\LastFm\Resources\Resource;

class GeoServiceTest extends TestCase
{
    private $provider;

    private $http;

    public function setUp() {
        $this->provider = Mockery::mock(
            LastFm::class,
            ['api_key' => 'secret_api_key']
        )->makePartial();

        $this->http = Mockery::mock(HttpInterface::class);
    }

    /** @test */
    public function it_returns_top_artists_by_country()
    {
        $geo = Mockery::mock(Geo::class)->makePartial();
        $geo->shouldReceive(['getTopArtists' => 'some response']);

        $resource = Mockery::mock(Resource::class)->makePartial();
        $resource->shouldReceive(['geo' => $geo]);

        $this->provider->shouldReceive('getResource')->andReturn($resource);

        $geoService = new GeoService($this->provider, $this->http);

        $topArtists = $geoService->getTopArtists('united states');
        $this->assertEquals('some response', $topArtists);

        $geoService->setProvider($this->provider);
        $topArtists = $geoService->getTopArtists('united states');
        $this->assertEquals('some response', $topArtists);
    }

    /** @test */
    public function it_returns_top_tracks_by_country()
    {
        $geo = Mockery::mock(Geo::class)->makePartial();
        $geo->shouldReceive(['getTopTracks' => 'some response']);

        $resource = Mockery::mock(Resource::class)->makePartial();
        $resource->shouldReceive(['geo' => $geo]);

        $this->provider->shouldReceive('getResource')->andReturn($resource);

        $geoService = new GeoService($this->provider, $this->http);

        $topArtists = $geoService->getTopTracks('united states');
        $this->assertEquals('some response', $topArtists);

        $geoService->setProvider($this->provider);
        $topArtists = $geoService->getTopTracks('united states');
        $this->assertEquals('some response', $topArtists);
    }

    public function tearDown()
    {
        $this->provider = null;
    }
}