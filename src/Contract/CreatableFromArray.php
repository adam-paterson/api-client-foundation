<?php

namespace AdamPaterson\ApiClient\Foundation\Contract;

interface CreatableFromArray
{
    public static function createFromArray(array $data);
}
