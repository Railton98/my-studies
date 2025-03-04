<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Core\Application;

class HomeController
{
    public function index()
    {
        Application::make(UserRepositoryInterface::class)->find(1);
    }
}
