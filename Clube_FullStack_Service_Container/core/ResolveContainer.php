<?php

declare(strict_types=1);

namespace Core;

use ReflectionClass;

class ResolveContainer
{
    public function parameters($method, COntainer $container)
    {
        return array_map(
            fn($param) => $container->get($param->getType()->getName()),
            $method->getParameters()
        );
    }

    public function instance(string $key, COntainer $container)
    {
        $reflection = new ReflectionClass($key);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $key;
        }

        return $reflection->newInstanceArgs(
            $this->parameters($constructor, $container)
        );
    }
}
