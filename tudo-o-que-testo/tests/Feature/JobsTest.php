<?php

use App\Jobs\ImportProductsJob;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should dispatch a job to the queue', function () {
    Queue::fake();

    $user = User::factory()->create();

    actingAs($user)->postJson(route('products.import'), [
        'data' => [
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
            ['title' => 'Product 3'],
        ],
    ]);

    Queue::assertPushed(ImportProductsJob::class);
});

it('should import products', function () {
    $user = User::factory()->create();
    $data = [
        ['title' => 'Product 1'],
        ['title' => 'Product 2'],
        ['title' => 'Product 3'],
    ];

    (new ImportProductsJob($data, $user->id))->handle();

    assertDatabaseCount(Product::class, 3);
    assertDatabaseHas(Product::class, ['title' => 'Product 1']);
    assertDatabaseHas(Product::class, ['title' => 'Product 2']);
    assertDatabaseHas(Product::class, ['title' => 'Product 3']);
});
