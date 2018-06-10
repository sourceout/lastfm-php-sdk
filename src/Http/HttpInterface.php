<?php
namespace Sourceout\LastFm\Http;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;

interface HttpInterface
{
    /**
     * Sends the request and returns the response from the provider
     *
     * @param string $method
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return ResponseInterface;
     */
    public function sendRequest(
        string $method,
        $uri,
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ) : ResponseInterface;

    /**
     * Setter method for Http Client
     *
     * @param HttpClient $httpClient
     * @return void
     */
    public function setHttpClient(HttpClient $httpClient) : void;

    /**
     * Getter method for Http Client
     *
     * @return HttpClient
     */
    public function getHttpClient() : HttpClient;

    /**
     * Setter for Message Factory
     *
     * @param MessageFactory $messageFactory
     * @return void
     */
    public function setMessageFactory(MessageFactory $messageFactory) : void;

    /**
     * Getter for Message Factory
     *
     * @return MessageFactory
     */
    public function getMessageFactory() : MessageFactory;
}