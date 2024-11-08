<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\artisan;

it('should be able to guarantee tha user exists', function () {
    artisan(
        CreateProductCommand::class,
        ['title' => 'Jeremias', 'user' => -1]
    );
})->throws(ValidationException::class);
