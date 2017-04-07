<?php

namespace AdamPaterson\ApiClient\Foundation\Contract;

use Psr\Http\Message\ResponseInterface;

interface HydratorInterface
{
    public function hydrate(ResponseInterface $response);
}
