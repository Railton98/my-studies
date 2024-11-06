<?php

use App\Models\Product;

use function Pest\Laravel\get;

it('should list products')
    ->get('/products')
    ->assertOk()
    ->assertViewIs('products')
    ->assertSeeTextInOrder([
        'Product A',
        'Product B',
    ]);

it('should list products from database', function () {
    [$product1, $product2] = Product::factory()->count(2)->create();

    get('/products')
        ->assertOk()
        ->assertViewIs('products')
        ->assertSeeTextInOrder([
            'Product A',
            'Product B',
            $product1->title,
            $product2->title,
        ]);
});
