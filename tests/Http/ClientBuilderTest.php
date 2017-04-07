<?php

namespace AdamPaterson\ApiClient\Foundation\Http;

use Http\Client\Common\Plugin;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class ClientBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAcceptVariableArgumentLengthPlugins()
    {
        $p1 = m::mock(Plugin::class);
        $p2 = m::mock(Plugin::class);
        $p3 = m::mock(Plugin::class);

        $clientBuilder = new ClientBuilder();
        $this->assertSame($clientBuilder, $clientBuilder->prependPlugin($p1, $p2, $p3));
        $this->assertSame($clientBuilder, $clientBuilder->appendPlugin($p1, $p2, $p3));
    }
}
