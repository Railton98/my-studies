<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to upload an image', function () {
    Storage::fake('avatar');

    $user = User::factory()->create();

    $file = UploadedFile::fake()->image('image.jpg');

    actingAs($user)->post(route('upload-avatar'), [
        'file' => $file,
    ])->assertOk();

    Storage::disk('avatar')->assertExists($file->hashName());
});

it('should be to import a csv file', function () {
    [$user, $user2] = User::factory()->count(2)->create();

    $data = <<<txt
    Product 1,$user2->id
    Product 2,$user->id
    txt;

    $file = UploadedFile::fake()->create('products.csv', $data);

    actingAs($user)->post(route('import-products'), ['file' => $file])->assertOk();

    assertDatabaseCount(Product::class, 2);
    assertDatabaseHas(Product::class, [
        'title' => 'Product 1',
        'owner_id' => $user2->id,
    ]);
    assertDatabaseHas(Product::class, [
        'title' => 'Product 2',
        'owner_id' => $user->id,
    ]);
});
