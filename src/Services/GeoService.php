<?php
namespace Sourceout\LastFm\Services;

class GeoService extends AbstractService
{
    /**
     * Get the most popular artists by country
     *
     * @param string $country
     * @param integer $page
     * @param integer $limit
     * @return \Tightenco\Collect\Support\Collection
     */
    public function getTopArtists(
        string $country,
        int $page = 1,
        int $limit = 50
    )
    {
        return $this->provider
            ->getGeoResource()
            ->getTopArtists($country, $page, $limit);
    }

    /**
     * Get the most popular tracks by country
     *
     * @param string $country
     * @param string $location
     * @param integer $limit
     * @param integer $page
     * @return \Tightenco\Collect\Support\Collection
     */
    public function getTopTracks(
        string $country,
        string $location = null,
        int $limit = 50,
        int $page = 1
    ) {
        return $this->provider
            ->getGeoResource()
            ->getTopTracks($country, $location, $limit, $page);
    }
}