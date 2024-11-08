<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to create a product via command', function () {
    $user = User::factory()->create();

    artisan(
        CreateProductCommand::class,
        ['title' => 'product 1', 'user' => $user->id]
    )->assertSuccessful();

    assertDatabaseCount(Product::class, 1);
    assertDatabaseHas(Product::class, [
        'title' => 'product 1',
        'owner_id' => $user->id
    ]);
});

it('should asks for user and title if is not passed as argument', function () {
    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])
        ->expectsQuestion('Please, provide a valid title for the product', 'product 1')
        ->expectsQuestion('Please, provide a valid user id', $user->id)
        ->expectsOutputToContain('Product created!!')
        ->assertSuccessful();
});
