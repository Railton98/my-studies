<?php

declare(strict_types=1);

namespace Core;

class Container
{
    private array $bindings = [];

    public function bind(string $key, mixed $value): void
    {
        $this->bindings[$key] = $value;
    }

    public function resolveParameters($method)
    {
        return array_map(
            fn($param) => $this->get($param->getType()->getName()),
            $method->getParameters()
        );
    }

    private function getInstance(string $key)
    {
        $reflection = new \ReflectionClass($key);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $key;
        }

        return $reflection->newInstanceArgs(
            $this->resolveParameters($constructor)
        );
    }

    public function get(string $key)
    {
        if (isset($this->bindings[$key])) {
            $bind = $this->bindings[$key];

            if ($bind instanceof \Closure) {
                return $bind();
            }

            return $bind;
        }

        if (class_exists($key)) {
            return $this->getInstance($key);
        }
    }
}
