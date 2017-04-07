<?php

namespace AdamPaterson\ApiClient\Foundation;

use AdamPaterson\ApiClient\Foundation\Api\AbstractApi;
use AdamPaterson\ApiClient\Foundation\Http\ClientBuilder;
use Http\Client\Common\PluginClient;
use Http\Client\Curl\Client;
use Http\Discovery\HttpClientDiscovery;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class ApiClientTest extends TestCase
{
    private $apiClient;

    public function setUp()
    {
        $client = HttpClientDiscovery::find();
        $this->apiClient = new ApiClient($client);
    }

    public function testConfigureClient()
    {
        $clientBuilder = m::mock(ClientBuilder::class, [new Client()])->makePartial();
        $this->assertInstanceOf(ApiClient::class, ApiClient::configure($clientBuilder));
    }

    public function testCreateClient()
    {
        $this->assertInstanceOf(ApiClient::class, ApiClient::create());
    }
}
