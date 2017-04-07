<?php

declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation\Api;

use AdamPaterson\ApiClient\Foundation\Exception\Domain\NotFoundException;
use AdamPaterson\ApiClient\Foundation\Exception\Domain\UnknownErrorException;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;
use AdamPaterson\ApiClient\Foundation\Http\RequestBuilder;
use AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface as Hydrator;

/**
 * Class AbstractApi
 *
 * @package AdamPaterson\ApiClient\Foundation\Api
 */
abstract class AbstractApi
{
    /**
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * @var \AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface
     */
    protected $hydrator;

    /**
     * @var \AdamPaterson\ApiClient\Foundation\Http\RequestBuilder
     */
    protected $requestBuilder;

    /**
     * AbstractApi constructor.
     *
     * @param \Http\Client\HttpClient                                       $httpClient
     * @param \AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface $hydrator
     * @param \AdamPaterson\ApiClient\Foundation\Http\RequestBuilder        $requestBuilder
     */
    public function __construct(HttpClient $httpClient, Hydrator $hydrator, RequestBuilder $requestBuilder)
    {
        $this->httpClient = $httpClient;
        $this->requestBuilder = $requestBuilder;
        $this->hydrator = $hydrator;
    }

    /**
     * @param string $path
     * @param array  $params
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function get(string $path, array $params = [], array $headers = []): ResponseInterface
    {
        if (count($params) > 0) {
            $path .= '?'.http_build_query($params);
        }

        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('GET', $path, $headers)
        );
    }

    /**
     * @param string $path
     * @param array  $params
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function post(string $path, array $params = [], $headers = []): ResponseInterface
    {
        return $this->postRaw($path, $this->createJsonBody($params), $headers);
    }

    /**
     * @param string $path
     * @param        $body
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function postRaw(string $path, $body, array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('POST', $path, $headers, $body)
        );
    }

    /**
     * @param string $path
     * @param array  $params
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function put(string $path, array $params = [], array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('PUT', $path, $headers, $this->createJsonBody($params))
        );
    }

    /**
     * @param string $path
     * @param array  $params
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function patch(string $path, array $params = [], array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('PATCH', $path, $headers, $this->createJsonBody($params))
        );
    }

    /**
     * @param string $path
     * @param array  $params
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function delete(string $path, array $params = [], array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            $this->requestBuilder->create('DELETE', $path, $headers, $this->createJsonBody($params))
        );
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \AdamPaterson\ApiClient\Foundation\Exception\Domain\NotFoundException
     * @throws \AdamPaterson\ApiClient\Foundation\Exception\Domain\UnknownErrorException
     */
    protected function handleErrors(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case 404:
                throw new NotFoundException();
                break;
            default:
                throw new UnknownErrorException();
                break;
        }
    }

    /**
     * @param array $params
     *
     * @return null|string
     */
    private function createJsonBody(array $params)
    {
        return (count($params) === 0) ? null : json_encode($params, empty($params) ? JSON_FORCE_OBJECT : 0);
    }
}
