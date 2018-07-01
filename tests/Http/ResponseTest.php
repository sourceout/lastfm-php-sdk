<?php
namespace Sourceout\LastFm\Tests\Http;

use Mockery;
use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\Response;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_returns_back_collection_as_response()
    {
        /** @var ResponseInterface $response */
        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive(
            ['getContents' => "{}"]
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

        $this->assertInstanceOf(Collection::class, Response::send($response));
    }

    /** @test */
    public function it_throws_exception_in_case_of_error_response()
    {
        $this->expectException(LastFmException::class);

        /** @var ResponseInterface $response */
        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive(
            ['getContents' => "{\"error\":6,\"message\":\"country param invalid\",\"links\":[]}"]
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

        $this->assertInstanceOf(Collection::class, Response::send($response));
    }

    /** @test */
    public function it_throws_exception_for_unsupported_response_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        /** @var ResponseInterface $response */
        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive(
            ['getContents' => ""]
        );

        /** @var ResponseInterface|mixed $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive(
            [
                'getHeaderLine' => 'application/xml',
                'getStatusCode' => 200,
                'getBody' => $stream
            ]
        );

        $this->assertInstanceOf(Collection::class, Response::send($response));
    }
}