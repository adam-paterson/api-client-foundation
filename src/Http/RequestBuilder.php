<?php
declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation\Http;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;

/**
 * Class RequestBuilder
 *
 * @package AdamPaterson\ApiClient\Foundation\Http
 */
final class RequestBuilder
{
    /**
     * @var \Http\Message\MessageFactory|\Http\Message\RequestFactory
     */
    private $requestFactory;


    /**
     * RequestBuilder constructor.
     *
     * @param \Http\Message\RequestFactory|null $requestFactory
     */
    public function __construct(RequestFactory $requestFactory = null)
    {
        $this->requestFactory = $requestFactory ?? MessageFactoryDiscovery::find();
    }

    /**
     * Create request using request factory
     *
     * @param string $method
     * @param string $uri
     * @param array  $headers
     * @param null   $body
     * @param string $protocol
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function create(
        string $method,
        string $uri,
        array $headers = [],
        $body = null,
        $protocol = '1.1'
    ): RequestInterface {
        return $this->requestFactory->createRequest($method, $uri, $headers, $body, $protocol);
    }
}
