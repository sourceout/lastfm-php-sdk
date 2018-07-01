<?php
namespace Sourceout\LastFm\Http;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;
use Sourceout\LastFm\Exception\HttpTransferException;

class Http implements HttpInterface
{

    /** @var HttpClient */
    private $httpClient;

    /** @var MessageFactory */
    private $messageFactory;

    /**
     * @inheritDoc
     */
    public function sendRequest(
        string $method,
        string $uri,
        $body = null,
        array $headers = [],
        string $protocolVersion = '1.1'
    ) : ResponseInterface
    {
        $request = $this->getMessageFactory()->createRequest($method, $uri, $headers, $body, $protocolVersion);
        try {
            return $this->getHttpClient()->sendRequest($request);
        } catch (\Exception $e) {
            throw new HttpTransferException(
                "Error while requesting data".$e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function setHttpClient(HttpClient $httpClient) : void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function getHttpClient() : HttpClient
    {
        $this->httpClient = $this->httpClient ?: HttpClientDiscovery::find();
        return $this->httpClient;
    }

    /**
     * @inheritDoc
     */
    public function setMessageFactory(MessageFactory $messageFactory) : void
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @inheritDoc
     */
    public function getMessageFactory() : MessageFactory
    {
        $this->messageFactory = $this->messageFactory ?: MessageFactoryDiscovery::find();
        return $this->messageFactory;
    }
}