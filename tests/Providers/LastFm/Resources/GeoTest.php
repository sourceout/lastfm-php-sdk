<?php
namespace Sourceout\LastFm\Tests\Providers\LastFm\Resources;

use Mockery;
use Http\Mock\Client;
use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\Http;
use Http\Message\MessageFactory;
use Http\Message\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sourceout\LastFm\Providers\LastFm\LastFm;
use Sourceout\LastFm\Providers\LastFm\Resources\Geo;
use Sourceout\LastFm\Exception\HttpTransferException;
use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

class GeoTest extends TestCase
{
    private $provider;

    private $http;

    public function setUp()
    {
        $this->provider = new LastFm(['api_key' => 'some secret api key']);

        $this->http = new Http();
        $response = Mockery::mock(ResponseFactory::class);
        $client = new Client($response);

        $response = Mockery::mock(ResponseInterface::class, ResponseInterface::class);
        $client->setDefaultResponse($response);

        $request = Mockery::mock(RequestInterface::class, RequestInterface::class);
        $messageFactory = Mockery::mock(MessageFactory::class);
        $messageFactory->shouldReceive([
            'createRequest' => $request
        ]);

        $this->http->setHttpClient($client);
        $this->http->setMessageFactory($messageFactory);
    }

    /** @test */
    public function it_makes_request_for_top_artists()
    {
        $geo = new Geo($this->provider, $this->http);
        $response = $geo->getTopArtists('some country');
        $this->assertInstanceOf(Collection::class, $response);
    }

    /** @test */
    public function it_throws_exception_while_making_request_for_top_artists()
    {
        $this->expectException(LastFmException::class);

        $client = $this->http->getHttpClient();
        $exception = new \Exception("Whoops!!");
        $client->addException($exception);
        $this->http->setHttpClient($client);

        $geo = new Geo($this->provider, $this->http);
        $response = $geo->getTopArtists('some country');
        $this->assertInstanceOf(Collection::class, $response);
    }
    /** @test */
    public function it_makes_request_for_top_tracks()
    {
        $geo = new Geo($this->provider, $this->http);
        $response = $geo->getTopTracks('some country');
        $this->assertInstanceOf(Collection::class, $response);
    }

    /** @test */
    public function it_throws_exception_while_making_request_for_top_tracks()
    {
        $this->expectException(LastFmException::class);

        $client = $this->http->getHttpClient();
        $exception = new \Exception("Whoops!!");
        $client->addException($exception);
        $this->http->setHttpClient($client);

        $geo = new Geo($this->provider, $this->http);
        $response = $geo->getTopTracks('some country');
        $this->assertInstanceOf(Collection::class, $response);
    }
}