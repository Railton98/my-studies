<?php

use Core\Router;

require './bootstrap.php';

$router = new Router($container);
$router->create(require __DIR__ . '/../routes/web.php');
