<?php

declare(strict_types=1);

namespace App\Library;

use Core\Application;

class Auth
{
    public function auth()
    {
        return Application::make('key');
    }
}
