<?php
namespace Sourceout\LastFm\Http;

use Tightenco\Collect\Support\Collection;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

interface ResponseInterface
{
    /**
     * Transforms the response and sends it back
     *
     * @param PsrResponseInterface $response
     * @return Collection
     * @throws LastFmException
     * @throws \InvalidArgumentException
     */
    public static function send(
        PsrResponseInterface $response
    ) : Collection;
}