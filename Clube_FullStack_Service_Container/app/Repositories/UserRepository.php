<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
	public function find($id)
	{
        return 'find user with id ' . $id;
	}
}
