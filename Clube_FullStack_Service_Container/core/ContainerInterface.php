<?php

declare(strict_types=1);

namespace Core;

interface ContainerInterface
{
    public function bind(string $key, mixed $value): void;

    public function addDefinitions(array|string $definitions): void;

    public function get(string $key);
}
