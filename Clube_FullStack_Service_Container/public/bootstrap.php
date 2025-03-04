<?php

declare(strict_types=1);

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Core\Application;
use Core\Container;
use Core\ResolveContainer;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/definitions/constants.php';

$container = new Container(
    new ResolveContainer
);
// $container->bind(UserRepositoryInterface::class, fn() => new UserRepository);

// $container->bind('key', 'value');

$container->addDefinitions('definitions/container.php');
// $container->addDefinitions([
//     UserRepositoryInterface::class => fn() => new UserRepository,
//     'key' => 'value',
// ]);

Application::resolve($container);
