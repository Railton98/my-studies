<?php

declare(strict_types=1);

namespace Core;

class Application
{
    private static Container $container;

    public static function resolve(Container $container): void
    {
        self::$container = $container;
    }

    public static function make(string $key)
    {
        return self::$container->get($key);
    }
}
