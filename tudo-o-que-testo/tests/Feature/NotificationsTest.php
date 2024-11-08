<?php

use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;

it('should sends a notification about a new product', function () {
    Notification::fake();

    $user = User::factory()->create();

    actingAs($user)->postJson(route('products.store'), [
        'title' => 'Test product',
    ])->assertCreated();

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductNotification::class);
});
