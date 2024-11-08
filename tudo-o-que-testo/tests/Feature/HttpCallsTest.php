<?php

use App\Console\Commands\ExportProductToAmazonCommand;
use App\Console\Commands\ImportFromAmazonCommand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;

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

test('testing the data that we send to amazon', function () {
    Http::fake();
    config()->set('services.amazon.api_key', 1234314324523);

    Product::factory()->count(2)->create();

    (new ExportProductToAmazonCommand)->handle();

    Http::assertSent(function (Request $request) {
        return $request->url() === 'https://api.amazon.com/products'
            && $request->header('Authorization') === ['Bearer '.config('services.amazon.api_key')]
            && $request->data() == Product::all()->map(fn ($p) => ['title' => $p->title])->toArray();
    });
});

it('my config should have at least the key', function () {
    expect(config('services'))
        ->toHaveKey('amazon')
        ->and(config('services.amazon'))
        ->toHaveKey('api_key');
});
