<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Library\Auth;
use App\Library\Newsletter;

class HomeController
{
    public function __construct(
        private Auth $auth
    ) {
        //
    }

    public function index(
        UserRepositoryInterface $userRepository,
        Newsletter $newsletter
    ) {
        dd(
            $userRepository->find(123),
            $this->auth->auth(),
            $newsletter->send()
        );
    }
}
