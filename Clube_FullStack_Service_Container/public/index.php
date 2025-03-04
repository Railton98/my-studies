<?php

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Core\Application;
use Core\Container;
use Core\Router;

require __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../routes/web.php';

$container = new Container;
$container->bind(UserRepositoryInterface::class, fn() => new UserRepository);

Application::resolve($container);

$router = new Router;
$router->create($routes);
