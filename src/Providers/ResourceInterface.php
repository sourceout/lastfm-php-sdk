<?php
namespace Sourceout\LastFm\Providers;

interface ResourceInterface
{
    /**
     * Returns back an instance of Geo Resource
     *
     * @return GeoInterface
     */
    public function geo() : GeoInterface;
}