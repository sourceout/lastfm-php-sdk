<?php
namespace Sourceout\LastFm\Providers;

interface ResourceInterface
{
    /**
     * Return back an instance of Geo resource for the provider
     *
     * @return GeoInterface
     */
    public function getGeoResource();
}