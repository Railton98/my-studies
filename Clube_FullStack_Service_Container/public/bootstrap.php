<?php

declare(strict_types=1);

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Core\Application;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/definitions/constants.php';

$container = new ContainerBuilder();
$container->useAttributes(true);

$container->addDefinitions(APP_PATH . '/definitions/container.php');
// $container->addDefinitions([
//     UserRepositoryInterface::class => fn() => new UserRepository,
//     'key' => 'value',
// ]);
$container = $container->build();

Application::resolve($container);
