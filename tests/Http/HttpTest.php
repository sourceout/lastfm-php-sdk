<?php
namespace Sourceout\LastFm\Tests\Http;

use PHPUnit\Framework\TestCase;
use Sourceout\LastFm\Http\Http;

class HttpTest extends TestCase
{
    /** @test */
    public function it_returns_a_http_client()
    {
        $httpClient = (new Http())->getHttpClient();
        $this->assertTrue($httpClient instanceof \Http\Client\HttpClient);
    }

    /** @test */
    public function it_returns_message_factory()
    {
        $messageFactory = (new Http())->getMessageFactory();
        $this->assertTrue($messageFactory instanceof \Http\Message\MessageFactory);
    }
}