<?php

use App\Console\Commands\ImportFromAmazonCommand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should fake an api request', function () {
    User::factory()->create();
    
    Http::fake([
        'https://api.amazon.com/products' => Http::response([
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
        ]),
    ]);

    artisan(ImportFromAmazonCommand::class)
        ->assertSuccessful();

    assertDatabaseCount(Product::class, 2);
    assertDatabaseHas(Product::class, ['title' => 'Product 1']);
    assertDatabaseHas(Product::class, ['title' => 'Product 2']);
});
