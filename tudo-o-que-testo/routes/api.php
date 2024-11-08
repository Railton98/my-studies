<?php

use App\Jobs\ImportProductsJob;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', function () {
    $products = Product::query()->get()
        ->map(fn ($p) => ['title' => $p->title]);

    return array_merge([
        ['title' => 'Product A'],
        ['title' => 'Product B'],
    ], $products->toArray());
});

Route::post('/products', function (Request $request) {
    $request->validate([
        'title' => ['required', 'max:255'],
        'owner_id' => ['required', Rule::exists(User::class, 'id')],
    ]);

    $product = Product::query()
        ->create($request->only(['title', 'owner_id']));

    $user = User::query()->findOrFail($request->owner_id);
    $user->notify(new NewProductNotification);

    return response()->json($product, Response::HTTP_CREATED);
})->name('products.store');

Route::put('/products/{product}', function (Product $product, Request $request) {
    $product->update($request->only('title'));

    return response()->json($product, Response::HTTP_OK);
})->name('products.update');

Route::delete('/products/{product}', function (Product $product) {
    $product->forceDelete();

    return response()->noContent();
})->name('products.destroy');

Route::delete('/products/{product}/soft-delete', function (Product $product) {
    $product->delete();

    return response()->noContent();
})->name('products.soft-delete');

Route::post('/import-products', function () {
    $data = request()->get('data');

    ImportProductsJob::dispatch($data, auth()->id());
})->name('products.import');
