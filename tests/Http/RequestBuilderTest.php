<?php

namespace AdamPaterson\ApiClient\Foundation\Http;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RequestBuilderTest extends TestCase
{
    public function testCreate()
    {
        $builder = new RequestBuilder();
        $request = $builder->create('GET', 'path');

        $this->assertInstanceOf(RequestInterface::class, $request);
    }
}
