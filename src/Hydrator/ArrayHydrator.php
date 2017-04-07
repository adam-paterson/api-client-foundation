<?php

declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation\Hydrator;

use AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface as HydratorContract;
use AdamPaterson\ApiClient\Foundation\Exception\HydrationException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ArrayHydrator
 *
 * @package AdamPaterson\ApiClient\Foundation\Hydrator
 */
final class ArrayHydrator implements HydratorContract
{
    /**
     * Hydrate ResponseInterface to Array
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    public function hydrate(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        $contentType = $response->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') !== 0) {
            throw new HydrationException('The ArrayHydrator cannot hydrate response with Content-Type:'.$contentType);
        }

        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new HydrationException(
                sprintf('Error (%d) when trying to json_decode response', json_last_error())
            );
        }

        return $content;
    }
}
