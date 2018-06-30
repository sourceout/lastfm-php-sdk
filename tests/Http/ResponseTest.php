<?php
namespace Sourceout\LastFm\Tests\Http;

use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Http\Response;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_returns_back_collection_as_response()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $this->assertInstanceOf(Collection::class, Response::send($response));
    }

    /** @test */
    public function it_throws_exception_for_unsupported_response_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = Mockery::mock(ResponseInterface::class);
        $this->assertInstanceOf(Collection::class, Response::send($response, 'xml'));
    }
}