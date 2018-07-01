<?php
namespace Sourceout\LastFm\Http;

use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Http\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

class Response implements ResponseInterface
{
    /** @inheritDoc */
    public static function send(
        PsrResponseInterface $response
    ) : Collection
    {
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') !== false) {
            $contents = json_decode($response->getBody()->getContents(), true);
            if (
                ($response->getStatusCode() === 200)
                && ! isset($contents['error'])
            ) {
                return new Collection($contents);
            } else {
                $code = isset($contents['error'])?$contents['error']:0;
                $message = isset($contents['message'])?$contents['message']:'';
                throw new LastFmException($message, $code);
            }
        } else {
            $responseType = $response->getHeaderLine('Content-Type');
            throw new \InvalidArgumentException("Invalid response type {$responseType}");
        }
    }
}