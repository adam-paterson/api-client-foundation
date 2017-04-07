<?php

declare(strict_types = 1);

namespace AdamPaterson\ApiClient\Foundation\Hydrator;

use AdamPaterson\ApiClient\Foundation\Contract\HydratorInterface as Hydrator;
use AdamPaterson\ApiClient\Foundation\Contract\CreatableFromArray;
use AdamPaterson\ApiClient\Foundation\Exception\HydrationException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ModelHydrator
 *
 * @package AdamPaterson\ApiClient\Foundation\Hydrator
 */
final class ModelHydrator implements Hydrator
{
    /**
     * @var $class string Class to create with response data
     */
    private $class;

    /**
     * ModelHydrator constructor.
     *
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Hydrate ResponseInterface into class/model
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
            throw new HydrationException('The ModelHydrator cannot hydrate response with Content-Type:'.$contentType);
        }

        $data = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new HydrationException(
                sprintf('Error (%d) when trying to json_decode response', json_last_error())
            );
        }

        if (is_subclass_of($this->class, CreatableFromArray::class)) {
            $object = forward_static_call([$this->class, 'createFromArray'], $data);
        } else {
            $object = new $this->class($data);
        }

        return $object;
    }
}
