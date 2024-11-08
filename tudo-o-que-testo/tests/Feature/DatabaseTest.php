<?php

use App\Models\Product;

use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

it('should be able to create a product', function () {
    $user = User::factory()->create();

    postJson(
        route('products.store'),
        ['title' => 'Test Product', 'owner_id' => $user->id]
    )->assertCreated();

    assertTrue(Product::query()->where(['title' => 'Test Product'])->exists());

    assertDatabaseCount(Product::class, 1);
    assertDatabaseHas(Product::class, ['title' => 'Test Product']);
});

it('should be able to update a product', function () {
    $product = Product::factory()->create(['title' => 'Test Product']);

    putJson(
        route('products.update', $product),
        ['title' => 'updated Product']
    )->assertOk();

    expect($product)
        ->refresh()
        ->title->toBe('Updated Product');

    assertSame('Updated Product', $product->refresh()->title);

    assertDatabaseMissing(Product::class, ['title' => 'Test Product']);
    assertDatabaseHas(Product::class, ['title' => 'updated Product']);
    assertDatabaseCount(Product::class, 1);
});

it('should be able to delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.destroy', $product))
        ->assertNoContent();

    assertDatabaseMissing(Product::class, ['id' => $product->id]);
    assertDatabaseCount(Product::class, 0);
});

it('should be able to soft-delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.soft-delete', $product))
        ->assertNoContent();

    assertSoftDeleted(Product::class, ['id' => $product->id]);
    assertDatabaseCount(Product::class, 1);
});
