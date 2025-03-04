<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Library\Auth;
use App\Library\Newsletter;

class HomeController
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private Auth $auth
    ) {
        //
    }

    public function index(Newsletter $newsletter)
    {
        dd(
            $this->userRepository->find(123),
            $this->auth->auth(),
            $newsletter->send()
        );
    }
}
