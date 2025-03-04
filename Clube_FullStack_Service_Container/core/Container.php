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

    public function get(string $key)
    {
        if (isset($this->bindings[$key])) {
            $bind = $this->bindings[$key];

            if ($bind instanceof \Closure) {
                return $bind();
            }

            return $bind;
        }
    }
}
