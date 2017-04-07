<?php
declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation;

use AdamPaterson\ApiClient\Foundation\Http\ClientBuilder;
use AdamPaterson\ApiClient\Foundation\Http\RequestBuilder;
use AdamPaterson\ApiClient\Foundation\Hydrator\ArrayHydrator;
use AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface as Hydrator;
use Http\Client\HttpClient;

/**
 * Class ApiClient
 *
 * @package AdamPaterson\ApiClient\Foundation
 */
class ApiClient
{
    /**
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * @var \AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface
     */
    private $hydrator;

    /**
     * @var \AdamPaterson\ApiClient\Foundation\Http\RequestBuilder
     */
    private $requestBuilder;

    /**
     * ApiClient constructor.
     *
     * @param \Http\Client\HttpClient                                            $httpClient
     * @param \AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface|null $hydrator
     * @param \AdamPaterson\ApiClient\Foundation\Http\RequestBuilder|null        $requestBuilder
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->httpClient = $httpClient;
        $this->hydrator = $hydrator ?? new ArrayHydrator;
        $this->requestBuilder = $requestBuilder ?? new RequestBuilder;
    }

    /**
     * Create configured client
     *
     * @param \AdamPaterson\ApiClient\Foundation\Http\ClientBuilder              $httpClientBuilder
     * @param \AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface|null $hydrator
     * @param \AdamPaterson\ApiClient\Foundation\Http\RequestBuilder|null        $requestBuilder
     *
     * @return \AdamPaterson\ApiClient\Foundation\ApiClient
     */
    public static function configure(
        ClientBuilder $httpClientBuilder,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ): self {
        $httpClient = $httpClientBuilder->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestBuilder);
    }

    /**
     * Create and configure client
     *
     * @return \AdamPaterson\ApiClient\Foundation\ApiClient
     */
    public static function create(): ApiClient
    {
        $httpClientBuilder = new ClientBuilder;

        return self::configure($httpClientBuilder);
    }
}
