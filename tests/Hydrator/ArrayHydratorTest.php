<?php

namespace AdamPaterson\ApiClient\Foundation;

use AdamPaterson\ApiClient\Foundation\Hydrator\ArrayHydrator;
use Psr\Http\Message\ResponseInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ArrayHydratorTest extends TestCase
{
    private $hydrator;

    public function setUp()
    {
        $this->hydrator = new ArrayHydrator;
    }

    /**
     * @test
     * @expectedException \AdamPaterson\ApiClient\Foundation\Exception\HydrationException
     */
    public function shouldThrowExceptionIfResponseIsNotJson()
    {
        $body = m::mock(\stdClass::class)->makePartial();
        $body->shouldReceive('__toString')->andReturn('Some Body');

        $response = m::mock(ResponseInterface::class)->makePartial();
        $response->shouldReceive('getHeaderLine')->with('Content-Type')->andReturn('text/html');
        $response->shouldReceive('getBody')->once()->andReturn($body);

        $this->hydrator->hydrate($response);
    }

    /**
     * @test
     */
    public function shouldHydrateJsonResponse()
    {
        $body = m::mock(\stdClass::class);
        $body->shouldReceive('__toString')->once()->andReturn('{"status":"success"}');

        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn($body);
        $response->shouldReceive('getHeaderLine')->with('Content-Type')->andReturn('application/json');

        $expected = ['status' => 'success'];
        $this->assertSame($expected, $this->hydrator->hydrate($response));
    }

    /**
     * @test
     * @expectedException \AdamPaterson\ApiClient\Foundation\Exception\HydrationException
     */
    public function shouldThrowErrorWhenUnableToDecodeJson()
    {
        $body = m::mock(\stdClass::class);
        $body->shouldReceive('__toString')->once()->andReturn('{status: success}');

        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn($body);
        $response->shouldReceive('getHeaderLine')->with('Content-Type')->once()->andReturn('application/json');

        $this->hydrator->hydrate($response);
    }
}
