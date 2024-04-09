<?php

declare(strict_types=1);

use Tecks\Framework\Http\Kernel;
use Tecks\Framework\Http\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';

// request received
$request = Request::createFromGlobals();

// perform some logic
$kernel = new Kernel();

// send response (string of content)
$response = $kernel->handle($request);
$response->send();
