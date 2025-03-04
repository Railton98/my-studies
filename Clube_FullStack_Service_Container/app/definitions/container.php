<?php

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

return [
    UserRepositoryInterface::class => fn() => new UserRepository,
    'key' => 'value',
];
