<?php

namespace AdamPaterson\ApiClient\Foundation\Api;

use AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface;
use AdamPaterson\ApiClient\Foundation\Http\RequestBuilder;
use GuzzleHttp\Psr7\Response;
use Http\Message\ResponseFactory;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;

class AbstractApiTest extends TestCase
{
    private $api;

    public function setUp()
    {
        $httpClient = new Client();
        $hydrator = m::mock(HydratorInterface::class);
        $requestBuilder = new RequestBuilder();
        $this->api = m::mock(AbstractApi::class, [$httpClient, $hydrator, $requestBuilder])->makePartial();
    }

    public function testGet()
    {
        $response = $this->api->get('path', ['param' => 'adam']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testPost()
    {
        $response = $this->api->post('path', ['param' => 'adam']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testPut()
    {
        $response = $this->api->put('path', ['param' => 'adam']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testPatch()
    {
        $response = $this->api->patch('path', ['param' => 'adam']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testDelete()
    {
        $response = $this->api->delete('path', ['param' => 'adam']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
