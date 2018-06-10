<?php
namespace Sourceout\LastFm\Http;

use Tightenco\Collect\Support\Collection;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseInterface
{
    /**
     * Transforms the response and sends it back
     *
     * @param PsrResponseInterface $response
     * @param string $type
     * @return Collection
     */
    public static function send(
        PsrResponseInterface $response,
        $type
    ) : Collection;
}