<?php
namespace Sourceout\LastFm\Tests\Http;

use Mockery;
use Http\Mock\Client;
use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\Http;
use Http\Message\MessageFactory;
use Http\Message\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sourceout\LastFm\Exception\HttpTransferException;
use PHPUnit\Framework\ExpectationFailedException;

class HttpTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new Http();
        /** @var ResponseFactory $response */
        $response = Mockery::mock(ResponseFactory::class);
        $client = new Client($response);

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $client->setDefaultResponse($response);

        /** @var RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class);

        /** @var MessageFactory|mixed $messageFactory */
        $messageFactory = Mockery::mock(
            MessageFactory::class, MessageFactory::class);

        $messageFactory->shouldReceive([
                'createRequest' => $request
        ]);

        $this->http->setHttpClient($client);

        $this->http->setMessageFactory($messageFactory);
    }

    /** @test */
    public function it_returns_a_http_client()
    {
        $httpClient = $this->http->getHttpClient();
        $this->assertTrue($httpClient instanceof HttpClient);
    }

    /** @test */
    public function it_returns_message_factory()
    {
        $messageFactory = $this->http->getMessageFactory();
        $this->assertTrue($messageFactory instanceof MessageFactory);
    }

    /** @test */
    public function it_sends_out_a_request()
    {
        $response = $this->http->sendRequest(
            'GET',
            'http://example.com'
        );
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /** @test */
    public function it_throws_exception_in_case_of_failed_request()
    {
        $this->expectException(HttpTransferException::class);

        $client = $this->http->getHttpClient();
        $exception = new \Exception("Whoops!!");
        $client->addException($exception);
        $this->http->setHttpClient($client);

        $response = $this->http->sendRequest(
            'GET',
            'http://example.com'
        );

    }
}