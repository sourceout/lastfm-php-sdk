<?php
namespace Sourceout\LastFm\Tests\Services;

use Mockery;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Services\GeoService;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;

class GeoServiceTest extends TestCase
{
    private $provider;

    public function setUp() {
        $this->provider = Mockery::mock(
            LastFm::class,
            ['api_key' => 'secret_api_key']
        );
    }

    /** @test */
    public function it_returns_top_artists_by_country()
    {
        $geoResource = Mockery::mock(Geo::class)->makePartial();
        $geoResource->shouldReceive('getTopArtists')->andReturn('some response');

        $this->provider->shouldReceive('getGeoResource')->andReturn($geoResource);

        $geoService = new GeoService($this->provider);

        $topArtists = $geoService->getTopArtists('united states');
        $this->assertEquals('some response', $topArtists);

        $geoService->setProvider($this->provider);
        $topArtists = $geoService->getTopArtists('united states');
        $this->assertEquals('some response', $topArtists);
    }

    /** @test */
    public function it_returns_top_tracks_by_country()
    {
        $geoResource = Mockery::mock(Geo::class)->makePartial();
        $geoResource->shouldReceive('getTopTracks')->andReturn('some response');

        $this->provider->shouldReceive('getGeoResource')->andReturn($geoResource);

        $geoService = new GeoService($this->provider);

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