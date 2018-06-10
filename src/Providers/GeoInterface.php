<?php
namespace Sourceout\LastFm\Providers;

use Sourceout\LastFm\Providers\LastFm\Exception\LastFmException;

interface GeoInterface
{
    /**
     * Get the most popular artists by country
     *
     * @param string $country
     * @param integer $page
     * @param integer $limit
     * @return mixed
     * @throws LastFmException
     */
    public function getTopArtists(string $country, int $page = 1, int $limit = 50);

    /**
     * Get the most popular tracks by country
     *
     * @param string $country
     * @param string $location
     * @param integer $limit
     * @param integer $page
     * @return mixed
     * @throws LastFmException
     */
    public function getTopTracks(string $country, string $location = null, int $limit = 50, int $page = 1);
}