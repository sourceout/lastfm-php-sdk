<?php
namespace Sourceout\LastFm\Http;

use Tightenco\Collect\Support\Collection;
use Sourceout\LastFm\Http\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class Response implements ResponseInterface
{
    /** @inheritDoc */
    public static function send(
        PsrResponseInterface $response,
        $type = 'json'
    ) : Collection
    {
        $response = new Collection([]);

        if ($type === 'json') {
            $response = new Collection(json_encode($response, true));
        } else {
            throw new \InvalidArgumentException("Invalid response type {$type}");
        }

        return $response;
    }
}