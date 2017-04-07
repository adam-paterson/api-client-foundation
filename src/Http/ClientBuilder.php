<?php

declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation\Http;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;

/**
 * Class ClientBuilder
 *
 * @package AdamPaterson\ApiClient\Foundation\Http
 */
class ClientBuilder
{
    /**
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * @var \Http\Message\UriFactory
     */
    private $uriFactory;

    /**
     * @var array
     */
    private $prependPlugins = [];

    /**
     * @var array
     */
    private $appendPlugins = [];

    /**
     * ClientBuilder constructor.
     *
     * @param \Http\Client\HttpClient|null  $httpClient
     * @param \Http\Message\UriFactory|null $uriFactory
     */
    public function __construct(HttpClient $httpClient = null, UriFactory $uriFactory = null)
    {
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?? UriFactoryDiscovery::find();
    }

    /**
     * @return \Http\Client\HttpClient
     */
    public function createConfiguredClient(): HttpClient
    {
        $plugins = $this->prependPlugins;

        return new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));
    }

    /**
     * @param \Http\Client\Common\Plugin[] ...$plugin
     *
     * @return \AdamPaterson\ApiClient\Foundation\Http\ClientBuilder
     */
    public function appendPlugin(Plugin ...$plugin): ClientBuilder
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param \Http\Client\Common\Plugin[] ...$plugin
     *
     * @return \AdamPaterson\ApiClient\Foundation\Http\ClientBuilder
     */
    public function prependPlugin(Plugin ...$plugin): ClientBuilder
    {
        $plugin = array_reverse($plugin);
        foreach ($plugin as $p) {
            array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}
