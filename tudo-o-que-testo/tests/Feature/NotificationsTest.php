<?php

use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\postJson;

it('should sends a notification about a new product', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson(route('products.store'), [
        'title' => 'Test product',
        'owner_id' => $user->id,
    ])->assertCreated();

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductNotification::class);
});
