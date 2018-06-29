<?php
namespace Sourceout\LastFm\Http;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Psr\Http\Message\ResponseInterface;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Client\Exception\TransferException;
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
        } catch (TransferException $e) {
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
        if ($this->httpClient === null) {
            $this->httpClient = HttpClientDiscovery::find();
        }

        return $this->httpClient;
    }

    /**
     * Setter for Message Factory
     *
     * @param MessageFactory $messageFactory
     * @return void
     */
    public function setMessageFactory(MessageFactory $messageFactory) : void
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * Getter for Message Factory
     *
     * @return MessageFactory
     */
    public function getMessageFactory() : MessageFactory
    {
        if ($this->messageFactory === null) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }
        return $this->messageFactory;
    }
}