<?php

use App\Actions\CreateProductAction;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should call the action to create a product', function () {
    Notification::fake();

    // assert
    $this->mock(CreateProductAction::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    // arrange
    $user = User::factory()->create();
    $title = 'Product 1';

    // act
    actingAs($user)->postJson(route('products.store'), ['title' => $title])
        ->assertCreated();
});

it('should to be able to create a product', function () {
    Notification::fake();

    $user = User::factory()->create();

    (new CreateProductAction)->handle('Product 1', $user);

    assertDatabaseCount(Product::class, 1);
    assertDatabaseHas(Product::class, [
        'title' => 'Product 1',
        'owner_id' => $user->id,
    ]);

    Notification::assertSentTo($user, NewProductNotification::class);
});
