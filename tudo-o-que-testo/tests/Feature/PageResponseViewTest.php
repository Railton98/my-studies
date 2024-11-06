<?php

it('the `products` route should use the `products` view')
    ->get('/products')
    ->assertViewIs('products');

it('the `products` route must pass a `products` list to the `products` view')
    ->get('/products')
    ->assertViewIs('products')
    ->assertViewHas('products');
