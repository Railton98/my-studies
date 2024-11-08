<?php

use App\Http\Middleware\JeremiasMiddleware;
use App\Mail\WelcomeMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/forbidden', function () {
    abort(403);

    return ['route' => 'forbidden'];
});

Route::get('/products', fn () => view('products', ['products' => Product::all()]));

Route::post('/sending-email/{user}', function (User $user) {
    Mail::to($user)->send(new WelcomeMail($user));
})->name('sending-mail');

Route::get('secure-route', fn () => ['oi'])
    ->middleware(JeremiasMiddleware::class)
    ->name('secure-route');
