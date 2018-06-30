<?php
namespace Sourceout\LastFm\Providers;

interface ProviderInterface
{
    /**
     * Setter for the config
     *
     * @param array $config
     * @return void
     */
    public function setConfig(array $config) : void;

    /**
     * Getter for the config
     *
     * @return array
     */
    public function getConfig() : array;

    /**
     * Returns the API (Current) Version of the provider
     *
     * @return string
     */
    public function getVersion() : string;

    /**
     * Returns the name of the provider
     *
     * @return string
     */
    public function getProviderName() : string;

    /**
     * Returns back an instance of Resource Factory
     *
     * @return ResourceInterface
     */
    public function getResource();
}