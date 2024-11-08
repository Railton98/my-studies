<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    expect($product->owner)
        ->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should always be str()->title()', function () {
    $product = Product::factory()->create(['title' => 'test']);

    expect($product)
        ->title->toBe('Test');
});

test('model set mutator :: product code should be encrypted', function () {
    $product = Product::factory()->create(['code' => 'test']);

    expect(Hash::isHashed($product->code))
        ->toBeTrue();
});

test('model scopes :: should bring only released products', function () {
    Product::factory()->count(10)->create(['released' => true]);
    Product::factory()->count(5)->create(['released' => false]);

    expect(Product::query()->released()->get())
        ->toHaveCount(10);
});
