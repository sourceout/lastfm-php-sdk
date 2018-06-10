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
use Psr\Http\Message\StreamInterface;
use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Exception\HttpTransferException;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

class GeoTest extends TestCase
{
    private $provider;

    private $http;

    public function setUp()
    {
        $this->provider = new LastFm(['api_key' => 'some secret api key']);

        $this->http = new Http();
        /** @var ResponseFactory $response */
        $response = Mockery::mock(ResponseFactory::class);
        $client = new Client($response);

        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive(
            ['getContents' => ""]
        );

        /** @var ResponseInterface|mixed $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive(
            [
                'getHeaderLine' => 'application/json',
                'getStatusCode' => 200,
                'getBody' => $stream
            ]
        );

        $client->setDefaultResponse($response);

        /** @var RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, RequestInterface::class);

        /** @var MessageFactory|mixed $messageFactory */
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
        $response = $geo->getTopTracks('some_country');
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