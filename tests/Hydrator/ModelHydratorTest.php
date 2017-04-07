<?php

namespace AdamPaterson\ApiClient\Foundation;

use AdamPaterson\ApiClient\Foundation\Contract\CreatableFromArray;
use Mockery as m;
use AdamPaterson\ApiClient\Foundation\Hydrator\ModelHydrator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ModelHydratorTest extends TestCase
{
    private $hydrator;
    private $mockClass;

    public function setUp()
    {
        $this->mockClass = m::mock(\stdClass::class, CreatableFromArray::class);
        $this->hydrator = new ModelHydrator($this->mockClass);
    }

    /**
     * @test
     * @expectedException \AdamPaterson\ApiClient\Foundation\Exception\HydrationException
     */
    public function shouldThrowExceptionIfResponseIsNotJson()
    {
        $body = m::mock(\stdClass::class);
        $body->shouldReceive('__toString')->once()->andReturn("");

        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn($body);
        $response->shouldReceive('getHeaderLine')->once()->andReturn('text/html');

        $this->hydrator->hydrate($response);
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

    /**
     * @test
     */
    public function shouldCreateModelFromArray()
    {
        $mockModel = m::mock('alias:Model\MockModel', CreatableFromArray::class);
        $hydrator = new ModelHydrator($mockModel);

        $body = m::mock(\stdClass::class);
        $body->shouldReceive('__toString')->once()->andReturn('{"first_name": "Adam", "last_name": "Paterson"}');

        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn($body);
        $response->shouldReceive('getHeaderLine')->with('Content-Type')->once()->andReturn('application/json');

        $data = [
            'first_name' => 'Adam',
            'last_name'  => 'Paterson'
        ];

        $mockModel->shouldReceive('createFromArray')->with($data)->andReturnSelf();

        $model = $hydrator->hydrate($response);

        $this->assertInstanceOf(get_class($mockModel), $model);
    }

    /**
     * @test
     */
    public function shouldInstantiateModelWithData()
    {
        $body = m::mock(\stdClass::class);
        $body->shouldReceive('__toString')->once()->andReturn('{"status": "success"}');

        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn($body);
        $response->shouldReceive('getHeaderLine')->once()->with('Content-Type')->andReturn('application/json');

        $hydrator = new ModelHydrator(\stdClass::class);
        $model = $hydrator->hydrate($response);
        $this->assertInstanceOf(\stdClass::class, $model);
    }
}
