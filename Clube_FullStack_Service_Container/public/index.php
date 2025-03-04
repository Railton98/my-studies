<?php

use App\Library\Auth;
use Core\Router;
use DI\Container;

require './bootstrap.php';

/** @var Container $container */
$container->get(Auth::class)->auth();
$router = new Router($container);
$router->create(require __DIR__ . '/../routes/web.php');
