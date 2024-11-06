<?php

use App\Models\Product;

use function Pest\Laravel\getJson;

it('the `products` api route must return a `products` list')
    ->getJson('/api/products')
    ->assertOk()
    ->assertExactJson([
        ['title' => 'Product A'],
        ['title' => 'Product B'],
    ]);

it('should list products from database', function () {
    [$product1, $product2] = Product::factory()->count(2)->create();

    getJson('/api/products')
        ->assertOk()
        ->assertExactJson([
            ['title' => 'Product A'],
            ['title' => 'Product B'],
            ['title' => $product1->title],
            ['title' => $product2->title],
        ]);
});
